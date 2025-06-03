#!/bin/bash

echo "🎨 Compilando Assets do Nice Designs para Hospedagem Compartilhada..."

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

status "1. Verificando dependências Node.js..."

# Verificar se node está instalado
if ! command -v node &> /dev/null; then
    error "Node.js não encontrado! Instale o Node.js primeiro."
    echo "Visite: https://nodejs.org/"
    exit 1
fi

# Verificar se npm está instalado
if ! command -v npm &> /dev/null; then
    error "NPM não encontrado! Instale o NPM primeiro."
    exit 1
fi

success "Node.js $(node --version) e NPM $(npm --version) detectados!"

status "2. Instalando dependências..."

# Instalar dependências de desenvolvimento
npm install

if [ $? -eq 0 ]; then
    success "Dependências instaladas!"
else
    error "Erro ao instalar dependências!"
    exit 1
fi

status "3. Compilando assets para produção..."

# Build para produção com Vite
npm run build

if [ $? -eq 0 ]; then
    success "Assets compilados com sucesso!"
else
    error "Erro ao compilar assets!"
    exit 1
fi

status "4. Verificando arquivos gerados..."

# Verificar se os arquivos foram criados
if [ -d "public/build" ]; then
    success "Pasta public/build criada!"
    echo "Arquivos gerados:"
    ls -la public/build/
else
    error "Pasta public/build não foi criada!"
    exit 1
fi

status "5. Criando estrutura para hospedagem compartilhada..."

# Criar pasta temporária para assets compilados
mkdir -p assets-compiled

# Copiar apenas os assets compilados
cp -r public/build assets-compiled/
cp public/mix-manifest.json assets-compiled/ 2>/dev/null || echo "mix-manifest.json não encontrado (normal para Vite)"

# Verificar se existe hot file do Vite
if [ -f "public/hot" ]; then
    rm public/hot
    warning "Arquivo 'hot' removido (apenas para desenvolvimento)"
fi

success "Assets preparados em: assets-compiled/"

status "6. Criando arquivo de instruções..."

cat > assets-deploy-instructions.txt << 'EOF'
🎨 INSTRUÇÕES PARA DEPLOY DOS ASSETS - NICE DESIGNS

📦 ARQUIVOS COMPILADOS:
   assets-compiled/build/ → Upload para public_html/build/

📋 PASSOS PARA HOSPEDAGEM COMPARTILHADA:

1. UPLOAD VIA HOSTINGER FILE MANAGER:
   □ Acessar hPanel → File Manager
   □ Navegar até public_html/
   □ Fazer upload da pasta assets-compiled/build/
   □ Renomear para apenas "build"

2. ESTRUTURA FINAL NO SERVIDOR:
   public_html/
   ├── build/
   │   ├── assets/
   │   │   ├── app-[hash].css
   │   │   └── app-[hash].js
   │   └── manifest.json
   └── ... (outros arquivos Laravel)

3. VERIFICAÇÃO:
   □ Acessar: https://seudominio.com/build/manifest.json
   □ Deve mostrar JSON com mapping dos assets
   □ CSS e JS devem carregar corretamente

⚠️ IMPORTANTE:
   - Não fazer upload da pasta node_modules/
   - Não fazer upload dos arquivos fonte (resources/css, resources/js)
   - Apenas a pasta build/ compilada é necessária

🔄 PARA ATUALIZAÇÕES:
   1. Executar este script novamente: ./build-assets.sh
   2. Fazer upload apenas da nova pasta build/
   3. Vite automaticamente gera novos hashes para cache

📞 SUPORTE:
   - Logs do build: Verificar output do npm run build
   - Assets não carregam: Verificar caminhos no manifest.json
   - Erro 404: Verificar se pasta build/ existe no servidor
EOF

success "Instruções criadas: assets-deploy-instructions.txt"

echo ""
echo "🎉 COMPILAÇÃO CONCLUÍDA!"
echo ""
echo -e "${GREEN}Arquivos criados:${NC}"
echo "  📁 assets-compiled/build/ (para upload)"
echo "  📋 assets-deploy-instructions.txt (instruções)"
echo ""
echo -e "${YELLOW}Próximos passos:${NC}"
echo "  1. Fazer upload da pasta assets-compiled/build/ para public_html/build/"
echo "  2. Verificar se assets carregam no navegador"
echo "  3. Para mudanças, rodar este script novamente"
echo ""
echo -e "${BLUE}ℹ️  Sua aplicação Laravel + Vite está pronta para hospedagem compartilhada!${NC}"
echo "" 