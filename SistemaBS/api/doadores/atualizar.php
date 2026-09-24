<?php

header('Content-Type: application/json; charset=utf-8');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../../config/database.php';


// =========================
// VERIFICA O MÉTODO
// =========================

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {

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
// DADOS
// =========================

$id = isset($dados['id'])
    ? (int) $dados['id']
    : 0;

$email = trim($dados['email'] ?? '');

$telefone = trim($dados['telefone'] ?? '');


// =========================
// VALIDAÇÕES
// =========================

if ($id <= 0) {

    http_response_code(400);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'ID do doador inválido.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


if (
    $email !== '' &&
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {

    http_response_code(400);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'E-mail inválido.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================
// ATUALIZA O DOADOR
// =========================

try {

    $db = Database::connect();


    // Verifica se o doador existe

    $sqlBusca = "
        SELECT id
        FROM doadores
        WHERE id = ?
        LIMIT 1
    ";

    $stmtBusca = $db->prepare($sqlBusca);

    $stmtBusca->execute([$id]);


    if (!$stmtBusca->fetch()) {

        http_response_code(404);

        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Doador não encontrado.'
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }


    // Atualiza somente os dados de contato

    $sql = "
        UPDATE doadores
        SET
            email = ?,
            telefone = ?
        WHERE id = ?
    ";

    $stmt = $db->prepare($sql);

    $stmt->execute([
        $email,
        $telefone,
        $id
    ]);


    // =========================
    // SUCESSO
    // =========================

    http_response_code(200);

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Dados do doador atualizados com sucesso.'
    ], JSON_UNESCAPED_UNICODE);


} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao atualizar o doador.',
        'erro' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

exit;