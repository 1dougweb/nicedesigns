#!/bin/bash

echo "🚀 Build para Produção - Nice Designs (Hospedagem Compartilhada)"

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

status "1. Configurando ambiente de produção..."

# Configurar Node.js via NVM se disponível
if [ -s "$HOME/.nvm/nvm.sh" ]; then
    source "$HOME/.nvm/nvm.sh"
    nvm use --lts 2>/dev/null || nvm use node
    success "Node.js $(node --version) ativo"
elif command -v node &> /dev/null; then
    success "Node.js $(node --version) disponível"
else
    error "Node.js não encontrado!"
    exit 1
fi

# Verificar NPM
if ! command -v npm &> /dev/null; then
    error "NPM não encontrado!"
    exit 1
fi

success "NPM $(npm --version) disponível"

status "2. Configurando variáveis de ambiente..."

# Configurar para produção
export NODE_ENV=production
export APP_ENV=production

success "Ambiente configurado para PRODUÇÃO"

status "3. Instalando dependências..."

# Instalar dependências (incluindo dev para build)
npm install

if [ $? -eq 0 ]; then
    success "Dependências instaladas!"
else
    error "Erro ao instalar dependências!"
    exit 1
fi

status "4. Limpando build anterior..."

# Limpar build anterior
if [ -d "build" ]; then
    rm -rf build
    success "Build anterior removido!"
fi

# Remover hot file se existir
if [ -f "public/hot" ]; then
    rm public/hot
    success "Arquivo hot removido!"
fi

status "5. Executando build de produção..."

# Build para produção
npm run build

if [ $? -eq 0 ]; then
    success "Build concluído com sucesso!"
else
    error "Erro no build!"
    exit 1
fi

status "6. Verificando arquivos gerados..."

# Verificar se os arquivos foram criados
if [ -d "build" ]; then
    success "Pasta build/ criada!"
    echo "Arquivos gerados:"
    ls -la build/
    
    echo ""
    echo "Assets:"
    ls -la build/assets/
    
    echo ""
    echo "Manifest:"
    cat build/manifest.json | head -10
else
    error "Pasta build/ não foi criada!"
    exit 1
fi

status "7. Estatísticas do build..."

echo ""
echo "📊 ESTATÍSTICAS:"
echo "================================"
if [ -d "build" ]; then
    echo "📁 Pasta build: $(du -sh build | cut -f1)"
    echo "📄 Arquivos CSS: $(find build -name "*.css" | wc -l)"
    echo "📄 Arquivos JS: $(find build -name "*.js" | wc -l)"
    echo "📄 Total de arquivos: $(find build -type f | wc -l)"
fi

echo ""
echo "🎉 BUILD PARA PRODUÇÃO CONCLUÍDO!"
echo ""
echo -e "${GREEN}Estrutura gerada:${NC}"
echo "  📁 build/ (pasta principal)"
echo "  📁 build/assets/ (CSS e JS compilados)"
echo "  📄 build/manifest.json (mapeamento dos arquivos)"
echo ""
echo -e "${YELLOW}Para deploy:${NC}"
echo "  1. Fazer upload da pasta build/ para public_html/"
echo "  2. Verificar se APP_ENV=production no .env"
echo "  3. Testar se assets carregam corretamente"
echo ""
echo -e "${BLUE}🚀 Pronto para PRODUÇÃO!${NC}"
echo "" 