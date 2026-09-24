<?php

class RetiradaController extends Controller
{
    private Retirada $retirada;

    public function __construct()
    {
        $this->retirada = new Retirada();
    }

    public function create(): void
    {
        $tipos = $this->retirada->listarTiposSangue();
        $ubs = $this->retirada->listarUbs();

        $this->view('retiradas/create', [
            'tipos' => $tipos,
            'ubs' => $ubs
        ]);
    }

    public function store(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo 'Método não permitido.';
        return;
    }

    AuthMiddleware::iniciarSessao();

    $tipoSangueId =
        (int) ($_POST['tipo_sangue_id'] ?? 0);

    $quantidade =
        (int) ($_POST['quantidade'] ?? 0);

    $data =
        $_POST['data'] ?? '';

    $ubsId =
        (int) ($_POST['ubs_id'] ?? 0);

    $observacao =
        trim($_POST['observacao'] ?? '');

    if (
        $tipoSangueId <= 0 ||
        $quantidade <= 0 ||
        $data === '' ||
        $ubsId <= 0
    ) {
        die('Preencha todos os campos obrigatórios corretamente.');
    }

    $estoqueAtual =
        $this->retirada->buscarEstoque($tipoSangueId);

    if ($estoqueAtual === null) {
        die('Estoque não encontrado para este tipo sanguíneo.');
    }

    if ($quantidade > $estoqueAtual) {

        echo "
            <script>
                alert('Erro: Estoque insuficiente! Disponível: {$estoqueAtual} ml');
                window.history.back();
            </script>
        ";

        return;
    }

    $usuarioId =
        (int) ($_SESSION['usuario_id'] ?? 0);

    if ($usuarioId <= 0) {
        die('Usuário não autenticado.');
    }

    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    try {

        $this->retirada->cadastrar(
            $tipoSangueId,
            $quantidade,
            $data,
            $ubsId,
            $observacao
        );

        $this->retirada->atualizarEstoque(
            $tipoSangueId,
            $quantidade
        );

        $this->retirada->registrarLog(
            $usuarioId,
            $tipoSangueId,
            $quantidade,
            $ip
        );

        echo "
            <script>
                alert('Retirada registrada e estoque atualizado!');
                window.location.href='index.php?rota=retirada';
            </script>
        ";

    } catch (PDOException $e) {

        http_response_code(500);

        echo "
            <script>
                alert('Erro ao registrar a retirada.');
                window.history.back();
            </script>
        ";
    }
}

public function index(): void
{
    $retiradas = $this->retirada->listarTodas();

    $this->view('retiradas/index', [
        'retiradas' => $retiradas
    ]);
}
}