#!/bin/bash

echo "🎨 Compilando Assets do Nice Designs para Produção (Hospedagem Compartilhada)..."

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

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
if [ ! -f "vite.config.js" ]; then
    error "Este script deve ser executado na raiz do projeto Laravel!"
    exit 1
fi

status "1. Configurando Node.js com NVM..."

# Carregar NVM se disponível (já instalado)
if [ -s "$HOME/.nvm/nvm.sh" ]; then
    source "$HOME/.nvm/nvm.sh"
    nvm use --lts 2>/dev/null || nvm use node
    success "NVM carregado! Node.js $(node --version) ativo"
elif command -v node &> /dev/null; then
    success "Node.js $(node --version) disponível!"
else
    error "Node.js não encontrado!"
    exit 1
fi

# Verificar se npm está disponível
if ! command -v npm &> /dev/null; then
    error "NPM não encontrado!"
    exit 1
fi

success "NPM $(npm --version) disponível!"

status "2. Limpando instalação anterior..."

# Remover node_modules e lock files para instalação limpa
if [ -d "node_modules" ]; then
    rm -rf node_modules
    success "node_modules removido!"
fi

if [ -f "package-lock.json" ]; then
    rm package-lock.json
    success "package-lock.json removido!"
fi

status "3. Instalando dependências para produção..."

# Configurar npm para produção
export NODE_ENV=production

# Instalar dependências
npm install --production=false

if [ $? -eq 0 ]; then
    success "Dependências instaladas!"
else
    error "Erro ao instalar dependências!"
    exit 1
fi

status "4. Limpando assets antigos..."

# Remover assets antigos
if [ -d "public/build" ]; then
    rm -rf public/build
    success "Assets antigos removidos!"
fi

# Remover hot file se existir
if [ -f "public/hot" ]; then
    rm public/hot
    success "Arquivo hot removido!"
fi

status "5. Compilando assets para PRODUÇÃO..."

# Build para produção com Vite
npm run build

if [ $? -eq 0 ]; then
    success "Assets compilados com sucesso!"
else
    error "Erro ao compilar assets!"
    exit 1
fi

status "6. Verificando arquivos gerados..."

# Verificar se os arquivos foram criados
if [ -d "public/build" ]; then
    success "Pasta public/build criada!"
    echo "Arquivos gerados:"
    ls -la public/build/
    
    # Mostrar tamanho dos arquivos
    echo ""
    echo "Tamanhos dos arquivos:"
    du -sh public/build/*
else
    error "Pasta public/build não foi criada!"
    exit 1
fi

status "7. Preparando estrutura para hospedagem compartilhada..."

# Criar pasta para deploy
mkdir -p deploy-ready

# Como index.php está na raiz, ajustar estrutura
status "Configurando para index.php na raiz..."

# Copiar build para pasta de deploy 
cp -r public/build deploy-ready/

# Verificar manifest
if [ -f "public/build/manifest.json" ]; then
    success "Manifest.json encontrado!"
    echo "Preview do manifest:"
    head -10 public/build/manifest.json
else
    warning "Manifest.json não encontrado!"
fi

success "Assets preparados em: deploy-ready/"

status "8. Criando instruções de deploy para hospedagem compartilhada..."

cat > deploy-instructions.txt << 'EOF'
🚀 INSTRUÇÕES PARA DEPLOY - NICE DESIGNS (Produção)

📁 ESTRUTURA ATUAL:
   ✅ index.php está na raiz (correto para hospedagem compartilhada)
   ✅ Assets compilados em deploy-ready/build/

📋 PASSOS PARA HOSPEDAGEM COMPARTILHADA:

1. UPLOAD DOS ASSETS:
   □ Acessar File Manager da hospedagem
   □ Navegar até public_html/ (ou pasta do domínio)
   □ Fazer upload da pasta deploy-ready/build/
   □ Renomear para apenas "build"

2. ESTRUTURA FINAL NO SERVIDOR:
   public_html/ (ou pasta do domínio)
   ├── index.php (já deve estar aqui)
   ├── build/
   │   ├── assets/
   │   │   ├── app-[hash].css
   │   │   ├── app-[hash].js
   │   │   └── [outros arquivos]
   │   └── manifest.json
   ├── .htaccess
   └── ... (outros arquivos Laravel)

3. CONFIGURAÇÃO NVM NO SERVIDOR (se disponível):
   □ SSH no servidor: ssh usuario@servidor
   □ Instalar NVM: curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
   □ Recarregar: source ~/.bashrc
   □ Instalar Node LTS: nvm install --lts && nvm use --lts

4. VERIFICAÇÃO:
   □ Acessar: https://seudominio.com/build/manifest.json
   □ Deve mostrar JSON com mapping dos assets
   □ Verificar se CSS/JS carregam na página

⚠️ IMPORTANTE PARA PRODUÇÃO:
   - Assets são cacheados com hash único
   - Sempre fazer upload completo da pasta build/
   - Verificar se .htaccess está configurado corretamente
   - Configurar APP_ENV=production no .env

🔄 PARA ATUALIZAÇÕES:
   1. Executar: ./build-assets.sh
   2. Upload da nova pasta deploy-ready/build/
   3. Limpar cache do navegador se necessário

🐛 TROUBLESHOOTING:
   - Assets não carregam: Verificar caminhos no manifest.json
   - Erro 404: Verificar se pasta build/ existe
   - CSS quebrado: Verificar se build foi feito para produção
   - JS não funciona: Verificar console do navegador

📞 LOGS ÚTEIS:
   - Build: npm run build -- --debug
   - Servidor: tail -f storage/logs/laravel.log
EOF

success "Instruções criadas: deploy-instructions.txt"

status "9. Otimizações finais..."

# Mostrar estatísticas finais
echo ""
echo "📊 ESTATÍSTICAS DO BUILD:"
echo "================================"
if [ -d "deploy-ready/build" ]; then
    echo "📁 Pasta build: $(du -sh deploy-ready/build | cut -f1)"
    echo "📄 Arquivos CSS: $(find deploy-ready/build -name "*.css" | wc -l)"
    echo "📄 Arquivos JS: $(find deploy-ready/build -name "*.js" | wc -l)"
    echo "📄 Outros assets: $(find deploy-ready/build -type f ! -name "*.css" ! -name "*.js" | wc -l)"
fi

echo ""
echo "🎉 BUILD PARA PRODUÇÃO CONCLUÍDA!"
echo ""
echo -e "${GREEN}Arquivos prontos para deploy:${NC}"
echo "  📁 deploy-ready/build/ (fazer upload para public_html/build/)"
echo "  📋 deploy-instructions.txt (instruções detalhadas)"
echo ""
echo -e "${YELLOW}Próximos passos:${NC}"
echo "  1. Fazer upload da pasta deploy-ready/build/ para o servidor"
echo "  2. Verificar se assets carregam corretamente"
echo "  3. Configurar .env para produção (APP_ENV=production)"
echo "  4. Limpar cache: php artisan config:clear"
echo ""
echo -e "${BLUE}🚀 Sua aplicação está pronta para PRODUÇÃO!${NC}"
echo ""

# Mostrar próximos comandos úteis
echo -e "${YELLOW}Comandos úteis no servidor:${NC}"
echo "  composer install --no-dev --optimize-autoloader"
echo "  php artisan config:cache"
echo "  php artisan route:cache"
echo "  php artisan view:cache"
echo "" 