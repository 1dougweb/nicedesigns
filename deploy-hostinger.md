# 🚀 Deploy Laravel na Hostinger - Nice Designs

## 📋 Pré-requisitos

- [ ] Conta na Hostinger com PHP 8.1+
- [ ] Domínio configurado
- [ ] Acesso ao hPanel
- [ ] Git instalado localmente
- [ ] Composer instalado

## 🔧 1. Preparação Local

### 1.1 Otimizar para Produção
```bash
# Instalar dependências apenas de produção
composer install --optimize-autoloader --no-dev

# Limpar e otimizar cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

# Gerar chave da aplicação (se necessário)
php artisan key:generate
```

### 1.2 Configurar .env de Produção
```bash
# Criar .env.production
cp .env .env.production
```

Editar `.env.production`:
```env
APP_NAME="Nice Designs"
APP_ENV=production
APP_KEY=base64:SUA_CHAVE_AQUI
APP_DEBUG=false
APP_TIMEZONE=America/Sao_Paulo
APP_URL=https://seudominio.com

# Banco de Dados (será configurado na Hostinger)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario_banco
DB_PASSWORD=senha_banco

# Email (configurar com seu provedor)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contato@seudominio.com
MAIL_PASSWORD=sua_senha_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contato@seudominio.com
MAIL_FROM_NAME="Nice Designs"

# PagarMe (usar chaves reais)
PAGARME_API_KEY=ak_live_sua_chave_real
PAGARME_ENCRYPTION_KEY=ek_live_sua_chave_real
PAGARME_WEBHOOK_SECRET=seu_webhook_secret
PAGARME_ENVIRONMENT=live

# Cache e Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database

# Outras configurações
FILESYSTEM_DISK=local
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error
```

## 📤 2. Upload para Hostinger

### 2.1 Via File Manager (Recomendado)

1. **Acesse o hPanel da Hostinger**
2. **Vá em "File Manager"**
3. **Navegue até `public_html`**
4. **Delete conteúdo padrão se existir**

### 2.2 Estrutura de Arquivos na Hostinger
```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
├── composer.json
├── composer.lock
└── public/ (conteúdo vai para a raiz)
```

### 2.3 Upload dos Arquivos

1. **Comprimir projeto localmente:**
```bash
# Criar arquivo ZIP excluindo node_modules e .git
zip -r nicedesigns.zip . -x "node_modules/*" ".git/*" "*.log" "storage/logs/*"
```

2. **Upload via File Manager:**
   - Faça upload do `nicedesigns.zip`
   - Extraia na pasta `public_html`
   - Mova conteúdo da pasta `public/` para a raiz de `public_html`

### 2.4 Estrutura Final
```
public_html/
├── index.php (do public/)
├── .htaccess (do public/)
├── css/ (do public/)
├── js/ (do public/)
├── images/ (do public/)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
├── composer.json
└── composer.lock
```

## 🗄️ 3. Configuração do Banco de Dados

### 3.1 Criar Banco na Hostinger
1. **hPanel → Databases → MySQL Databases**
2. **Criar novo banco:** `u123456789_nicedesigns`
3. **Criar usuário:** `u123456789_admin`
4. **Definir senha forte**
5. **Associar usuário ao banco com todas as permissões**

### 3.2 Atualizar .env
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_nicedesigns
DB_USERNAME=u123456789_admin
DB_PASSWORD=sua_senha_definida
```

### 3.3 Executar Migrations
```bash
# Via Terminal SSH (se disponível) ou File Manager
php artisan migrate --force
php artisan db:seed --force
```

## ⚙️ 4. Configurações Específicas da Hostinger

### 4.1 Criar .htaccess na Raiz
Criar `public_html/.htaccess`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Redirect to public folder
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ /public/$1 [L,QSA]
    
    # Handle Laravel routes
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
</IfModule>

# Security headers
<IfModule mod_headers.c>
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Disable directory browsing
Options -Indexes

# Hide Laravel files
<Files .env>
    Order allow,deny
    Deny from all
</Files>

<Files composer.json>
    Order allow,deny
    Deny from all
</Files>

<Files composer.lock>
    Order allow,deny
    Deny from all
</Files>

<Files artisan>
    Order allow,deny
    Deny from all
</Files>
```

### 4.2 Ajustar index.php
Editar `public_html/index.php`:
```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

require __DIR__.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

### 4.3 Configurar Permissões
```bash
# Via File Manager ou SSH
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
```

## 🔐 5. Configuração de Segurança

### 5.1 SSL/HTTPS (Hostinger)
1. **hPanel → Security → SSL/TLS**
2. **Ativar "Force HTTPS"**
3. **Aguardar propagação (até 24h)**

### 5.2 Configurar Firewall
```env
# No .env
APP_URL=https://seudominio.com
FORCE_HTTPS=true
```

## 📧 6. Configuração de Email

### 6.1 Criar Email na Hostinger
1. **hPanel → Email → Email Accounts**
2. **Criar:** `contato@seudominio.com`
3. **Definir senha forte**

### 6.2 Configurar SMTP
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contato@seudominio.com
MAIL_PASSWORD=senha_do_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contato@seudominio.com
MAIL_FROM_NAME="Nice Designs"
```

## 💳 7. Configuração PagarMe Produção

### 7.1 Obter Chaves Reais
1. **Login no Dashboard PagarMe**
2. **Ir em: Configurações → Chaves de API**
3. **Copiar chaves de PRODUÇÃO (live)**

### 7.2 Configurar Webhook
- **URL do Webhook:** `https://seudominio.com/pagarme/webhook`
- **Eventos:** `charge.paid`, `charge.refunded`, `charge.waiting_payment`

### 7.3 Atualizar .env
```env
PAGARME_API_KEY=ak_live_SUA_CHAVE_REAL
PAGARME_ENCRYPTION_KEY=ek_live_SUA_CHAVE_REAL
PAGARME_WEBHOOK_SECRET=seu_webhook_secret_real
PAGARME_ENVIRONMENT=live
```

## ⚡ 8. Otimizações de Performance

### 8.1 Cache de Configuração
```bash
# Executar via SSH ou criar script
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 8.2 Configurações de Performance
```env
# No .env
APP_DEBUG=false
LOG_LEVEL=error
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database
```

## 🔄 9. Queue Worker (Opcional)

### 9.1 Configurar Cron Job
**hPanel → Advanced → Cron Jobs:**
```bash
# Executar a cada minuto
* * * * * cd /home/u123456789/public_html && php artisan queue:work --stop-when-empty
```

### 9.2 Alternativa: Cron para Schedule
```bash
# Executar Laravel Scheduler a cada minuto
* * * * * cd /home/u123456789/public_html && php artisan schedule:run >> /dev/null 2>&1
```

## 🧪 10. Teste Final

### 10.1 Checklist de Verificação
- [ ] Site carrega em `https://seudominio.com`
- [ ] Login admin funciona
- [ ] Cadastro de clientes funciona
- [ ] Criação de faturas funciona
- [ ] PagarMe teste funciona
- [ ] Emails são enviados
- [ ] SSL ativo (cadeado verde)

### 10.2 Teste PagarMe
```bash
# Via SSH ou browser
php artisan pagarme:test --show-config
```

## 🆘 11. Troubleshooting

### 11.1 Problemas Comuns

**500 Internal Server Error:**
```bash
# Verificar logs
tail -f storage/logs/laravel.log

# Limpar cache
php artisan cache:clear
php artisan config:clear
```

**Banco não conecta:**
- Verificar credenciais no .env
- Testar conexão via phpMyAdmin
- Verificar se banco existe

**PagarMe não funciona:**
- Verificar chaves de API
- Testar webhook URL
- Verificar logs do PagarMe

**Emails não enviam:**
- Verificar credenciais SMTP
- Testar email manual
- Verificar logs de email

### 11.2 Logs Importantes
```bash
# Logs do Laravel
storage/logs/laravel.log

# Logs do Servidor (via hPanel)
Error Logs → View

# Logs do PagarMe
Ver dashboard PagarMe → Logs
```

## 📱 12. Comandos Úteis

### 12.1 Deploy Script
Criar `deploy.sh`:
```bash
#!/bin/bash

echo "🚀 Iniciando deploy..."

# Backup
cp .env .env.backup.$(date +%Y%m%d_%H%M%S)

# Update code
git pull origin main

# Install dependencies
composer install --optimize-autoloader --no-dev

# Clear and cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Run migrations
php artisan migrate --force

echo "✅ Deploy concluído!"
```

### 12.2 Comandos de Manutenção
```bash
# Limpar logs antigos
php artisan log:clear

# Verificar sistema
php artisan about

# Status da aplicação
php artisan inspire
```

## 🎯 Conclusão

Seguindo este guia, sua aplicação **Nice Designs** estará rodando em produção na Hostinger com:

✅ **Performance otimizada**  
✅ **Segurança configurada**  
✅ **PagarMe funcional**  
✅ **Emails funcionais**  
✅ **SSL ativo**  
✅ **Backup estratégia**  

**Suporte:** Para dúvidas específicas, consulte a documentação da Hostinger ou entre em contato com o suporte técnico. 