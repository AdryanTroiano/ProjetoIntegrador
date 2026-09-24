<div class="dashboard">

    <h1 id="pathdash">Estoque de Sangue</h1>

    <?php if (empty($estoqueSangue)): ?>

        <div id="no-data-message">
            Nenhum cadastro encontrado.
        </div>

    <?php else: ?>

        <div class="dashboard-chart-container">

            <canvas
                id="bloodStockChart"
                width="300"
                height="300"
            ></canvas>

            <p id="error-message">
                Erro ao carregar o gráfico. Verifique o console.
            </p>

        </div>

        <div class="blood-stock">

            <?php

            $tiposSanguineos = [
                'A+',
                'A-',
                'B+',
                'B-',
                'AB+',
                'AB-',
                'O+',
                'O-'
            ];

            foreach ($tiposSanguineos as $tipo):

                $quantidade = $estoqueSangue[$tipo] ?? 0;

                $alerta =
                    $quantidade < 1000
                        ? 'alert'
                        : 'regular';

            ?>

                <div
                    class="blood-type <?= $alerta; ?>"
                    id="blood-type-<?= htmlspecialchars($tipo); ?>"
                >

                    <h3>
                        Tipo <?= htmlspecialchars($tipo); ?>
                    </h3>

                    <p class="quantidade-estoque">
                        <?= htmlspecialchars($quantidade); ?> MLS
                    </p>

                    <?php if ($quantidade < 1000): ?>

                        <p class="status-estoque warning">
                            Atenção: Estoque baixo!
                        </p>

                    <?php else: ?>

                        <p class="status-estoque regular">
                            Regular
                        </p>

                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>


<h2 class="dashboard-movimentacoes-title">
    Movimentações
</h2>


<form
    method="GET"
    action="index.php"
    class="dashboard-filter"
>

    <input
        type="hidden"
        name="rota"
        value="dashboard"
    >

    <label for="filtro-data">
        Data:
    </label>

    <input
        type="date"
        id="filtro-data"
        name="data"
        value="<?= htmlspecialchars($data ?? ''); ?>"
    >


    <label for="filtro-mes">
        Mês:
    </label>

    <select
        id="filtro-mes"
        name="mes"
    >

        <option value="">
            Todos
        </option>

        <option
            value="1"
            <?= $mes === 1 ? 'selected' : ''; ?>
        >
            Janeiro
        </option>

        <option
            value="2"
            <?= $mes === 2 ? 'selected' : ''; ?>
        >
            Fevereiro
        </option>

        <option
            value="3"
            <?= $mes === 3 ? 'selected' : ''; ?>
        >
            Março
        </option>

        <option
            value="4"
            <?= $mes === 4 ? 'selected' : ''; ?>
        >
            Abril
        </option>

        <option
            value="5"
            <?= $mes === 5 ? 'selected' : ''; ?>
        >
            Maio
        </option>

        <option
            value="6"
            <?= $mes === 6 ? 'selected' : ''; ?>
        >
            Junho
        </option>

        <option
            value="7"
            <?= $mes === 7 ? 'selected' : ''; ?>
        >
            Julho
        </option>

        <option
            value="8"
            <?= $mes === 8 ? 'selected' : ''; ?>
        >
            Agosto
        </option>

        <option
            value="9"
            <?= $mes === 9 ? 'selected' : ''; ?>
        >
            Setembro
        </option>

        <option
            value="10"
            <?= $mes === 10 ? 'selected' : ''; ?>
        >
            Outubro
        </option>

        <option
            value="11"
            <?= $mes === 11 ? 'selected' : ''; ?>
        >
            Novembro
        </option>

        <option
            value="12"
            <?= $mes === 12 ? 'selected' : ''; ?>
        >
            Dezembro
        </option>

    </select>


    <label for="filtro-ano">
        Ano:
    </label>

    <input
        type="text"
        id="filtro-ano"
        name="ano"
        placeholder="2026"
        value="<?= htmlspecialchars(
            $ano !== null
                ? (string) $ano
                : ''
        ); ?>"
    >


    <button type="submit">
        Filtrar
    </button>

</form>


<table
    class="dashboard-table"
    border="1"
>

    <thead>

        <tr>
            <th>Funcionário</th>
            <th>Ação</th>
            <th>Tipo Sanguíneo</th>
            <th>Quantidade</th>
            <th>Data/Hora</th>
            <th>IP</th>
        </tr>

    </thead>

    <tbody>

        <?php if (!empty($logs)): ?>

            <?php foreach ($logs as $log): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars(
                            $log['funcionario']
                        ); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $log['acao']
                        ); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $log['tipo_sangue']
                        ); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $log['quantidade']
                        ); ?> ml
                    </td>

                    <td>
                        <?= date(
                            'd/m/Y H:i',
                            strtotime(
                                $log['data_hora']
                            )
                        ); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $log['ip']
                        ); ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>

                <td colspan="6">
                    Nenhuma movimentação encontrada.
                </td>

            </tr>

        <?php endif; ?>

    </tbody>

</table>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function() {

        const canvas =
            document.getElementById(
                'bloodStockChart'
            );

        const errorMessage =
            document.getElementById(
                'error-message'
            );

        if (!canvas) {

            console.error(
                'Elemento canvas não encontrado!'
            );

            if (errorMessage) {
                errorMessage.style.display =
                    'block';
            }

            return;
        }


        const ctx =
            canvas.getContext('2d');

        let bloodStockChart = null;


        function initializeChart() {

            bloodStockChart =
                new Chart(ctx, {

                    type: 'pie',

                    data: {

                        labels: [
                            'A+',
                            'A-',
                            'B+',
                            'B-',
                            'AB+',
                            'AB-',
                            'O+',
                            'O-'
                        ],

                        datasets: [{

                            label:
                                'Mls de Sangue',

                            data: [],

                            backgroundColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 0, 0, 1)',
                                'rgba(0, 255, 0, 1)'
                            ],

                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 0, 0, 1)',
                                'rgba(0, 255, 0, 1)'
                            ],

                            borderWidth: 1

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        cutout: '40%',

                        plugins: {

                            legend: {
                                position: 'top'
                            }

                        }

                    }

                });

        }


        async function updateDashboard() {

            try {

                const response =
                    await fetch(
                        'index.php?rota=dashboard-estoque',
                        {
                            cache: 'no-store'
                        }
                    );


                if (!response.ok) {

                    throw new Error(
                        'Erro HTTP: ' +
                        response.status
                    );

                }


                const dados =
                    await response.json();


                const estoqueSangue = {};


                dados.forEach(
                    item => {

                        estoqueSangue[item.tipo] =
                            Number(
                                item.quantidade
                            );

                    }
                );


                const quantidades = [

                    estoqueSangue['A+'] || 0,

                    estoqueSangue['A-'] || 0,

                    estoqueSangue['B+'] || 0,

                    estoqueSangue['B-'] || 0,

                    estoqueSangue['AB+'] || 0,

                    estoqueSangue['AB-'] || 0,

                    estoqueSangue['O+'] || 0,

                    estoqueSangue['O-'] || 0

                ];


                // Atualiza o gráfico

                if (bloodStockChart) {

                    bloodStockChart
                        .data
                        .datasets[0]
                        .data = quantidades;

                    bloodStockChart.update();

                }


                // Atualiza os cards

                const tipos = [
                    'A+',
                    'A-',
                    'B+',
                    'B-',
                    'AB+',
                    'AB-',
                    'O+',
                    'O-'
                ];


                tipos.forEach(
                    tipo => {

                        const quantidade =
                            estoqueSangue[tipo] || 0;


                        const card =
                            document.getElementById(
                                'blood-type-' +
                                tipo
                            );


                        if (!card) {
                            return;
                        }


                        const quantidadeElemento =
                            card.querySelector(
                                '.quantidade-estoque'
                            );


                        const statusElemento =
                            card.querySelector(
                                '.status-estoque'
                            );


                        if (
                            quantidadeElemento
                        ) {

                            quantidadeElemento
                                .textContent =
                                quantidade +
                                ' MLS';

                        }


                        if (
                            quantidade < 1000
                        ) {

                            card.classList.remove(
                                'regular'
                            );

                            card.classList.add(
                                'alert'
                            );


                            if (
                                statusElemento
                            ) {

                                statusElemento
                                    .className =
                                    'status-estoque warning';

                                statusElemento
                                    .textContent =
                                    'Atenção: Estoque baixo!';

                            }

                        } else {

                            card.classList.remove(
                                'alert'
                            );

                            card.classList.add(
                                'regular'
                            );


                            if (
                                statusElemento
                            ) {

                                statusElemento
                                    .className =
                                    'status-estoque regular';

                                statusElemento
                                    .textContent =
                                    'Regular';

                            }

                        }

                    }
                );


                if (errorMessage) {

                    errorMessage.style.display =
                        'none';

                }

            } catch (erro) {

                console.error(
                    'Erro ao atualizar estoque:',
                    erro
                );


                if (errorMessage) {

                    errorMessage.style.display =
                        'block';

                }

            }

        }


        initializeChart();

        updateDashboard();


        setInterval(
            updateDashboard,
            60000
        );

    }
);

</script>