<h1 id="path2" style="text-align: center;">Listar Retiradas</h1>

<br>

<div
    class="search-container"
    style="display: flex; justify-content: center;"
>

    <input
        type="text"
        id="searchInput"
        placeholder="Buscar por UBS"
        class="form-control"
        onkeyup="filterTable()"
        style="width: 300px;"
    >

    <button
        onclick="clearSearch()"
        class="btnlimp"
    >
        Limpar
    </button>

</div>

<script>

function filterTable() {

    const input =
        document.getElementById('searchInput');

    const filter =
        input.value.toLowerCase();

    const table =
        document.getElementById('dataTable');

    const tr =
        table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {

        const td =
            tr[i].getElementsByTagName('td')[2];

        if (td) {

            const txtValue =
                td.textContent || td.innerText;

            tr[i].style.display =
                txtValue
                    .toLowerCase()
                    .indexOf(filter) > -1
                    ? ""
                    : "none";
        }
    }
}

function clearSearch() {

    document.getElementById(
        'searchInput'
    ).value = '';

    filterTable();
}

</script>

<br>

<div style="display: flex; justify-content: center;">

    <table
        class="table"
        id="dataTable"
        style="width: 90%; max-width: 1000px;"
    >

        <thead>

            <tr>

                <th style="text-align:center;">
                    Tipo Sanguíneo
                </th>

                <th style="text-align:center;">
                    Quantidade (ml)
                </th>

                <th style="text-align:center;">
                    UBS
                </th>

                <th style="text-align:center;">
                    Data
                </th>

                <th style="text-align:center;">
                    Observação
                </th>

            </tr>

        </thead>

        <tbody>

        <?php if (!empty($retiradas)): ?>

            <?php foreach ($retiradas as $retirada): ?>

                <tr>

                    <td style="text-align:center;">

                        <?= htmlspecialchars(
                            $retirada['tipo_sangue']
                        ); ?>

                    </td>

                    <td style="text-align:center;">

                        <?= htmlspecialchars(
                            $retirada['quantidade_ml']
                        ); ?>

                    </td>

                    <td style="text-align:center;">

                        <?= htmlspecialchars(
                            $retirada['ubs']
                        ); ?>

                    </td>

                    <td style="text-align:center;">

                        <?= date(
                            'd/m/Y',
                            strtotime(
                                $retirada['data_retirada']
                            )
                        ); ?>

                    </td>

                    <td style="text-align:center;">

                        <?= htmlspecialchars(
                            $retirada['observacao'] ?? ''
                        ); ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>

                <td
                    colspan="5"
                    class="text-center alert alert-danger"
                >

                    Não há retiradas registradas!

                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>