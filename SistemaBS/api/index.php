<?php

header('Content-Type: application/json; charset=utf-8');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../app/Core/autoload.php';

http_response_code(200);

echo json_encode([
    'sucesso' => true,
    'mensagem' => 'API do SCBST funcionando!',
    'versao' => '1.0'
], JSON_UNESCAPED_UNICODE);