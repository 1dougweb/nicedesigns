/**
 * Script para suprimir avisos específicos do console
 */

// Salvar referência original da função console.warn
const originalConsoleWarn = console.warn;

// Sobrescrever console.warn para filtrar mensagens específicas
console.warn = function() {
    // Verificar se é o aviso do CDN do Tailwind
    if (arguments[0] && 
        typeof arguments[0] === 'string' && 
        (arguments[0].includes('cdn.tailwindcss.com should not be used in production') ||
         arguments[0].includes('cdn.tailwindcss.com'))) {
        // Não exibir este aviso específico
        return;
    }
    
    // Para outros avisos, chamar a função original
    return originalConsoleWarn.apply(console, arguments);
};

// Informar que os avisos estão sendo suprimidos (apenas para desenvolvimento)
console.log('Avisos específicos do CDN do Tailwind foram suprimidos.'); 