<?php

header('Content-Type: application/json; charset=utf-8');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../../app/Core/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método não permitido.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================
// RECEBE O JSON
// =========================

$conteudo = file_get_contents('php://input');

$dados = json_decode($conteudo, true);


if (!is_array($dados)) {
    http_response_code(400);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'JSON inválido.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================
// CAMPOS
// =========================

$usuario = trim($dados['usuario'] ?? '');
$senha = $dados['senha'] ?? '';


if ($usuario === '' || $senha === '') {
    http_response_code(400);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Usuário e senha são obrigatórios.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================
// BUSCA O USUÁRIO
// =========================

$model = new Usuario();

$usuarioEncontrado =
    $model->buscarPorUsuario($usuario);


if (!$usuarioEncontrado) {
    http_response_code(401);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Usuário ou senha incorretos.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================
// VERIFICA A SENHA
// =========================

if (
    !password_verify(
        $senha,
        $usuarioEncontrado['senha']
    )
) {
    http_response_code(401);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Usuário ou senha incorretos.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================
// LOGIN REALIZADO
// =========================

http_response_code(200);

echo json_encode([
    'sucesso' => true,

    'mensagem' => 'Login realizado com sucesso.',

    'usuario' => [
        'id' => (int) $usuarioEncontrado['id'],
        'nome' => $usuarioEncontrado['usuario'],
        'nivel' => $usuarioEncontrado['nivel']
    ]

], JSON_UNESCAPED_UNICODE);

exit;