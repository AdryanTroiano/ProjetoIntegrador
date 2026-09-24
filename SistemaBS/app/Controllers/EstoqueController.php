<?php

class EstoqueController extends Controller
{
    private Estoque $estoque;

    public function __construct()
    {
        $this->estoque = new Estoque();
    }

    public function edit(): void
    {
        AuthMiddleware::iniciarSessao();

        $estoqueSangue = $this->estoque->listarTodos();

        $mensagem = $_SESSION['mensagem'] ?? null;

        unset(
            $_SESSION['mensagem'],
            $_SESSION['mensagem_tipo']
        );

        $this->view('estoque/edit', [
            'estoqueSangue' => $estoqueSangue,
            'mensagem' => $mensagem
        ]);
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método não permitido.';
            return;
        }

        AuthMiddleware::iniciarSessao();

        $sucesso = true;

        foreach ($_POST as $tipoSangueId => $quantidade) {

            if (
                !is_numeric($tipoSangueId) ||
                !is_numeric($quantidade) ||
                (int) $tipoSangueId <= 0 ||
                (int) $quantidade < 0
            ) {
                $sucesso = false;
                continue;
            }

            try {

                $atualizado = $this->estoque->atualizar(
                    (int) $tipoSangueId,
                    (int) $quantidade
                );

                if (!$atualizado) {
                    $sucesso = false;
                }

            } catch (PDOException $e) {
                $sucesso = false;
            }
        }

        if ($sucesso) {
            $_SESSION['mensagem'] =
                'Estoque de sangue editado com sucesso!';

            $_SESSION['mensagem_tipo'] =
                'success';
        } else {
            $_SESSION['mensagem'] =
                'Houve um erro ao editar o estoque.';

            $_SESSION['mensagem_tipo'] =
                'error';
        }

        header('Location: index.php?rota=editar-estoque');
        exit;
    }
}