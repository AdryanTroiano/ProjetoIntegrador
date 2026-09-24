<?php

class DashboardController extends Controller
{
    private Dashboard $dashboard;

    public function __construct()
    {
        $this->dashboard = new Dashboard();
    }

    public function index(): void
    {
        $data = trim($_GET['data'] ?? '');

        $mes =
            isset($_GET['mes']) && $_GET['mes'] !== ''
                ? (int) $_GET['mes']
                : null;

        $ano =
            isset($_GET['ano']) && $_GET['ano'] !== ''
                ? (int) $_GET['ano']
                : null;

        $estoque = $this->dashboard->listarEstoque();

        $estoqueSangue = [];

        foreach ($estoque as $item) {
            $estoqueSangue[$item['tipo']] =
                $item['quantidade'];
        }

        $logs = $this->dashboard->listarLogs(
            $data !== '' ? $data : null,
            $mes,
            $ano
        );

        $this->view('dashboard/index', [
            'estoqueSangue' => $estoqueSangue,
            'logs' => $logs,
            'data' => $data,
            'mes' => $mes,
            'ano' => $ano
        ]);
    }

    public function estoqueJson(): void
    {
        $estoque = $this->dashboard->listarEstoque();

        $dados = [];

        foreach ($estoque as $item) {
            $dados[] = [
                'tipo' => $item['tipo'],
                'quantidade' =>
                    (int) $item['quantidade']
            ];
        }

        $this->json($dados);
    }
}