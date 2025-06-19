#!/bin/bash

echo "=== SCRIPT DE DEPLOY PARA PRODUÇÃO - Nice Designs ==="
echo ""

echo "1. Configurando variáveis de ambiente para produção..."

cat > .env.prod << EOF
APP_NAME="Nice Designs"
APP_ENV=production
APP_KEY=base64:wSXV+cApeyyTW4p0gbT0B951ZIMrxqipkL+1Yq21lXE=
APP_DEBUG=false
APP_URL=https://nicedesigns.com.br

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

APP_MAINTENANCE_DRIVER=file

ABACATEPAY_TOKEN=seu_token_aqui
ABACATEPAY_ENVIRONMENT=production
ABACATEPAY_WEBHOOK_SECRET=seu_webhook_secret_aqui

PHP_CLI_SERVER_WORKERS=4
BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Configuração MySQL para produção
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u760830176_laravel
DB_USERNAME=u760830176_laravel_root
DB_PASSWORD=Graffs@500##

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.nicedesigns.com.br

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contato@nicedesigns.com.br
MAIL_PASSWORD=sua_senha_de_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contato@nicedesigns.com.br
MAIL_FROM_NAME="Nice Designs"

VITE_APP_NAME="\${APP_NAME}"
EOF

echo "✅ Arquivo .env.prod criado!"
echo ""

echo "2. Instalando dependências de produção..."
echo "composer install --optimize-autoloader --no-dev"
echo ""

echo "3. Executando migrações..."
echo "php artisan migrate --force"
echo ""

echo "4. Executando seeders (opcional)..."
echo "php artisan db:seed --force"
echo ""

echo "5. Limpando cache..."
echo "php artisan config:cache"
echo "php artisan route:cache"
echo "php artisan view:cache"
echo ""

echo "6. Criando link para storage..."
echo "php artisan storage:link"
echo ""

echo "=== INSTRUÇÕES PARA DEPLOY ==="
echo ""
echo "1. Faça upload de todos os arquivos para o servidor"
echo "2. Copie o arquivo .env.prod para .env no servidor:"
echo "   cp .env.prod .env"
echo ""
echo "3. Execute os comandos acima no servidor via SSH ou painel de controle"
echo ""
echo "4. Verifique se as permissões estão corretas:"
echo "   chmod -R 755 storage"
echo "   chmod -R 755 bootstrap/cache"
echo ""
echo "5. Configure o DocumentRoot para apontar para a pasta 'public'"
echo ""
echo "=== CONFIGURAÇÃO DO BANCO MYSQL ==="
echo ""
echo "No painel do Hostinger:"
echo "1. Vá em 'Banco de Dados MySQL'"
echo "2. Crie um banco com nome: u760830176_laravel"
echo "3. Crie um usuário: u760830176_laravel_root"
echo "4. Defina a senha: Graffs@500##"
echo "5. Associe o usuário ao banco com todas as permissões"
echo ""
echo "=== TESTANDO A CONEXÃO ==="
echo ""
echo "Após configurar tudo, teste com:"
echo "php artisan migrate:status"
echo "" 