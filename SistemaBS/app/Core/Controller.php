<?php

class Controller
{
    protected function view(
        string $view,
        array $dados = [],
        bool $usarLayout = true
    ): void {
        extract($dados);

        $arquivo = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($arquivo)) {
            die("View não encontrada: " . $view);
        }

        // Views que não utilizam o layout principal
        if (!$usarLayout) {
            require $arquivo;
            return;
        }

        // Captura o conteúdo da View
        ob_start();

        require $arquivo;

        $content = ob_get_clean();

        // Carrega o layout principal
        $layout = __DIR__ . '/../Views/layouts/main.php';

        if (!file_exists($layout)) {
            die('Layout principal não encontrado.');
        }

        require $layout;
    }

    protected function json(
        array $dados,
        int $status = 200
    ): void {
        http_response_code($status);

        header(
            'Content-Type: application/json; charset=utf-8'
        );

        echo json_encode(
            $dados,
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES
        );

        exit;
    }
}