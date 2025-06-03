# 🎨 Nice Designs - Agência de Web Design

Website institucional completo com sistema administrativo integrado e **área do cliente**, desenvolvido em Laravel 11 com Tailwind CSS.

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
- **Área do Cliente** com portal exclusivo
- **Sistema de Autenticação** robusto com múltiplos perfis
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

### 👤 Área do Cliente

#### 🏠 Dashboard do Cliente
- **Visão Geral** com estatísticas personalizadas
- **Navegação Intuitiva** com menu lateral
- **Acesso Rápido** a todas as funcionalidades
- **Design Responsivo** e moderno

#### 📂 Gerenciamento de Projetos
- ✅ **Acompanhamento em Tempo Real** do progresso dos projetos
- ✅ **Etapas Visuais** (Design → Frontend → Backend → Deploy)
- ✅ **Barras de Progresso** com percentuais
- ✅ **Status Detalhados** (Em andamento, Aguardando aprovação, Concluído)
- ✅ **Tecnologias Utilizadas** em cada projeto
- ✅ **Marcos e Prazos** claramente definidos
- ✅ **Filtros** por status (Todos, Em Andamento, Concluídos, Pausados)
- ✅ **Downloads** de arquivos e documentação
- ✅ **Histórico** de atualizações

#### 🧾 Controle de Faturas
- ✅ **Visualização Completa** de todas as faturas
- ✅ **Status de Pagamento** (Paga, Pendente, Vencida)
- ✅ **Resumo Financeiro** com totais e estatísticas
- ✅ **Métodos de Pagamento** disponíveis (PIX, Boleto, Transferência)
- ✅ **Download de PDFs** das faturas
- ✅ **Histórico de Pagamentos** com comprovantes
- ✅ **Alertas de Vencimento** com contadores
- ✅ **Filtros** por status de pagamento
- ✅ **Integração** com gateways de pagamento

#### 🎧 Sistema de Suporte
- ✅ **Abertura de Tickets** com priorização
- ✅ **Acompanhamento** de status (Aberto, Em Andamento, Resolvido)
- ✅ **Sistema de Prioridades** (Urgente, Normal, Baixa)
- ✅ **Comentários e Anexos** nos tickets
- ✅ **Histórico Completo** de interações
- ✅ **Estatísticas** de atendimento
- ✅ **Filtros** por status e prioridade
- ✅ **Notificações** de atualizações
- ✅ **Horários de Atendimento** e contatos de emergência
- ✅ **SLA** e tempo de resposta

#### 👤 Perfil do Cliente
- ✅ **Informações Pessoais** editáveis
- ✅ **Alteração de Senha** segura
- ✅ **Preferências de Notificação** personalizáveis
- ✅ **Estatísticas da Conta** (projetos, faturas, tickets)
- ✅ **Avatar Personalizado** com iniciais
- ✅ **Histórico de Atividades**
- ✅ **Download de Dados** pessoais
- ✅ **Exportação de Relatórios**
- ✅ **Configurações de Privacidade**

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

## 🔐 Acesso ao Sistema

### Dashboard Administrativo
**URL:** `http://localhost:8000/admin`

**Credenciais Padrão:**
- **Email:** `admin@nicedesigns.com.br`
- **Senha:** `password`

### Área do Cliente
**URL:** `http://localhost:8000/client`

**Credenciais de Teste:**
- **Email:** `cliente@exemplo.com`
- **Senha:** `password`

> ⚠️ **Importante:** Altere as credenciais padrão em produção!

## 📁 Estrutura do Projeto

```
nicedesigns/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/                    # Controladores administrativos
│   │   │   ├── DashboardController.php
│   │   │   ├── PostController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── CategoryController.php
│   │   │   └── ContactController.php
│   │   ├── Client/                   # Controladores da área do cliente
│   │   │   ├── DashboardController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── InvoiceController.php
│   │   │   ├── SupportController.php
│   │   │   └── ProfileController.php
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
│   │   ├── Invoice.php                # Novo modelo para faturas
│   │   ├── Ticket.php                 # Novo modelo para tickets
│   │   ├── Page.php
│   │   └── Setting.php
│   ├── Middleware/
│   │   ├── CheckAdminRole.php         # Middleware para admins
│   │   └── CheckClientRole.php        # Middleware para clientes
│   └── Providers/
├── database/
│   ├── migrations/                    # Estrutura do banco de dados
│   └── seeders/                      # Dados iniciais
├── resources/
│   ├── views/
│   │   ├── admin/                    # Views administrativas
│   │   │   ├── dashboard.blade.php
│   │   │   ├── posts/
│   │   │   ├── projects/
│   │   │   ├── categories/
│   │   │   └── contacts/
│   │   ├── client/                   # Views da área do cliente
│   │   │   ├── dashboard.blade.php
│   │   │   ├── projects.blade.php
│   │   │   ├── invoices.blade.php
│   │   │   ├── support.blade.php
│   │   │   └── profile.blade.php
│   │   ├── layouts/                  # Layouts base
│   │   │   ├── app.blade.php         # Layout público
│   │   │   ├── admin.blade.php       # Layout administrativo
│   │   │   └── client.blade.php      # Layout da área do cliente
│   │   ├── components/               # Componentes reutilizáveis
│   │   └── pages/                    # Páginas públicas
│   └── css/
├── routes/
│   └── web.php                       # Rotas da aplicação
└── public/
    └── assets/                       # Assets compilados
```

## 🎯 Funcionalidades Técnicas

### 🔒 Autenticação e Segurança
- Sistema de login/logout completo
- **Múltiplos perfis** (Admin, Cliente)
- **Middleware específico** para cada área
- Proteção CSRF em todos os formulários
- Validação de dados robusta
- Hash de senhas com bcrypt

### 🗄️ Banco de Dados
- **Migrations** versionadas para estrutura
- **Seeders** para dados iniciais
- **Relacionamentos Eloquent** otimizados
- **Soft Deletes** quando apropriado
- **Indexação** para performance
- **Modelos** específicos para cada funcionalidade

### 🎨 Frontend
- **Tailwind CSS** para estilização
- **Design System** consistente
- **Responsive Design** mobile-first
- **Componentes Blade** reutilizáveis
- **Vite** para build dos assets
- **Alpine.js** para interatividade
- **Dark Theme** moderno com backdrop blur

### 📊 Performance
- **Eager Loading** para consultas otimizadas
- **Paginação** em listagens extensas
- **Cache** de configurações e views
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
GET  /admin                           # Dashboard administrativo
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

### Rotas da Área do Cliente
```
GET  /client                         # Dashboard do cliente
GET  /client/projects                # Meus projetos
GET  /client/projects/{id}           # Detalhes do projeto
GET  /client/invoices                # Minhas faturas
GET  /client/invoices/{id}           # Detalhes da fatura
POST /client/invoices/{id}/pay       # Pagar fatura
GET  /client/support                 # Sistema de suporte
POST /client/support/tickets         # Criar ticket
GET  /client/support/tickets/{id}    # Ver ticket
POST /client/support/tickets/{id}/reply # Responder ticket
GET  /client/profile                 # Meu perfil
PUT  /client/profile                 # Atualizar perfil
PUT  /client/profile/password        # Alterar senha
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

### Comandos Personalizados
```bash
# Criar usuário cliente
php artisan make:client {email} {name} {password}

# Gerar relatórios
php artisan reports:generate

# Limpar arquivos temporários
php artisan cleanup:temp-files
```

## 📈 Próximos Passos Sugeridos

### 🚧 Funcionalidades Planejadas

#### Área Administrativa
- [ ] **Upload de Imagens** (substituir URLs por uploads)
- [ ] **Editor WYSIWYG** (TinyMCE ou CKEditor)
- [ ] **Gerenciamento de Páginas** estáticas
- [ ] **Configurações do Site** (logo, redes sociais, etc.)
- [ ] **Sistema de Comentários** no blog
- [ ] **Newsletter** e email marketing
- [ ] **Analytics** e relatórios avançados

#### Área do Cliente
- [ ] **Sistema de Aprovações** para projetos
- [ ] **Chat em Tempo Real** com a equipe
- [ ] **Upload de Arquivos** pelo cliente
- [ ] **Calendário** de reuniões e prazos
- [ ] **Avaliações** e feedback de projetos
- [ ] **Notificações Push** em tempo real
- [ ] **App Mobile** para clientes
- [ ] **Integração** com ferramentas de project management

#### Integrações
- [ ] **Gateway de Pagamento** (Stripe, PagSeguro, Mercado Pago)
- [ ] **WhatsApp Business API** para suporte
- [ ] **Google Analytics** e Google Tag Manager
- [ ] **CRM** (HubSpot, Pipedrive)
- [ ] **Email Marketing** (Mailchimp, SendGrid)
- [ ] **Backup Automático** (AWS S3, Google Drive)

### 🎨 Melhorias de Design
- [ ] **Dark Mode** toggle
- [ ] **Animações** com Framer Motion
- [ ] **PWA** (Progressive Web App)
- [ ] **Modo Offline**
- [ ] **Temas Personalizáveis** para clientes

### ⚡ Performance e Escalabilidade
- [ ] **CDN** para assets
- [ ] **Redis** para cache
- [ ] **Queue Jobs** para tarefas pesadas
- [ ] **Search Engine** (Algolia/ElasticSearch)
- [ ] **API REST** completa
- [ ] **Multi-tenancy** para múltiplas agências

## 🧪 Testes

### Executar Testes
```bash
# Todos os testes
php artisan test

# Testes específicos
php artisan test --filter=ClientAreaTest

# Com cobertura
php artisan test --coverage
```

### Tipos de Teste Implementados
- **Unit Tests** para models e helpers
- **Feature Tests** para rotas e controladores
- **Browser Tests** com Laravel Dusk
- **API Tests** para endpoints

## 🚀 Deploy e Produção

### Configurações de Produção
```bash
# Otimizar aplicação
php artisan optimize
composer install --optimize-autoloader --no-dev

# Configurar cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Assets
npm run build
```

### Variáveis de Ambiente Importantes
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seudominio.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-host
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password

# Mail
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password

# Payment Gateway
STRIPE_KEY=your-stripe-key
STRIPE_SECRET=your-stripe-secret
```

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -am 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

### Padrões de Código
- Seguir PSR-12
- Usar Laravel Best Practices
- Documentar funções complexas
- Escrever testes para novas funcionalidades
- Manter commits semânticos

## 📞 Suporte

Para suporte ou dúvidas:
- **Email:** admin@nicedesigns.com.br
- **Website:** [Nice Designs](http://localhost:8000)
- **Documentação:** [Wiki do Projeto](link-para-wiki)
- **Issues:** [GitHub Issues](link-para-issues)

## 📄 Licença

Este projeto está sob a licença [MIT](https://opensource.org/licenses/MIT).

---

<p align="center">
  Desenvolvido com ❤️ usando <strong>Laravel 11</strong>, <strong>Tailwind CSS</strong> e <strong>Alpine.js</strong>
</p>

<p align="center">
  <strong>Nice Designs</strong> - Transformando ideias em experiências digitais excepcionais
</p>
