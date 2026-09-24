<h1 id="path2" style="text-align:center;">Listar UBS</h1>

<br>

<div style="display:flex; justify-content:center;">

    <table
        class="table"
        style="width:80%; max-width:800px;"
    >

        <thead>

            <tr>
                <th style="text-align:center;">
                    Nome
                </th>

                <th style="text-align:center;">
                    Ações
                </th>
            </tr>

        </thead>

        <tbody>

            <?php if (!empty($ubs)): ?>

                <?php foreach ($ubs as $unidade): ?>

                    <tr>

                        <td style="text-align:center;">

                            <?= htmlspecialchars(
                                $unidade['nome']
                            ); ?>

                        </td>

                        <td style="text-align:center;">

                            <button
                                onclick="location.href='index.php?rota=editar-ubs&id=<?= (int) $unidade['id']; ?>';"
                                class="btn btn-success"
                            >
                                Editar
                            </button>

                            <button
                                onclick="if(confirm('Tem certeza que deseja excluir esta UBS?')) location.href='index.php?rota=excluir-ubs&id=<?= (int) $unidade['id']; ?>';"
                                class="btn btn-danger"
                            >
                                Excluir
                            </button>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td
                        colspan="2"
                        style="text-align:center;"
                    >
                        Nenhuma UBS cadastrada.
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>

</div>