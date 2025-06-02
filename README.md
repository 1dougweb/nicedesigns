# 🎨 Nice Designs - Agência de Web Design

Website institucional completo com sistema administrativo integrado, desenvolvido em Laravel 11 com Tailwind CSS.

![Laravel](https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql)

## 📋 Sobre o Projeto

Nice Designs é uma solução completa para agências de web design que inclui:

- **Website Institucional** com design moderno e responsivo
- **Sistema de Blog** com categorização avançada
- **Portfólio de Projetos** com galeria de imagens
- **Sistema de Contatos** com gerenciamento de leads
- **Dashboard Administrativo** completo com CRUD
- **Sistema de Autenticação** robusto
- **SEO Otimizado** em todas as páginas

## ✨ Funcionalidades Principais

### 🌐 Website Público
- **Homepage** com seções modernas (hero, serviços, portfólio, depoimentos)
- **Blog** com sistema de categorias e busca
- **Portfólio** com showcase de projetos realizados
- **Páginas Institucionais** (sobre, serviços, contato)
- **Formulário de Contato** integrado
- **Design Responsivo** para todos os dispositivos
- **Performance Otimizada** com lazy loading

### 🛠️ Dashboard Administrativo

#### 📊 Dashboard Principal
- **Estatísticas em tempo real** (posts, projetos, contatos, categorias)
- **Navegação visual** com cards interativos
- **Atividades recentes** (últimos posts e contatos)
- **Links rápidos** para todas as seções

#### 📝 Gerenciamento de Posts
- ✅ **CRUD Completo** (Create, Read, Update, Delete)
- ✅ **Editor de Conteúdo** com preview
- ✅ **Sistema de Categorias**
- ✅ **Status de Publicação** (rascunho/publicado)
- ✅ **SEO Avançado** (meta title, meta description)
- ✅ **Imagens de Destaque**
- ✅ **Agendamento de Publicação**
- ✅ **Resumos Automáticos**

#### 🎯 Gerenciamento de Projetos
- ✅ **Portfólio Completo** com galeria de imagens
- ✅ **Informações do Cliente**
- ✅ **Tecnologias Utilizadas**
- ✅ **Links dos Projetos**
- ✅ **Status de Destaque**
- ✅ **Data de Conclusão**

#### 🏷️ Gerenciamento de Categorias
- ✅ **Criação e Edição** de categorias
- ✅ **Slugs Automáticos** SEO-friendly
- ✅ **Contadores** de posts e projetos
- ✅ **Proteção contra Exclusão** (categorias com conteúdo)

#### 📧 Gerenciamento de Contatos
- ✅ **Visualização de Mensagens**
- ✅ **Sistema de Status** (novo → em andamento → concluído)
- ✅ **Filtros e Busca**
- ✅ **Estatísticas** de atendimento

## 🚀 Instalação e Configuração

### Pré-requisitos
- PHP 8.1 ou superior
- Composer
- Node.js e NPM
- MySQL 8.0 ou superior

### Passo a Passo

1. **Clone o repositório**
   ```bash
   git clone https://github.com/seu-usuario/nicedesigns.git
   cd nicedesigns
   ```

2. **Instale as dependências PHP**
   ```bash
   composer install
   ```

3. **Instale as dependências Node.js**
   ```bash
   npm install
   ```

4. **Configure o ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure o banco de dados no `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nicedesigns
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

6. **Execute as migrations e seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Compile os assets**
   ```bash
   npm run dev
   ```

8. **Inicie o servidor**
   ```bash
   php artisan serve
   ```

O site estará disponível em `http://localhost:8000`

## 🔐 Acesso Administrativo

**URL:** `http://localhost:8000/admin`

**Credenciais Padrão:**
- **Email:** `admin@nicedesigns.com.br`
- **Senha:** `password`

> ⚠️ **Importante:** Altere as credenciais padrão em produção!

## 📁 Estrutura do Projeto

```
nicedesigns/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Controladores administrativos
│   │   │   ├── DashboardController.php
│   │   │   ├── PostController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── CategoryController.php
│   │   │   └── ContactController.php
│   │   ├── HomeController.php
│   │   ├── PostController.php
│   │   ├── ProjectController.php
│   │   └── ContactController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Post.php
│   │   ├── Project.php
│   │   ├── Category.php
│   │   ├── Contact.php
│   │   ├── Page.php
│   │   └── Setting.php
│   └── Providers/
├── database/
│   ├── migrations/          # Estrutura do banco de dados
│   └── seeders/            # Dados iniciais
├── resources/
│   ├── views/
│   │   ├── admin/          # Views administrativas
│   │   │   ├── dashboard.blade.php
│   │   │   ├── posts/
│   │   │   ├── projects/
│   │   │   ├── categories/
│   │   │   └── contacts/
│   │   ├── layouts/        # Layouts base
│   │   ├── components/     # Componentes reutilizáveis
│   │   └── pages/          # Páginas públicas
│   └── css/
├── routes/
│   └── web.php             # Rotas da aplicação
└── public/
    └── assets/             # Assets compilados
```

## 🎯 Funcionalidades Técnicas

### 🔒 Autenticação e Segurança
- Sistema de login/logout completo
- Middleware de autenticação nas rotas admin
- Proteção CSRF em todos os formulários
- Validação de dados robusta
- Hash de senhas com bcrypt

### 🗄️ Banco de Dados
- **Migrations** versionadas para estrutura
- **Seeders** para dados iniciais
- **Relacionamentos Eloquent** otimizados
- **Soft Deletes** quando apropriado
- **Indexação** para performance

### 🎨 Frontend
- **Tailwind CSS** para estilização
- **Responsive Design** mobile-first
- **Componentes Blade** reutilizáveis
- **Vite** para build dos assets
- **Alpine.js** para interatividade

### 📊 Performance
- **Eager Loading** para consultas otimizadas
- **Paginação** em listagens extensas
- **Cache** de configurações
- **Lazy Loading** de imagens
- **Minificação** de assets

## 🛣️ Rotas Principais

### Rotas Públicas
```
GET  /                    # Homepage
GET  /blog                # Listagem de posts
GET  /blog/{slug}         # Post individual
GET  /portfolio           # Portfólio de projetos
GET  /portfolio/{slug}    # Projeto individual
GET  /contato            # Formulário de contato
POST /contato            # Envio de contato
GET  /{slug}             # Páginas institucionais
```

### Rotas Administrativas
```
GET  /admin                           # Dashboard
GET  /admin/posts                     # Lista de posts
GET  /admin/posts/create              # Criar post
POST /admin/posts                     # Salvar post
GET  /admin/posts/{id}/edit           # Editar post
PUT  /admin/posts/{id}               # Atualizar post
DELETE /admin/posts/{id}             # Excluir post

GET  /admin/projects                  # Lista de projetos
GET  /admin/categories               # Lista de categorias
GET  /admin/contacts                 # Lista de contatos
```

## 🔧 Configurações Importantes

### Cache
```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Gerar cache (produção)
php artisan config:cache
php artisan view:cache
php artisan route:cache
```

### Assets
```bash
# Desenvolvimento
npm run dev

# Produção
npm run build

# Watch mode
npm run dev --watch
```

### Banco de Dados
```bash
# Resetar banco
php artisan migrate:fresh --seed

# Backup
php artisan db:backup

# Rollback
php artisan migrate:rollback
```

## 📈 Próximos Passos Sugeridos

### 🚧 Funcionalidades Planejadas
- [ ] **Upload de Imagens** (substituir URLs por uploads)
- [ ] **Editor WYSIWYG** (TinyMCE ou CKEditor)
- [ ] **Gerenciamento de Páginas** estáticas
- [ ] **Configurações do Site** (logo, redes sociais, etc.)
- [ ] **Sistema de Comentários** no blog
- [ ] **Newsletter** e email marketing
- [ ] **Analytics** e relatórios
- [ ] **Otimização de Imagens** automática
- [ ] **Backup Automático**
- [ ] **Multi-idioma** (i18n)

### 🎨 Melhorias de Design
- [ ] **Dark Mode** toggle
- [ ] **Animações** com Framer Motion
- [ ] **PWA** (Progressive Web App)
- [ ] **Modo Offline**

### ⚡ Performance
- [ ] **CDN** para assets
- [ ] **Redis** para cache
- [ ] **Queue Jobs** para tarefas pesadas
- [ ] **Search Engine** (Algolia/ElasticSearch)

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -am 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença [MIT](https://opensource.org/licenses/MIT).

## 📞 Suporte

Para suporte ou dúvidas:
- **Email:** admin@nicedesigns.com.br
- **Website:** [Nice Designs](http://localhost:8000)

---

<p align="center">
  Desenvolvido com ❤️ usando <strong>Laravel</strong> e <strong>Tailwind CSS</strong>
</p>
