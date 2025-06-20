<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use App\Services\AbacatePayService;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller
{
    private AbacatePayService $abacatePayService;

    public function __construct(AbacatePayService $abacatePayService)
    {
        $this->abacatePayService = $abacatePayService;
    }

    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = [
            'general' => \App\Models\Setting::where('group', 'general')->get(),
            'contact' => \App\Models\Setting::where('group', 'contact')->get(),
            'social' => \App\Models\Setting::where('group', 'social')->get(),
            'seo' => \App\Models\Setting::where('group', 'seo')->get(),
            'email' => \App\Models\Setting::where('group', 'email')->get(),
            'appearance' => \App\Models\Setting::where('group', 'appearance')->get(),
            'footer' => \App\Models\Setting::where('group', 'footer')->get(),
            'editor' => \App\Models\Setting::where('group', 'editor')->get(),
            'abacatepay' => [
                'token' => Config::get('services.abacatepay.token'),
                'environment' => Config::get('services.abacatepay.environment'),
                'webhook_secret' => Config::get('services.abacatepay.webhook_secret'),
            ],
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings
     */
    public function update(Request $request)
    {
        try {
            // Processar uploads de arquivos primeiro
            $uploadedFiles = $this->handleFileUploads($request);
            
            // Mesclar os caminhos dos arquivos enviados na requisição
            $request->merge($uploadedFiles);
            
            // Validação flexível - todos os campos são opcionais mas com tipos específicos
            $validated = $request->validate([
                // Campos gerais
                'site_name' => 'nullable|string|max:255',
                'site_description' => 'nullable|string|max:500',
                'site_keywords' => 'nullable|string|max:500',
                'site_logo' => 'nullable|string|max:500',
                'site_favicon' => 'nullable|string|max:500',
                'use_logo' => 'nullable|boolean',
                
                // Campos de upload
                'site_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                'site_favicon_file' => 'nullable|image|mimes:jpeg,png,jpg,ico,svg|max:1024',
                'posts_per_page' => 'nullable|integer|min:1|max:50',
                'projects_per_page' => 'nullable|integer|min:1|max:50',
                'timezone' => 'nullable|string|max:100',
                'date_format' => 'nullable|string|max:20',
                'currency' => 'nullable|string|max:10',
                'maintenance_mode' => 'nullable|boolean',
                'allow_registration' => 'nullable|boolean',
                
                // Campos de contato
                'contact_email' => 'nullable|email|max:255',
                'contact_phone' => 'nullable|string|max:20',
                'contact_whatsapp' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'address_complement' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:50',
                'zip_code' => 'nullable|string|max:15',
                'country' => 'nullable|string|max:50',
                
                // Campos de redes sociais
                'facebook_url' => 'nullable|string|max:500',
                'instagram_url' => 'nullable|string|max:500',
                'twitter_url' => 'nullable|string|max:500',
                'linkedin_url' => 'nullable|string|max:500',
                'youtube_url' => 'nullable|string|max:500',
                'github_url' => 'nullable|string|max:500',
                'behance_url' => 'nullable|string|max:500',
                'dribbble_url' => 'nullable|string|max:500',
                
                // Campos de SEO
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'google_analytics_id' => 'nullable|string|max:100',
                'google_search_console' => 'nullable|string',
                'facebook_pixel_id' => 'nullable|string|max:100',
                
                // Campos de email
                'smtp_host' => 'nullable|string|max:100',
                'smtp_port' => 'nullable|integer|min:1|max:65535',
                'smtp_username' => 'nullable|string|max:100',
                'smtp_password' => 'nullable|string|max:100',
                'smtp_encryption' => 'nullable|string|max:10',
                'mail_from_address' => 'nullable|email|max:255',
                'mail_from_name' => 'nullable|string|max:100',
                
                // Campos de aparência
                'primary_color' => 'nullable|string|max:7',
                'secondary_color' => 'nullable|string|max:7',
                'accent_color' => 'nullable|string|max:7',
                'custom_css' => 'nullable|string',
                'custom_js' => 'nullable|string',
                
                // Campos do editor TinyMCE
                'tinymce_api_key' => 'nullable|string|max:255',
                'tinymce_plugins' => 'nullable|string',
                'tinymce_toolbar' => 'nullable|string',
                'tinymce_height' => 'nullable|integer|min:200|max:1000',
                'tinymce_content_css' => 'nullable|string',
                'tinymce_enable_upload' => 'nullable|boolean',
                'tinymce_upload_path' => 'nullable|string|max:255',
                'tinymce_max_file_size' => 'nullable|integer|min:1|max:10',
                'tinymce_allowed_extensions' => 'nullable|string',
                
                // Campos do footer
                'company_name' => 'nullable|string|max:255',
                'company_description' => 'nullable|string|max:500',
                'copyright_text' => 'nullable|string|max:255',
                'footer_text' => 'nullable|string|max:255',
                'social_twitter' => 'nullable|url|max:255',
                'social_linkedin' => 'nullable|url|max:255',
                'social_instagram' => 'nullable|url|max:255',
                'social_facebook' => 'nullable|url|max:255',
                
                // AbacatePay
                'abacatepay.token' => 'nullable|string',
                'abacatepay.environment' => 'nullable|in:sandbox,production',
                'abacatepay.webhook_secret' => 'nullable|string',
            ]);

            // Salvar configurações por grupo
            $this->saveSettingsGroup($request, 'general', [
                'site_name', 'site_description', 'site_keywords', 'site_logo', 
                'site_favicon', 'use_logo', 'maintenance_mode', 'allow_registration', 
                'posts_per_page', 'projects_per_page', 'timezone', 'date_format', 
                'currency'
            ]);

            $this->saveSettingsGroup($request, 'contact', [
                'contact_email', 'contact_phone', 'contact_whatsapp', 'address',
                'address_complement', 'city', 'state', 'zip_code', 'country'
            ]);

            $this->saveSettingsGroup($request, 'social', [
                'facebook_url', 'instagram_url', 'twitter_url', 'linkedin_url',
                'youtube_url', 'github_url', 'behance_url', 'dribbble_url'
            ]);

            $this->saveSettingsGroup($request, 'seo', [
                'meta_title', 'meta_description', 'google_analytics_id',
                'google_search_console', 'facebook_pixel_id'
            ]);

            $this->saveSettingsGroup($request, 'email', [
                'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password',
                'smtp_encryption', 'mail_from_address', 'mail_from_name'
            ]);

            $this->saveSettingsGroup($request, 'appearance', [
                'primary_color', 'secondary_color', 'accent_color', 
                'custom_css', 'custom_js'
            ]);

            $this->saveSettingsGroup($request, 'footer', [
                'company_name', 'company_description', 'copyright_text', 
                'footer_text', 'social_twitter', 'social_linkedin', 
                'social_instagram', 'social_facebook'
            ]);

            $this->saveSettingsGroup($request, 'editor', [
                'tinymce_api_key', 'tinymce_plugins', 'tinymce_toolbar', 
                'tinymce_height', 'tinymce_content_css', 'tinymce_enable_upload',
                'tinymce_upload_path', 'tinymce_max_file_size', 'tinymce_allowed_extensions'
            ]);

            // Salvar configurações do AbacatePay se estiverem presentes
            if ($request->has('abacatepay')) {
                $abacatepay = $request->input('abacatepay');
                
                if (!empty($abacatepay['token']) && !empty($abacatepay['webhook_secret']) && !empty($abacatepay['environment'])) {
                    $this->updateEnvFile([
                        'ABACATEPAY_TOKEN' => $abacatepay['token'],
                        'ABACATEPAY_ENVIRONMENT' => $abacatepay['environment'],
                        'ABACATEPAY_WEBHOOK_SECRET' => $abacatepay['webhook_secret'],
                    ]);
                    
                    // Atualiza o cache de configuração
                    Config::set('services.abacatepay.token', $abacatepay['token']);
                    Config::set('services.abacatepay.environment', $abacatepay['environment']);
                    Config::set('services.abacatepay.webhook_secret', $abacatepay['webhook_secret']);
                }
            }

            // Limpar cache de configurações
            try {
                Artisan::call('config:clear');
                Artisan::call('view:clear');
            } catch (\Exception $cacheException) {
                \Log::warning('Aviso: Erro ao limpar cache (continuando...): ' . $cacheException->getMessage());
            }

            return Redirect::route('admin.settings.index')
                ->with('success', 'Configurações atualizadas com sucesso!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erro de validação ao salvar configurações:', [
                'errors' => $e->errors(),
                'user_id' => auth()->id(),
            ]);
            
            return Redirect::route('admin.settings.index')
                ->withErrors($e->errors())
                ->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Erro geral ao salvar configurações: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => auth()->id(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Redirect::route('admin.settings.index')
                ->with('error', 'Erro ao salvar configurações: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Save settings for a specific group
     */
    private function saveSettingsGroup(Request $request, string $group, array $keys): void
    {
        foreach ($keys as $key) {
            $value = $request->input($key);
            $type = $this->getSettingType($key, $value);
            
            // Para checkboxes, verificar se foi enviado
            if ($type === 'boolean') {
                $value = $request->has($key) ? true : false;
            }
            
            // Para valores nulos em strings, usar string vazia
            if ($type === 'string' && is_null($value)) {
                $value = '';
            }
            
            try {
                Setting::set($key, $value, $type, $group);
            } catch (\Exception $e) {
                \Log::error("Erro ao salvar configuração {$key}: " . $e->getMessage(), [
                    'group' => $group,
                    'value' => $value,
                    'type' => $type,
                    'exception' => $e
                ]);
                throw $e;
            }
        }
    }

    /**
     * Determine the setting type based on key and value
     */
    private function getSettingType(string $key, mixed $value): string
    {
        // Boolean settings
        if (in_array($key, ['maintenance_mode', 'allow_registration', 'use_logo', 'tinymce_enable_upload'])) {
            return 'boolean';
        }
        
        // Integer settings
        if (in_array($key, ['posts_per_page', 'projects_per_page', 'smtp_port', 'tinymce_height', 'tinymce_max_file_size'])) {
            return 'integer';
        }
        
        // Text/Textarea settings
        if (in_array($key, ['custom_css', 'custom_js', 'google_search_console'])) {
            return 'text';
        }
        
        return 'string';
    }

    /**
     * Test email configuration
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            // Configurar temporariamente as configurações de email das settings
            $this->updateEmailConfig();
            
            // Enviar email de teste
            \Mail::to($request->test_email)->send(new \App\Mail\TestEmail());
            
            return response()->json([
                'success' => true,
                'message' => 'Email de teste enviado com sucesso para ' . $request->test_email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update email configuration from settings
     */
    private function updateEmailConfig()
    {
        $emailSettings = Setting::where('group', 'email')->get()->keyBy('key');
        
        if ($emailSettings->isNotEmpty()) {
            // Configurar o mail config temporariamente
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $emailSettings->get('smtp_host')->value ?? 'smtp.gmail.com',
                'mail.mailers.smtp.port' => $emailSettings->get('smtp_port')->value ?? 587,
                'mail.mailers.smtp.username' => $emailSettings->get('smtp_username')->value ?? '',
                'mail.mailers.smtp.password' => $emailSettings->get('smtp_password')->value ?? '',
                'mail.mailers.smtp.encryption' => $emailSettings->get('smtp_encryption')->value ?? 'tls',
                'mail.from.address' => $emailSettings->get('mail_from_address')->value ?? 'noreply@nicedesigns.com.br',
                'mail.from.name' => $emailSettings->get('mail_from_name')->value ?? 'Nice Designs',
            ]);
        }
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        try {
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('cache:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'Cache limpo com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao limpar cache: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display SEO management page
     */
    public function seoIndex()
    {
        $robotsContent = $this->getRobotsContent();
        $sitemapExists = file_exists(public_path('sitemap.xml'));
        $sitemapLastGenerated = $sitemapExists ? 
            \Carbon\Carbon::createFromTimestamp(filemtime(public_path('sitemap.xml')))->format('d/m/Y H:i') 
            : 'Nunca';
        
        $urlCounts = [
            'pages' => 5,
            'posts' => \App\Models\Post::where('is_published', true)->count(),
            'projects' => \App\Models\Project::where('is_published', true)->count(),
            'categories' => \App\Models\Category::count(),
        ];
        
        return view('admin.seo.index', compact('robotsContent', 'sitemapExists', 'sitemapLastGenerated', 'urlCounts'));
    }

    /**
     * Generate sitemap.xml
     */
    public function generateSitemap()
    {
        try {
            $sitemap = $this->buildSitemapXml();
            file_put_contents(public_path('sitemap.xml'), $sitemap);
            
            return response()->json([
                'success' => true,
                'message' => 'Sitemap gerado com sucesso!',
                'timestamp' => \Carbon\Carbon::now()->format('d/m/Y H:i')
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar sitemap: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar sitemap: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update robots.txt
     */
    public function updateRobots(Request $request)
    {
        $request->validate(['robots_content' => 'required|string']);

        try {
            file_put_contents(public_path('robots.txt'), $request->robots_content);
            
            return response()->json([
                'success' => true,
                'message' => 'Robots.txt atualizado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar robots.txt: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset robots.txt to default
     */
    public function resetRobots()
    {
        try {
            $defaultRobots = $this->getDefaultRobotsContent();
            file_put_contents(public_path('robots.txt'), $defaultRobots);
            
            return response()->json([
                'success' => true,
                'message' => 'Robots.txt restaurado!',
                'content' => $defaultRobots
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao restaurar robots.txt: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Build sitemap XML content
     */
    private function buildSitemapXml(): string
    {
        // Forçar o uso do domínio configurado no .env
        $baseUrl = env('APP_URL', 'https://nicedesigns.com.br');
        
        // Verificar se a URL está correta (não é localhost)
        if (strpos($baseUrl, 'localhost') !== false) {
            $baseUrl = 'https://nicedesigns.com.br';
        }
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static pages
        $staticPages = [
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => '/sobre', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/contato', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/blog', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => '/portfolio', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ];

        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}{$page['url']}</loc>\n";
            $xml .= "    <lastmod>" . \Carbon\Carbon::now()->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        // Blog posts
        $posts = \App\Models\Post::where('is_published', true)
            ->select('slug', 'updated_at')
            ->get();

        foreach ($posts as $post) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/blog/{$post->slug}</loc>\n";
            $xml .= "    <lastmod>" . $post->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.6</priority>\n";
            $xml .= "  </url>\n";
        }

        // Portfolio projects
        $projects = \App\Models\Project::where('is_published', true)
            ->select('slug', 'updated_at')
            ->get();

        foreach ($projects as $project) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/portfolio/{$project->slug}</loc>\n";
            $xml .= "    <lastmod>" . $project->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        // Categories
        $categories = \App\Models\Category::select('slug', 'updated_at')->get();

        foreach ($categories as $category) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/blog/categoria/{$category->slug}</loc>\n";
            $xml .= "    <lastmod>" . $category->updated_at->format('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.5</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';
        return $xml;
    }

    /**
     * Get current robots.txt content
     */
    private function getRobotsContent(): string
    {
        $robotsPath = public_path('robots.txt');
        
        if (file_exists($robotsPath)) {
            return file_get_contents($robotsPath);
        }
        
        return $this->getDefaultRobotsContent();
    }

    /**
     * Get default robots.txt content
     */
    private function getDefaultRobotsContent(): string
    {
        $baseUrl = config('app.url');
        
        return "User-agent: *\n" .
               "Disallow: /admin/\n" .
               "Disallow: /client/\n" .
               "Disallow: /api/\n" .
               "Disallow: /vendor/\n" .
               "Disallow: /storage/\n" .
               "Disallow: /bootstrap/\n" .
               "Allow: /\n" .
               "\n" .
               "# Sitemap\n" .
               "Sitemap: {$baseUrl}/sitemap.xml\n";
    }

    /**
     * Testar conexão com o AbacatePay
     */
    public function testAbacatePayConnection()
    {
        try {
            $result = $this->abacatePayService->testConnection();

            if ($result['success']) {
                return redirect()
                    ->route('admin.settings.index')
                    ->with('success', 'Conexão com AbacatePay testada com sucesso!');
            }

            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Erro ao testar conexão com AbacatePay. Verifique suas credenciais.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Erro ao testar conexão com AbacatePay: ' . $e->getMessage());
        }
    }

    public function abacatePay()
    {
        $settings = [
            'token' => Config::get('services.abacatepay.token'),
            'environment' => Config::get('services.abacatepay.environment'),
            'webhook_secret' => Config::get('services.abacatepay.webhook_secret'),
        ];

        return view('admin.settings.abacatepay', compact('settings'));
    }

    public function storeAbacatePay(Request $request)
    {
        $validated = $request->validate([
            'abacatepay.token' => 'required|string',
            'abacatepay.environment' => 'required|in:sandbox,production',
            'abacatepay.webhook_secret' => 'required|string',
        ]);

        // Atualiza o arquivo .env
        $this->updateEnvFile([
            'ABACATEPAY_TOKEN' => $validated['abacatepay']['token'],
            'ABACATEPAY_ENVIRONMENT' => $validated['abacatepay']['environment'],
            'ABACATEPAY_WEBHOOK_SECRET' => $validated['abacatepay']['webhook_secret'],
        ]);

        // Limpa o cache de configuração
        Config::set('services.abacatepay.token', $validated['abacatepay']['token']);
        Config::set('services.abacatepay.environment', $validated['abacatepay']['environment']);
        Config::set('services.abacatepay.webhook_secret', $validated['abacatepay']['webhook_secret']);

        Artisan::call('config:clear');

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Configurações do AbacatePay salvas com sucesso!');
    }

    private function updateEnvFile(array $values)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        foreach ($values as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        file_put_contents($envFile, $envContent);
    }

    /**
     * Handle file uploads for logo and favicon
     */
    private function handleFileUploads(Request $request): array
    {
        $uploadedFiles = [];

        // Handle logo upload
        if ($request->hasFile('site_logo_file')) {
            $logoFile = $request->file('site_logo_file');
            $logoName = 'logo.' . $logoFile->getClientOriginalExtension();
            $logoPath = $logoFile->storeAs('site', $logoName, 'public');
            $uploadedFiles['site_logo'] = '/storage/' . $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon_file')) {
            $faviconFile = $request->file('site_favicon_file');
            $faviconName = 'favicon.' . $faviconFile->getClientOriginalExtension();
            $faviconPath = $faviconFile->storeAs('site', $faviconName, 'public');
            $uploadedFiles['site_favicon'] = '/storage/' . $faviconPath;
        }

        return $uploadedFiles;
    }
}
