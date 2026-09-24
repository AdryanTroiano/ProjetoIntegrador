<?php

header('Content-Type: application/json; charset=utf-8');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../../app/Core/autoload.php';
require_once __DIR__ . '/../../config/database.php';


// =========================
// VERIFICA O MÉTODO
// =========================

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {

    http_response_code(405);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método não permitido.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================
// BUSCA OS DOADORES
// =========================

try {

    $db = Database::connect();

    $sql = "
        SELECT
            d.id,
            d.nome,
            d.cpf,
            d.sexo,
            d.nasc,
            d.email,
            d.telefone,
            d.cep,
            d.endereco,
            d.numero,
            d.bairro,
            d.complemento,
            d.peso,
            d.datedonation,
            d.validado,
            ts.tipo AS tipo_sangue
        FROM doadores d

        LEFT JOIN tipos_sangue ts
            ON ts.id = d.tipo_sangue_id

        ORDER BY d.nome ASC
    ";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $doadores = $stmt->fetchAll();


    // Converte validado para número 0 ou 1
    foreach ($doadores as &$doador) {
        $doador['id'] = (int) $doador['id'];
        $doador['validado'] = (int) $doador['validado'];
    }

    unset($doador);


    // =========================
    // RESPOSTA
    // =========================

    http_response_code(200);

    echo json_encode(
        $doadores,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );


} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao buscar os doadores.'
    ], JSON_UNESCAPED_UNICODE);
}

exit;