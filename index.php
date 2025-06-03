<?php
declare(strict_types=1);

/**
 * Redirecionamento para a pasta public do Laravel
 * 
 * Este arquivo permite que o projeto Laravel funcione mesmo quando
 * o servidor web não está configurado para apontar diretamente
 * para a pasta public como document root.
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

// Se a requisição é para a raiz, redireciona para public/
if ($path === '/' || $path === '') {
    // Redireciona para a pasta public
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $newUrl = $protocol . $host . '/public/';
    
    header('Location: ' . $newUrl, true, 301);
    exit;
}

// Para outras requisições, tenta incluir o arquivo da pasta public
$publicPath = __DIR__ . '/public' . $path;

// Se é um arquivo que existe na pasta public, serve o arquivo
if (is_file($publicPath)) {
    $mimeType = mime_content_type($publicPath);
    header('Content-Type: ' . $mimeType);
    readfile($publicPath);
    exit;
}

// Se não encontrou o arquivo, redireciona para o index.php da pasta public
// para que o Laravel possa processar a rota
require_once __DIR__ . '/public/index.php'; 