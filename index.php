<?php
declare(strict_types=1);

/**
 * Proxy para a pasta public do Laravel
 * 
 * Este arquivo permite que o conteúdo da pasta public seja servido
 * diretamente na raiz do domínio (seudominio.com) sem mostrar /public/ na URL.
 */

// Verifica se a pasta public existe
if (!is_dir(__DIR__ . '/public')) {
    http_response_code(500);
    die('Erro: Pasta public não encontrada. Verifique a estrutura do projeto Laravel.');
}

// Obtém a URL requisitada
$request = $_SERVER['REQUEST_URI'] ?? '/';

// Remove query string da URL se existir
$path = parse_url($request, PHP_URL_PATH);

// Normaliza o path (remove barras duplas, etc.)
$path = '/' . trim($path, '/');
if ($path === '/') {
    $path = '/index.php';
}

// Caminho completo para o arquivo na pasta public
$publicPath = __DIR__ . '/public' . $path;

// Se é um arquivo que existe na pasta public, serve o arquivo
if (is_file($publicPath)) {
    // Define o tipo MIME apropriado
    $extension = strtolower(pathinfo($publicPath, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'pdf' => 'application/pdf',
        'zip' => 'application/zip',
        'txt' => 'text/plain',
        'xml' => 'application/xml',
        'json' => 'application/json',
    ];
    
    $mimeType = $mimeTypes[$extension] ?? mime_content_type($publicPath);
    header('Content-Type: ' . $mimeType);
    
    // Para arquivos PHP, não queremos servir diretamente, deixamos o Laravel processar
    if ($extension !== 'php') {
        readfile($publicPath);
        exit;
    }
}

// Se chegou até aqui, deixa o Laravel processar a requisição
// Ajusta as variáveis do servidor para simular que estamos na pasta public
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/public/index.php';
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/public';

// Inclui o index.php do Laravel na pasta public
require_once __DIR__ . '/public/index.php'; 