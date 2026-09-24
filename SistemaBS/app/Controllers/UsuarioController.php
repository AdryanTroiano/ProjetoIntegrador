<?php

class UsuarioController extends Controller
{
    private Usuario $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    // =========================
// LISTAGEM
// =========================

public function index(): void
{
    $usuarios = $this->usuario->listarTodos();

    $this->view('usuarios/index', [
        'usuarios' => $usuarios
    ]);
}

    // =========================
    // CADASTRO
    // =========================

    public function create(): void
    {
        $this->view('usuarios/create');
    }


    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';
        $nivel = $_POST['nivel'] ?? '';

        $niveisValidos = [
            'padrao',
            'admin'
        ];


        // Campos obrigatórios
        if (
            $nome === '' ||
            $email === '' ||
            $senha === '' ||
            $confirmarSenha === '' ||
            $nivel === ''
        ) {
            $this->view('usuarios/create', [
                'erro' =>
                    'Por favor, preencha todos os campos!'
            ]);

            return;
        }


        // Validação do e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->view('usuarios/create', [
                'erro' => 'E-mail inválido!'
            ]);

            return;
        }


        // Validação do nível
        if (!in_array($nivel, $niveisValidos, true)) {
            $this->view('usuarios/create', [
                'erro' => 'Nível de acesso inválido!'
            ]);

            return;
        }


        // Confirmação da senha
        if ($senha !== $confirmarSenha) {
            $this->view('usuarios/create', [
                'erro' => 'As senhas não coincidem!'
            ]);

            return;
        }


        // E-mail duplicado
        if ($this->usuario->emailExiste($email)) {
            $this->view('usuarios/create', [
                'erro' => 'E-mail já cadastrado!'
            ]);

            return;
        }


        // Cadastro
        $cadastrado = $this->usuario->cadastrar(
            $nome,
            $email,
            $senha,
            $nivel
        );


        if (!$cadastrado) {
            $this->view('usuarios/create', [
                'erro' =>
                    'Não foi possível cadastrar o usuário.'
            ]);

            return;
        }


        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['mensagem'] =
            'Usuário cadastrado com sucesso!';

        header(
            'Location: index.php?rota=novo-usuario'
        );

        exit;
    }


    // =========================
    // EDIÇÃO
    // =========================

    public function edit(int $id): void
    {
        if ($id <= 0) {
            http_response_code(400);
            echo 'ID do usuário inválido.';
            return;
        }


        $usuario = $this->usuario->buscarPorId($id);


        if (!$usuario) {
            http_response_code(404);
            echo 'Usuário não encontrado.';
            return;
        }


        $this->view('usuarios/edit', [
            'usuario' => $usuario
        ]);
    }


    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }


        $id = isset($_POST['id'])
            ? (int) $_POST['id']
            : 0;

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');

        $senha = $_POST['senha'] ?? '';

        $confirmarSenha =
            $_POST['confirmar_senha'] ?? '';


        // Campos obrigatórios
        if (
            $id <= 0 ||
            $nome === '' ||
            $email === ''
        ) {
            $this->mostrarErroEdicao(
                $id,
                'Por favor, preencha todos os campos obrigatórios!'
            );

            return;
        }


        // Validação do e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->mostrarErroEdicao(
                $id,
                'E-mail inválido!'
            );

            return;
        }


        // Verifica se o usuário existe
        $usuarioAtual =
            $this->usuario->buscarPorId($id);


        if (!$usuarioAtual) {
            http_response_code(404);
            echo 'Usuário não encontrado.';
            return;
        }


        // Confirmação da senha
        if (
            ($senha !== '' || $confirmarSenha !== '') &&
            $senha !== $confirmarSenha
        ) {
            $this->mostrarErroEdicao(
                $id,
                'As senhas não coincidem!'
            );

            return;
        }


        // Verifica e-mail duplicado
        if (
            $this->usuario
                ->emailExisteEmOutroUsuario(
                    $email,
                    $id
                )
        ) {
            $this->mostrarErroEdicao(
                $id,
                'E-mail já cadastrado para outro usuário!'
            );

            return;
        }


        // Atualiza com ou sem senha
        if ($senha !== '') {

            $atualizado =
                $this->usuario->atualizarComSenha(
                    $id,
                    $nome,
                    $email,
                    $senha
                );

        } else {

            $atualizado =
                $this->usuario->atualizar(
                    $id,
                    $nome,
                    $email
                );
        }


        if (!$atualizado) {
            $this->mostrarErroEdicao(
                $id,
                'Não foi possível atualizar o usuário.'
            );

            return;
        }


        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        // Se o usuário editou a própria conta,
        // atualiza o nome armazenado na sessão.
        if (
            isset($_SESSION['usuario_id']) &&
            (int) $_SESSION['usuario_id'] === $id
        ) {
            $_SESSION['usuario'] = $nome;
        }


        $_SESSION['mensagem'] =
            'Usuário atualizado com sucesso!';


        header(
            'Location: index.php?rota=editar-usuario&id=' .
            $id
        );

        exit;
    }


    // =========================
    // AUXILIAR
    // =========================

    private function mostrarErroEdicao(
        int $id,
        string $erro
    ): void {
        $usuario = $this->usuario->buscarPorId($id);

        if (!$usuario) {
            http_response_code(404);
            echo 'Usuário não encontrado.';
            return;
        }

        $this->view('usuarios/edit', [
            'usuario' => $usuario,
            'erro' => $erro
        ]);
    }
}