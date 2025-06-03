#!/bin/bash

echo "🚀 Preparando Nice Designs para Deploy na Hostinger..."

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Função para exibir status
status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Verificar se estamos no diretório correto
if [ ! -f "artisan" ]; then
    error "Este script deve ser executado na raiz do projeto Laravel!"
    exit 1
fi

status "1. Verificando dependências..."

# Verificar se composer está instalado
if ! command -v composer &> /dev/null; then
    error "Composer não encontrado! Instale o Composer primeiro."
    exit 1
fi

# Verificar se php está instalado
if ! command -v php &> /dev/null; then
    error "PHP não encontrado! Instale o PHP primeiro."
    exit 1
fi

success "Dependências verificadas!"

status "2. Limpando cache e otimizando..."

# Limpar todos os caches
php artisan config:clear
php artisan cache:clear 
php artisan route:clear
php artisan view:clear
php artisan event:clear

success "Cache limpo!"

status "3. Instalando dependências de produção..."

# Instalar dependências apenas de produção
composer install --optimize-autoloader --no-dev --no-interaction

if [ $? -eq 0 ]; then
    success "Dependências instaladas!"
else
    error "Erro ao instalar dependências!"
    exit 1
fi

status "4. Otimizando para produção..."

# Cache de configuração, rotas e views
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

success "Aplicação otimizada!"

status "5. Verificando configurações críticas..."

# Verificar se APP_KEY existe
if grep -q "APP_KEY=base64:" .env; then
    success "APP_KEY configurada!"
else
    warning "APP_KEY não encontrada! Executando php artisan key:generate..."
    php artisan key:generate
fi

# Verificar permissões críticas
status "6. Configurando permissões..."

chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

success "Permissões configuradas!"

status "7. Criando arquivo ZIP para upload..."

# Criar pasta temporária
mkdir -p temp_deploy

# Copiar arquivos necessários (excluindo node_modules, .git, etc.)
rsync -av --progress . temp_deploy/ \
    --exclude='node_modules' \
    --exclude='.git' \
    --exclude='storage/logs/*.log' \
    --exclude='*.log' \
    --exclude='temp_deploy' \
    --exclude='tests' \
    --exclude='.phpunit.result.cache' \
    --exclude='coverage'

# Criar ZIP
cd temp_deploy
zip -r ../nicedesigns-production.zip . -q

cd ..
rm -rf temp_deploy

success "Arquivo nicedesigns-production.zip criado!"

status "8. Gerando checklist de deploy..."

cat > deploy-checklist.txt << 'EOF'
📋 CHECKLIST DE DEPLOY - NICE DESIGNS

□ 1. PREPARAÇÃO LOCAL ✅
   □ Cache limpo
   □ Dependências de produção instaladas
   □ Aplicação otimizada
   □ ZIP criado (nicedesigns-production.zip)

□ 2. HOSTINGER - CONFIGURAÇÃO
   □ Banco de dados criado no hPanel
   □ Email configurado (contato@seudominio.com)
   □ SSL/HTTPS ativado

□ 3. UPLOAD
   □ Fazer upload do nicedesigns-production.zip
   □ Extrair na pasta public_html
   □ Mover conteúdo de public/ para raiz
   □ Configurar .env com dados reais

□ 4. CONFIGURAÇÃO .ENV PRODUÇÃO
   □ APP_ENV=production
   □ APP_DEBUG=false
   □ APP_URL=https://seudominio.com
   □ DB_* configurações do banco
   □ MAIL_* configurações de email
   □ PAGARME_* chaves reais de produção

□ 5. COMANDOS FINAIS (via SSH ou File Manager)
   □ php artisan migrate --force
   □ php artisan db:seed --force
   □ php artisan optimize

□ 6. CONFIGURAÇÃO PAGARME
   □ Webhook URL: https://seudominio.com/pagarme/webhook
   □ Chaves de produção (ak_live_ e ek_live_)
   □ Teste de transação

□ 7. TESTE FINAL
   □ Site carrega sem erro
   □ Login admin funciona
   □ Criação de cliente funciona
   □ Geração de boleto funciona
   □ Email enviado

🎯 APÓS DEPLOY:
   - Testar todas as funcionalidades
   - Verificar logs em storage/logs/
   - Configurar backup automático
   - Monitorar performance

📞 SUPORTE:
   - Documentação: deploy-hostinger.md
   - Logs Laravel: storage/logs/laravel.log
   - Logs Hostinger: hPanel → Error Logs
EOF

success "Checklist criado: deploy-checklist.txt"

status "9. Criando .env.production de exemplo..."

cat > .env.production << 'EOF'
APP_NAME="Nice Designs"
APP_ENV=production
APP_KEY=base64:SUA_CHAVE_AQUI
APP_DEBUG=false
APP_TIMEZONE=America/Sao_Paulo
APP_URL=https://seudominio.com

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_nicedesigns
DB_USERNAME=u123456789_admin
DB_PASSWORD=SUA_SENHA_DO_BANCO

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contato@seudominio.com
MAIL_PASSWORD=SUA_SENHA_EMAIL
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contato@seudominio.com
MAIL_FROM_NAME="Nice Designs"

# PagarMe - CHAVES REAIS DE PRODUÇÃO
PAGARME_API_KEY=ak_live_SUA_CHAVE_REAL
PAGARME_ENCRYPTION_KEY=ek_live_SUA_CHAVE_REAL
PAGARME_WEBHOOK_SECRET=SEU_WEBHOOK_SECRET_REAL
PAGARME_ENVIRONMENT=live
EOF

success ".env.production criado!"

echo ""
echo "🎉 PREPARAÇÃO CONCLUÍDA!"
echo ""
echo -e "${GREEN}Arquivos criados:${NC}"
echo "  📦 nicedesigns-production.zip (para upload)"
echo "  📋 deploy-checklist.txt (checklist completo)"
echo "  ⚙️  .env.production (configurações de produção)"
echo "  📖 deploy-hostinger.md (guia completo)"
echo ""
echo -e "${YELLOW}Próximos passos:${NC}"
echo "  1. Leia o deploy-checklist.txt"
echo "  2. Configure banco e email na Hostinger"
echo "  3. Faça upload do nicedesigns-production.zip"
echo "  4. Configure .env com dados reais"
echo "  5. Execute migrations via SSH"
echo ""
echo -e "${BLUE}📖 Guia completo em: deploy-hostinger.md${NC}"
echo "" 