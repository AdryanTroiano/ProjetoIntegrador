<?php

class DoacaoController extends Controller
{
    private Doacao $doacao;


    public function __construct()
    {
        $this->doacao = new Doacao();
    }


    // =========================
    // LISTAR DOAÇÕES
    // =========================

    public function index(): void
    {
        $doacoes = $this->doacao->listarTodas();

        $this->view('doacoes/index', [
            'doacoes' => $doacoes
        ]);
    }


    // =========================
    // FORMULÁRIO DE DOAÇÃO
    // =========================

    public function create(): void
    {
        $doadores = $this->doacao->listarDoadores();

        $ubs = $this->doacao->listarUbs();

        $this->view('doacoes/create', [
            'doadores' => $doadores,
            'ubs' => $ubs
        ]);
    }


    // =========================
    // CADASTRAR DOAÇÃO
    // =========================

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            http_response_code(405);

            echo 'Método não permitido.';

            return;
        }


        AuthMiddleware::iniciarSessao();


        // =========================
        // DADOS DO FORMULÁRIO
        // =========================

        $doadorId =
            (int) ($_POST['doador_id'] ?? 0);

        $ubsId =
            (int) ($_POST['ubs_id'] ?? 0);

        $dataDoacao =
            $_POST['data_doacao'] ?? '';

        $quantidadeMl =
            (int) ($_POST['quantidade_ml'] ?? 0);


        // =========================
        // VALIDAÇÃO DOS CAMPOS
        // =========================

        if (
            $doadorId <= 0 ||
            $ubsId <= 0 ||
            $dataDoacao === '' ||
            $quantidadeMl <= 0
        ) {

            $this->alertaVoltar(
                'Preencha todos os campos corretamente.'
            );

            return;
        }


        // =========================
        // BUSCA O DOADOR
        // =========================

        $doador =
            $this->doacao->buscarDoador(
                $doadorId
            );


        if (!$doador) {

            $this->alertaVoltar(
                'Doador não encontrado.'
            );

            return;
        }


        // =========================
        // VERIFICA SE FOI VALIDADO
        // =========================

        if ((int) $doador['validado'] !== 1) {

            $this->alertaVoltar(
                'Este doador ainda não foi validado. Realize a validação pelo aplicativo antes de registrar a doação.'
            );

            return;
        }


        // =========================
        // TIPO SANGUÍNEO
        // =========================

        $tipoSangueId =
            (int) $doador['tipo_sangue_id'];


        if ($tipoSangueId <= 0) {

            $this->alertaVoltar(
                'O tipo sanguíneo do doador não foi encontrado.'
            );

            return;
        }


        // =========================
        // USUÁRIO LOGADO
        // =========================

        $usuarioId =
            (int) (
                $_SESSION['usuario_id'] ?? 0
            );


        if ($usuarioId <= 0) {

            $this->alertaVoltar(
                'Usuário não autenticado.'
            );

            return;
        }


        $ip =
            $_SERVER['REMOTE_ADDR'] ?? '';


        // =========================
        // CADASTRAR
        // =========================

        try {

            $this->doacao->cadastrar(
                $doadorId,
                $ubsId,
                $dataDoacao,
                $quantidadeMl
            );


            $this->doacao->atualizarDataDoacao(
                $doadorId,
                $dataDoacao
            );


            $this->doacao->atualizarEstoque(
                $tipoSangueId,
                $quantidadeMl
            );


            $this->doacao->registrarLog(
                $usuarioId,
                $tipoSangueId,
                $quantidadeMl,
                $ip
            );


            echo "
                <script>
                    alert('Doação cadastrada e estoque atualizado!');
                    window.location.href='index.php?rota=doacoes';
                </script>
            ";


        } catch (PDOException $e) {

            http_response_code(500);

            echo "
                <script>
                    alert('Erro ao cadastrar a doação.');
                    window.history.back();
                </script>
            ";

        }
    }


    // =========================
    // ALERTA E VOLTAR
    // =========================

    private function alertaVoltar(
        string $mensagem
    ): void {

        $mensagemSegura = json_encode(
            $mensagem,
            JSON_UNESCAPED_UNICODE |
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_HEX_AMP
        );

        echo "
            <script>
                alert($mensagemSegura);
                window.history.back();
            </script>
        ";
    }
}