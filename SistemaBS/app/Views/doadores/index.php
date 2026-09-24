<?php

if (!isset($doadores)) {
    $doadores = [];
}
?>

<h1 id="path2" style="text-align: center;">Listar Doadores</h1>

<br>

<div class="search-container" style="display: flex; justify-content: center;">

    <input
        type="text"
        id="searchInput"
        placeholder="Buscar por nome"
        class="form-control"
        onkeyup="filterTable()"
        style="width: 300px;"
    >

    <button onclick="clearSearch()" class="btnlimp">Limpar</button>

</div>

<script>
function filterTable() {

    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('dataTable');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {

        const td = tr[i].getElementsByTagName('td')[0];

        if (td) {

            const txtValue = td.textContent || td.innerText;

            tr[i].style.display =
                txtValue.toLowerCase().indexOf(filter) > -1
                    ? ""
                    : "none";
        }
    }
}

function clearSearch() {

    document.getElementById('searchInput').value = '';

    filterTable();
}
</script>

<br>

<div style="display: flex; justify-content: center;">

    <table class="table" id="dataTable" style="width: 80%; max-width: 800px;">

        <thead>

            <tr>

                <th style="text-align: center;">
                    Nome
                </th>

                <th style="text-align: center; width: 200px;">
                    Ações
                </th>

            </tr>

        </thead>

        <tbody>

            <?php

            $qtd = count($doadores);

            if ($qtd > 0):

                foreach ($doadores as $row):

                    /*
                     * Verifica se a última doação está presente.
                     */
                    $mostrarAviso = false;

                    if (!empty($row['datedonation'])) {

                        $ultimaDoacao = new DateTime($row['datedonation']);
                        $hoje = new DateTime();

                        $diff = $hoje->diff($ultimaDoacao);

                        $mesesPassados =
                            ($diff->y * 12) + $diff->m;

                        if (
                            ($row['sexo'] === 'M' && $mesesPassados >= 2) ||
                            ($row['sexo'] === 'F' && $mesesPassados >= 3)
                        ) {
                            $mostrarAviso = true;
                        }
                    }

                    $icone = $mostrarAviso ? "

                        <span class='tooltip'>

                            <span style='color: red;'>&#10067;</span>

                            <span class='tooltiptext'>
                                Doador já pode doar novamente
                            </span>

                        </span>

                    " : "";

            ?>

                    <tr>

                        <td style="text-align: left; width: 200px;">

                            <?= htmlspecialchars($row['nome']) ?>

                            <?= $icone ?>

                        </td>

                        <td style="text-align: center;">

                            <div style="display: flex; justify-content: center; gap: 10px;">

                                <button
                                    onclick="location.href='?rota=doador&id=<?= (int)$row['id'] ?>';"
                                    type="button"
                                    class="btn btn-primary"
                                >
                                    Visualizar
                                </button>

                                <button
                                    onclick="location.href='?rota=editar&id=<?= (int)$row['id'] ?>';"
                                    type="button"
                                    class="btn btn-success"
                                >
                                    Editar
                                </button>

                                <button
                                    onclick="if(confirm('Tem certeza que deseja excluir?')) location.href='?rota=excluir&id=<?= (int)$row['id'] ?>';"
                                    type="button"
                                    class="btn btn-danger"
                                >
                                    Excluir
                                </button>

                            </div>

                        </td>

                    </tr>

            <?php

                endforeach;

            else:

            ?>

                <tr>

                    <td
                        colspan="2"
                        class="text-center alert alert-danger"
                    >
                        Não há cadastros disponíveis!
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>

</div>