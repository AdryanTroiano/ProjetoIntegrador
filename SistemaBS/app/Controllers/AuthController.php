<?php

class AuthController extends Controller
{
    private Usuario $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['usuario'])) {
            header('Location: index.php?rota=doadores');
            exit;
        }

        // Login não utiliza o layout principal
        $this->view('auth/login', [], false);
    }

    public function autenticar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $usuario = trim($_POST['usuario'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if ($usuario === '' || $senha === '') {
            $this->view(
                'auth/login',
                [
                    'erro' => 'Por favor, preencha todos os campos!'
                ],
                false
            );

            return;
        }

        $usuarioEncontrado =
            $this->usuario->buscarPorUsuario($usuario);

        if (!$usuarioEncontrado) {
            $this->view(
                'auth/login',
                [
                    'erro' => 'Usuário não encontrado!'
                ],
                false
            );

            return;
        }

        if (
            !password_verify(
                $senha,
                $usuarioEncontrado['senha']
            )
        ) {
            $this->view(
                'auth/login',
                [
                    'erro' => 'Senha incorreta!'
                ],
                false
            );

            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['usuario_id'] =
            $usuarioEncontrado['id'];

        $_SESSION['usuario'] =
            $usuarioEncontrado['usuario'];

        $_SESSION['usuario_nivel'] =
            $usuarioEncontrado['nivel'];

        header('Location: index.php?rota=doadores');
        exit;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        session_destroy();

        header('Location: index.php?rota=login');
        exit;
    }
}