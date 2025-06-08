# Migração do Tailwind CSS para CDN

## Resumo das Alterações

O projeto foi migrado do Tailwind CSS compilado via Vite para o Tailwind CSS via CDN. Esta mudança simplifica o processo de build e reduz a complexidade do projeto.

## Arquivos Modificados

### Layouts Blade
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/admin.blade.php`
- `resources/views/layouts/client.blade.php`
- `resources/layouts/app.blade.php`
- `resources/views/welcome.blade.php`

**Alterações realizadas:**
- Removido `@vite(['resources/css/app.css', 'resources/js/app.js'])`
- Adicionado `@vite(['resources/js/app.js'])` (apenas JS)
- Adicionado CDN do Tailwind: `<script src="https://cdn.tailwindcss.com"></script>`
- Adicionada configuração personalizada do Tailwind inline

### Configuração do Vite
- `vite.config.js`: Removido `resources/css/app.css` do input

### Arquivos CSS
- `resources/css/app.css`: Mantido para referência, mas não é mais compilado

## Configuração Personalizada

Foi adicionada uma configuração básica do Tailwind em cada layout:

```javascript
tailwind.config = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', 'ui-sans-serif', 'system-ui'],
            },
        }
    }
}
```

## Vantagens da Migração

1. **Simplicidade**: Não é necessário compilar CSS
2. **Desenvolvimento mais rápido**: Mudanças são aplicadas instantaneamente
3. **Menor complexidade de build**: Menos dependências e configurações
4. **Facilidade de deploy**: Não precisa gerar assets CSS

## Desvantagens

1. **Tamanho**: O CDN inclui todas as classes do Tailwind (não há purging)
2. **Dependência externa**: Requer conexão com internet para carregar o CDN
3. **Customização limitada**: Configurações avançadas são mais difíceis

## Como Usar

Agora você pode usar todas as classes do Tailwind CSS diretamente nos seus templates Blade sem precisar compilar nada. As classes serão aplicadas automaticamente.

## Reverter para Compilação Local

Se precisar reverter para a compilação local:

1. Restaure o `@vite(['resources/css/app.css', 'resources/js/app.js'])` nos layouts
2. Remova o script CDN do Tailwind
3. Restaure o `resources/css/app.css` no `vite.config.js`
4. Execute `npm run build` ou `npm run dev`

## Comandos de Build

- **Desenvolvimento**: `npm run dev` (apenas para JS agora)
- **Produção**: `npm run build` (apenas para JS agora)

O CSS do Tailwind será carregado diretamente do CDN em ambos os casos. 