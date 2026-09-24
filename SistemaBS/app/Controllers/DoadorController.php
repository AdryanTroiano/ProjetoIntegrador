<?php

class DoadorController extends Controller
{
    private Doador $doador;

    public function __construct()
    {
        $this->doador = new Doador();
    }

    public function create(): void
{
    $tiposSangue = $this->doador->listarTiposSangue();

    $this->view('doadores/create', [
        'tiposSangue' => $tiposSangue
    ]);
}

public function store(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo 'Método não permitido.';
        return;
    }

    $dados = [
        'nome' => trim($_POST['nome'] ?? ''),
        'cpf' => trim($_POST['cpf'] ?? ''),
        'telefone' => trim($_POST['telefone'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'endereco' => trim($_POST['endereco'] ?? ''),
        'numero' => trim($_POST['numero'] ?? ''),
        'cep' => trim($_POST['cep'] ?? ''),
        'complemento' => trim($_POST['complemento'] ?? ''),
        'bairro' => trim($_POST['bairro'] ?? ''),
        'nasc' => $_POST['nasc'] ?? '',
        'tipo_sangue_id' => (int) ($_POST['tipo_sangue_id'] ?? 0),
        'sexo' => $_POST['sexo'] ?? '',
        'peso' => $_POST['peso'] ?? ''
    ];

    if (
        $dados['nome'] === '' ||
        $dados['cpf'] === '' ||
        $dados['telefone'] === '' ||
        $dados['email'] === '' ||
        $dados['endereco'] === '' ||
        $dados['numero'] === '' ||
        $dados['cep'] === '' ||
        $dados['bairro'] === '' ||
        $dados['nasc'] === '' ||
        $dados['tipo_sangue_id'] <= 0 ||
        $dados['sexo'] === '' ||
        $dados['peso'] === ''
    ) {
        die('Preencha todos os campos obrigatórios.');
    }

    try {

        $this->doador->cadastrar($dados);

        header('Location: index.php?rota=doadores');
        exit;

    } catch (PDOException $e) {

        http_response_code(500);

        echo 'Não foi possível cadastrar o doador.';
    }
}

    public function index(): void
    {
        $doadores = $this->doador->listarTodos();

        $this->view('doadores/index', [
            'doadores' => $doadores
        ]);
    }

    public function show(int $id): void
    {
        if ($id <= 0) {
            $this->view('doadores/show', [
                'erro' => 'ID não fornecido.'
            ]);

            return;
        }

        $doador = $this->doador->buscarPorId($id);

        if (!$doador) {
            $this->view('doadores/show', [
                'erro' => 'Doador não encontrado.'
            ]);

            return;
        }

        $this->view('doadores/show', [
            'doador' => $doador
        ]);
    }

    public function edit(int $id): void
    {
        if ($id <= 0) {
            $this->view('doadores/edit', [
                'erro' => 'ID não fornecido.'
            ]);

            return;
        }

        $doador = $this->doador->buscarPorId($id);

        if (!$doador) {
            $this->view('doadores/edit', [
                'erro' => 'Doador não encontrado.'
            ]);

            return;
        }

        $tiposSangue = $this->doador->listarTiposSangue();

        $this->view('doadores/edit', [
            'doador' => $doador,
            'tiposSangue' => $tiposSangue
        ]);
    }

    public function update(): void
    {
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

        if ($id <= 0) {
            die('ID inválido.');
        }

        $dados = [
            'nome' => trim($_POST['nome'] ?? ''),
            'sexo' => $_POST['sexo'] ?? '',
            'nasc' => $_POST['nasc'] ?? '',
            'email' => trim($_POST['email'] ?? ''),
            'cep' => trim($_POST['cep'] ?? ''),
            'endereco' => trim($_POST['endereco'] ?? ''),
            'numero' => trim($_POST['numero'] ?? ''),
            'bairro' => trim($_POST['bairro'] ?? ''),
            'complemento' => trim($_POST['complemento'] ?? ''),
            'telefone' => trim($_POST['telefone'] ?? ''),
            'peso' => $_POST['peso'] ?? '',
            'tipo_sangue_id' => (int) ($_POST['tipo_sangue_id'] ?? 0),
            'datedonation' => $_POST['datedonation'] ?? ''
        ];

        $this->doador->atualizar($id, $dados);

        header(
            'Location: index.php?rota=doador&id=' . $id
        );

        exit;

        
    }

    public function delete(int $id): void
{
    if ($id <= 0) {
        die('ID inválido.');
    }

    $doador = $this->doador->buscarPorId($id);

    if (!$doador) {
        die('Doador não encontrado.');
    }

    try {

        $this->doador->excluir($id);

        header(
            'Location: index.php?rota=doadores'
        );

        exit;

    } catch (PDOException $e) {

        http_response_code(409);

        echo 'Não foi possível excluir este doador. Existem registros relacionados a ele.';
    }
}
}