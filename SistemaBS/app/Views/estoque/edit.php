<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Editar Estoque de Sangue</title>

    <?php if (!empty($mensagem)): ?>

        <script>
            window.onload = function() {
                alert(
                    <?= json_encode(
                        $mensagem,
                        JSON_UNESCAPED_UNICODE
                    ); ?>
                );
            };
        </script>

    <?php endif; ?>

</head>

<body>

<?php if (!empty($estoqueSangue)): ?>

    <div class="form-container">

        <h1 id="path5">
            Editar Estoque
        </h1>

        <form
            method="POST"
            action="index.php?rota=atualizar-estoque"
        >

            <div class="blood-stock">

                <?php foreach ($estoqueSangue as $item): ?>

                    <div class="blood-type">

                        <label
                            for="tipo_<?= (int) $item['tipo_sangue_id']; ?>"
                        >
                            Tipo <?= htmlspecialchars($item['tipo']); ?>:
                        </label>

                        <input
                            type="number"
                            id="tipo_<?= (int) $item['tipo_sangue_id']; ?>"
                            name="<?= (int) $item['tipo_sangue_id']; ?>"
                            value="<?= htmlspecialchars($item['quantidade']); ?>"
                            min="0"
                            required
                            class="input-field"
                        >

                    </div>

                <?php endforeach; ?>

            </div>

            <button
                type="submit"
                id="enviar3"
            >
                Atualizar Estoque
            </button>

        </form>

    </div>

<?php else: ?>

    <p id="no-data-message">
        Nenhum estoque encontrado para edição.
    </p>

<?php endif; ?>

</body>

</html>