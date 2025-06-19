# 📱 Funcionalidades de Câmera Mobile - Nice Designs

## ✅ Implementado

### 🤳 Tirar Selfie para Avatar
- **Localização**: Perfil do Cliente (versão mobile)
- **Funcionalidade**: Botão verde "📱 Tirar Selfie" que abre a câmera frontal
- **Upload automático**: A foto é enviada diretamente para o servidor
- **Interface**: Modal fullscreen com controles de câmera

### 📄 Fotografar Documento
- **Localização**: Campo CPF/CNPJ (versão mobile)
- **Funcionalidade**: Botão azul "📱 Fotografar Documento" com overlay de moldura
- **OCR Futuro**: Preparado para integração com serviços de OCR
- **Interface**: Modal com guias visuais para posicionamento do documento

## 🎯 Recursos da Interface

### 🎥 Modal de Câmera
- **Design**: Interface fullscreen escura e moderna
- **Controles**:
  - 🔄 Alternar entre câmera frontal/traseira
  - 📸 Botão de captura centralizado
  - 💡 Toggle do flash (quando disponível)
  - ❌ Fechar câmera

### 📱 Funcionalidades Mobile
- **Detecção automática**: Botões só aparecem em dispositivos mobile
- **Permissões**: Solicita acesso à câmera automaticamente
- **Orientação**: Suporte tanto para portrait quanto landscape
- **Responsivo**: Interface se adapta ao tamanho da tela

### 🎨 UX/UI
- **Instruções claras**: Diferentes textos para cada modo (selfie/documento)
- **Preview de foto**: Possibilidade de revisar antes de confirmar
- **Feedback visual**: Loadings e estados de sucesso/erro
- **Fallback**: Se câmera não estiver disponível, botões ficam ocultos

## 🔧 Aspectos Técnicos

### 📋 APIs Utilizadas
- `navigator.mediaDevices.getUserMedia()` - Acesso à câmera
- `Canvas API` - Captura e processamento de imagem
- `Blob API` - Conversão para upload
- `Fetch API` - Upload assíncrono

### 🚀 Performance
- **Qualidade de imagem**: JPEG com 80% de qualidade
- **Resolução**: 1280x720 (quando suportado)
- **Compressão**: Imagens otimizadas automaticamente

### 🔒 Segurança
- **CSRF Protection**: Tokens incluídos em todos os uploads
- **Validação**: Tipos de arquivo e tamanho verificados
- **Permissões**: Usuário deve autorizar acesso à câmera

## 📋 Como Usar

### Para Clientes:
1. **Acesse o perfil** no mobile
2. **Toque em "📱 Tirar Selfie"** na seção de avatar
3. **Ou toque "📱 Fotografar Documento"** no campo CPF/CNPJ
4. **Permita o acesso** à câmera quando solicitado
5. **Posicione** adequadamente (rosto ou documento)
6. **Toque no botão** central para capturar
7. **Revise** a foto na tela de preview
8. **Confirme** ou tire uma nova foto

### Estados da Interface:
- ✅ **Mobile**: Botões de câmera visíveis
- 🖥️ **Desktop**: Botões ocultos (usar input file normal)
- 🚫 **Sem câmera**: Botões automaticamente ocultos
- ⚠️ **Sem permissão**: Alerta para dar permissão

## 🔮 Melhorias Futuras

### 🤖 OCR para Documentos
- Integração com Google Vision API ou AWS Textract
- Extração automática de CPF/CNPJ
- Preenchimento automático dos campos

### 📸 Filtros e Edição
- Ajuste de brilho/contraste
- Crop automático de documentos
- Filtros para melhorar legibilidade

### 🔄 Múltiplas Fotos
- Frente e verso de documentos
- Galeria de documentos do cliente
- Histórico de fotos enviadas

## ⚡ Compatibilidade
- ✅ iOS Safari 11+
- ✅ Android Chrome 60+
- ✅ Samsung Internet 7+
- ✅ Firefox Mobile 60+
- ❌ Navegadores antigos (fallback para input file) 