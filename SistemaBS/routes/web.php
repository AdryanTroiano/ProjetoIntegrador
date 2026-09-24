<?php

require_once __DIR__ . '/../app/Core/autoload.php';

$rota = $_GET['rota'] ?? 'home';

switch ($rota) {

    // =========================
    // ROTAS PÚBLICAS
    // =========================

    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;

    case 'autenticar':
        $controller = new AuthController();
        $controller->autenticar();
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;


    // =========================
    // DOADORES
    // =========================

    case 'doadores':
        AuthMiddleware::verificarLogin();
        $controller = new DoadorController();
        $controller->index();
        break;

    case 'novo':
        AuthMiddleware::verificarLogin();
        $controller = new DoadorController();
        $controller->create();
        break;

    case 'cadastrar-doador':
        AuthMiddleware::verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            break;
        }

        $controller = new DoadorController();
        $controller->store();
        break;

    case 'doador':
        AuthMiddleware::verificarLogin();

        $id = isset($_GET['id'])
            ? (int) $_GET['id']
            : 0;

        $controller = new DoadorController();
        $controller->show($id);
        break;

    case 'editar':
        AuthMiddleware::verificarLogin();

        $id = isset($_GET['id'])
            ? (int) $_GET['id']
            : 0;

        $controller = new DoadorController();
        $controller->edit($id);
        break;

    case 'atualizar-doador':
        AuthMiddleware::verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            break;
        }

        $controller = new DoadorController();
        $controller->update();
        break;

    case 'excluir':
        AuthMiddleware::verificarLogin();

        $id = isset($_GET['id'])
            ? (int) $_GET['id']
            : 0;

        $controller = new DoadorController();
        $controller->delete($id);
        break;


    // =========================
    // DOAÇÕES
    // =========================

    case 'nova-doacao':
        AuthMiddleware::verificarLogin();
        $controller = new DoacaoController();
        $controller->create();
        break;

    case 'cadastrar-doacao':
        AuthMiddleware::verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            break;
        }

        $controller = new DoacaoController();
        $controller->store();
        break;

    case 'doacoes':
        AuthMiddleware::verificarLogin();
        $controller = new DoacaoController();
        $controller->index();
        break;


    // =========================
    // RETIRADAS
    // =========================

    case 'nova-retirada':
        AuthMiddleware::verificarLogin();
        $controller = new RetiradaController();
        $controller->create();
        break;

    case 'cadastrar-retirada':
        AuthMiddleware::verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            break;
        }

        $controller = new RetiradaController();
        $controller->store();
        break;

    case 'retiradas':
        AuthMiddleware::verificarLogin();
        $controller = new RetiradaController();
        $controller->index();
        break;


    // =========================
    // UBS
    // =========================

    case 'nova-ubs':
        AuthMiddleware::verificarLogin();
        $controller = new UbsController();
        $controller->create();
        break;

    case 'cadastrar-ubs':
        AuthMiddleware::verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            break;
        }

        $controller = new UbsController();
        $controller->store();
        break;

    case 'ubs':
        AuthMiddleware::verificarLogin();
        $controller = new UbsController();
        $controller->index();
        break;

    case 'editar-ubs':
        AuthMiddleware::verificarLogin();

        $id = isset($_GET['id'])
            ? (int) $_GET['id']
            : 0;

        $controller = new UbsController();
        $controller->edit($id);
        break;

    case 'atualizar-ubs':
        AuthMiddleware::verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            break;
        }

        $controller = new UbsController();
        $controller->update();
        break;

    case 'excluir-ubs':
        AuthMiddleware::verificarLogin();

        $id = isset($_GET['id'])
            ? (int) $_GET['id']
            : 0;

        $controller = new UbsController();
        $controller->delete($id);
        break;


    // =========================
    // ESTOQUE
    // =========================

    case 'editar-estoque':
        AuthMiddleware::verificarLogin();
        $controller = new EstoqueController();
        $controller->edit();
        break;

    case 'atualizar-estoque':
        AuthMiddleware::verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            break;
        }

        $controller = new EstoqueController();
        $controller->update();
        break;


    // =========================
    // DASHBOARD
    // =========================

    case 'dashboard':
        AuthMiddleware::verificarLogin();
        $controller = new DashboardController();
        $controller->index();
        break;

    case 'dashboard-estoque':
        AuthMiddleware::verificarLogin();
        $controller = new DashboardController();
        $controller->estoqueJson();
        break;


    // =========================
    // USUÁRIOS / FUNCIONÁRIOS
    // =========================

    case 'usuarios':
        AuthMiddleware::verificarAdmin();
        $controller = new UsuarioController();
        $controller->index();
        break;

    case 'novo-usuario':
        AuthMiddleware::verificarAdmin();
        $controller = new UsuarioController();
        $controller->create();
        break;

    case 'cadastrar-usuario':
        AuthMiddleware::verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            break;
        }

        $controller = new UsuarioController();
        $controller->store();
        break;

    case 'editar-usuario':
        AuthMiddleware::verificarAdmin();

        $id = isset($_GET['id'])
            ? (int) $_GET['id']
            : 0;

        $controller = new UsuarioController();
        $controller->edit($id);
        break;

    case 'atualizar-usuario':
        AuthMiddleware::verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            break;
        }

        $controller = new UsuarioController();
        $controller->update();
        break;


    // =========================
    // ROTA NÃO ENCONTRADA
    // =========================

    default:
        http_response_code(404);
        echo 'Página não encontrada.';
        break;
}