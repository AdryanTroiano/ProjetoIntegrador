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
// ID DO DOADOR
// =========================

$id = isset($dados['id'])
    ? (int) $dados['id']
    : 0;


if ($id <= 0) {

    http_response_code(400);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'ID do doador inválido.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================
// VALIDAÇÃO
// =========================

try {

    $db = Database::connect();


    // =========================
    // VERIFICA SE EXISTE
    // =========================

    $sqlBusca = "
        SELECT
            id,
            nome,
            validado
        FROM doadores
        WHERE id = ?
        LIMIT 1
    ";

    $stmtBusca = $db->prepare($sqlBusca);

    $stmtBusca->execute([$id]);

    $doador = $stmtBusca->fetch();


    if (!$doador) {

        http_response_code(404);

        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Doador não encontrado.'
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }


    // =========================
    // JÁ ESTÁ VALIDADO
    // =========================

    if ((int) $doador['validado'] === 1) {

        http_response_code(200);

        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Este doador já está validado.',
            'validado' => 1
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }


    // =========================
    // VALIDA O DOADOR
    // =========================

    $sql = "
        UPDATE doadores
        SET validado = 1
        WHERE id = ?
    ";

    $stmt = $db->prepare($sql);

    $stmt->execute([$id]);


    // =========================
    // SUCESSO
    // =========================

    http_response_code(200);

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Doador validado com sucesso.',
        'doador' => [
            'id' => $id,
            'nome' => $doador['nome'],
            'validado' => 1
        ]
    ], JSON_UNESCAPED_UNICODE);


} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao validar o doador.'
    ], JSON_UNESCAPED_UNICODE);
}

exit;