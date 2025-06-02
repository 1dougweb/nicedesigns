# 👨‍💻 Documentação Técnica para Desenvolvedores

Este documento contém informações técnicas detalhadas sobre a arquitetura e implementação do projeto Nice Designs.

## 🏗️ Arquitetura do Sistema

### MVC Pattern
O projeto segue o padrão MVC (Model-View-Controller) do Laravel:

- **Models**: Representam as entidades de negócio e interações com banco de dados
- **Views**: Templates Blade para renderização da interface
- **Controllers**: Lógica de aplicação e coordenação entre Models e Views

### Estrutura de Diretórios

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/              # Controladores administrativos
│   │   │   ├── DashboardController.php
│   │   │   ├── PostController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── CategoryController.php
│   │   │   └── ContactController.php
│   │   ├── HomeController.php  # Página inicial
│   │   ├── PostController.php  # Blog público
│   │   ├── ProjectController.php # Portfólio público
│   │   ├── ContactController.php # Formulário de contato
│   │   └── PageController.php  # Páginas estáticas
│   └── Middleware/
│       └── Authenticate.php    # Middleware de autenticação
├── Models/
│   ├── User.php               # Usuários do sistema
│   ├── Post.php               # Posts do blog
│   ├── Project.php            # Projetos do portfólio
│   ├── Category.php           # Categorias
│   ├── Contact.php            # Mensagens de contato
│   ├── Page.php               # Páginas estáticas
│   └── Setting.php            # Configurações do site
└── Providers/
    ├── AppServiceProvider.php
    └── RouteServiceProvider.php
```

## 🗃️ Banco de Dados

### Schema Principal

#### Tabela `users`
```sql
- id (bigint, PK)
- name (varchar)
- email (varchar, unique)
- email_verified_at (timestamp)
- password (varchar)
- remember_token (varchar)
- created_at (timestamp)
- updated_at (timestamp)
```

#### Tabela `categories`
```sql
- id (bigint, PK)
- name (varchar)
- slug (varchar, unique)
- description (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

#### Tabela `posts`
```sql
- id (bigint, PK)
- title (varchar)
- slug (varchar, unique)
- content (longtext)
- excerpt (text, nullable)
- featured_image (varchar, nullable)
- meta_title (varchar, nullable)
- meta_description (text, nullable)
- is_published (boolean, default: false)
- published_at (timestamp, nullable)
- category_id (bigint, FK → categories.id)
- user_id (bigint, FK → users.id)
- created_at (timestamp)
- updated_at (timestamp)
```

#### Tabela `projects`
```sql
- id (bigint, PK)
- title (varchar)
- slug (varchar, unique)
- description (varchar)
- content (longtext)
- client_name (varchar, nullable)
- project_url (varchar, nullable)
- featured_image (varchar, nullable)
- images (json, nullable)
- technologies (json, nullable)
- completion_date (date, nullable)
- is_featured (boolean, default: false)
- is_published (boolean, default: false)
- category_id (bigint, FK → categories.id)
- user_id (bigint, FK → users.id)
- created_at (timestamp)
- updated_at (timestamp)
```

#### Tabela `contacts`
```sql
- id (bigint, PK)
- name (varchar)
- email (varchar)
- phone (varchar, nullable)
- subject (varchar)
- message (longtext)
- status (enum: new, in_progress, completed)
- notes (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### Relacionamentos

#### Eloquent Relationships

**User Model:**
```php
public function posts() {
    return $this->hasMany(Post::class);
}

public function projects() {
    return $this->hasMany(Project::class);
}
```

**Category Model:**
```php
public function posts() {
    return $this->hasMany(Post::class);
}

public function projects() {
    return $this->hasMany(Project::class);
}
```

**Post Model:**
```php
public function category() {
    return $this->belongsTo(Category::class);
}

public function author() {
    return $this->belongsTo(User::class, 'user_id');
}

// Scopes
public function scopePublished($query) {
    return $query->where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now());
}
```

## 🔒 Sistema de Autenticação

### Middleware de Proteção
```php
// routes/web.php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', PostController::class);
    Route::resource('projects', ProjectController::class);
    // ...
});
```

### Redirecionamentos
- **Login:** `/login` → Formulário de login
- **Logout:** `/logout` → Redirecionamento para home
- **Admin sem autenticação:** → Redirecionamento para login
- **Login bem-sucedido:** → Dashboard admin

## 🎨 Frontend Architecture

### Blade Templates

#### Layout Principal
```php
<!-- resources/views/layouts/app.blade.php -->
@include('components.navigation')
@yield('content')
@include('components.footer')
```

#### Componentes Reutilizáveis
```php
<!-- resources/views/components/hero.blade.php -->
<!-- resources/views/components/navigation.blade.php -->
<!-- resources/views/components/footer.blade.php -->
<!-- resources/views/components/post-card.blade.php -->
<!-- resources/views/components/project-card.blade.php -->
```

### Tailwind CSS Classes

#### Design System
```css
/* Cores principais */
.text-primary: #1E40AF (blue-800)
.text-secondary: #6B7280 (gray-500)
.bg-primary: #3B82F6 (blue-500)
.bg-dark: #111827 (gray-900)

/* Espaçamentos */
.spacing-section: py-16 lg:py-24
.spacing-content: px-4 sm:px-6 lg:px-8
.max-width-content: max-w-7xl mx-auto
```

### Assets Pipeline
```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

## 🔄 CRUD Operations

### Controladores Administrativos

#### PostController Pattern
```php
class PostController extends Controller
{
    public function index(): View {
        $posts = Post::with(['category', 'author'])
            ->latest()
            ->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            // ...
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        Post::create($validated);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post criado com sucesso!');
    }
}
```

### Validação de Dados

#### Form Requests (Futuro)
```php
// app/Http/Requests/PostRequest.php
class PostRequest extends FormRequest
{
    public function rules() {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'url'],
            'category_id' => ['required', 'exists:categories,id'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
```

## 🚀 Performance Optimizations

### Database Queries

#### Eager Loading
```php
// Evita N+1 queries
$posts = Post::with(['category', 'author'])->get();
$projects = Project::with(['category', 'creator'])->get();
```

#### Query Scopes
```php
// Model Post
public function scopePublished($query) {
    return $query->where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now());
}

// Uso
$publishedPosts = Post::published()->latest()->get();
```

### Cache Strategy (Futuro)
```php
// Cache de configurações
$settings = Cache::remember('site.settings', 3600, function () {
    return Setting::pluck('value', 'key');
});

// Cache de categorias
$categories = Cache::remember('categories.all', 1800, function () {
    return Category::withCount(['posts', 'projects'])->get();
});
```

## 🧪 Testing Strategy

### Unit Tests (Futuro)
```php
// tests/Unit/PostTest.php
class PostTest extends TestCase
{
    public function test_post_can_be_created() {
        $post = Post::factory()->create();
        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }

    public function test_published_scope_filters_correctly() {
        // Test published scope
    }
}
```

### Feature Tests (Futuro)
```php
// tests/Feature/AdminPostTest.php
class AdminPostTest extends TestCase
{
    public function test_admin_can_create_post() {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/admin/posts', [
                'title' => 'Test Post',
                'content' => 'Test content',
                'category_id' => 1,
            ]);

        $response->assertRedirect('/admin/posts');
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }
}
```

## 🐛 Error Handling

### Exception Handling
```php
// app/Exceptions/Handler.php
public function render($request, Throwable $exception)
{
    if ($exception instanceof ModelNotFoundException) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        return response()->view('errors.404', [], 404);
    }

    return parent::render($request, $exception);
}
```

### Custom Error Pages
```php
// resources/views/errors/404.blade.php
// resources/views/errors/500.blade.php
// resources/views/errors/403.blade.php
```

## 📊 Logging

### Custom Logging
```php
use Illuminate\Support\Facades\Log;

// Em controladores
Log::info('Post created', ['post_id' => $post->id, 'user_id' => auth()->id()]);
Log::warning('Unauthorized access attempt', ['ip' => $request->ip()]);
Log::error('Database connection failed', ['exception' => $e->getMessage()]);
```

## 🔧 Environment Configuration

### Variáveis de Ambiente Importantes
```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nicedesigns
DB_USERNAME=root
DB_PASSWORD=

# Mail (para contatos)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls

# Application
APP_NAME="Nice Designs"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Cache (produção)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## 🚦 Deployment

### Production Checklist
```bash
# 1. Otimizações
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 2. Migrations
php artisan migrate --force

# 3. Assets
npm run build

# 4. Permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# 5. Environment
APP_ENV=production
APP_DEBUG=false
```

## 📈 Monitoring & Analytics

### Application Metrics (Futuro)
```php
// Performance monitoring
Route::middleware(['throttle:60,1'])->group(function () {
    // Rate limited routes
});

// Database query monitoring
DB::listen(function ($query) {
    if ($query->time > 1000) {
        Log::warning('Slow query detected', [
            'sql' => $query->sql,
            'time' => $query->time
        ]);
    }
});
```

## 🔄 Git Workflow

### Branch Strategy
```
main              # Produção
├── develop       # Desenvolvimento
├── feature/*     # Novas funcionalidades
├── hotfix/*      # Correções urgentes
└── release/*     # Preparação para produção
```

### Commit Convention
```
feat: adiciona sistema de comentários
fix: corrige erro na validação de posts
docs: atualiza documentação da API
style: formata código PHP
refactor: melhora estrutura do dashboard
test: adiciona testes para PostController
```

---

**💡 Dica:** Este documento deve ser mantido atualizado conforme o projeto evolui. 