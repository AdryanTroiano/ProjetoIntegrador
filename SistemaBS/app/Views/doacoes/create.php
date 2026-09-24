<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style.css">

    <title>Cadastrar Doação</title>

</head>

<body>

<div class="container">

    <h1 id="path2">Cadastrar Doação</h1>

    <form action="index.php?rota=cadastrar-doacao" method="POST">

        <div class="contentform">

            <div class="form-container">


                <!-- PESQUISAR DOADOR -->

                <div class="row">

                    <div class="column">

                        <label>Pesquisar Doador</label>

                        <input
                            type="text"
                            id="pesquisaDoador"
                            placeholder="Digite o nome para buscar..."
                        >

                    </div>

                </div>


                <!-- DOADOR -->

                <div class="row">

                    <div class="column">

                        <label>
                            Doador:<span class="required">*</span>
                        </label>

                        <select
                            name="doador_id"
                            id="selectDoador"
                            required
                        >

                            <option
                                value=""
                                disabled
                                selected
                            >
                                Selecione o doador
                            </option>


                            <?php foreach ($doadores as $doador): ?>

                                <?php
                                    $validado =
                                        (int) ($doador['validado'] ?? 0);
                                ?>

                                <?php if ($validado === 1): ?>

                                    <option
                                        value="<?= (int) $doador['id']; ?>"
                                    >
                                        <?= htmlspecialchars(
                                            $doador['nome'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </option>

                                <?php else: ?>

                                    <option
                                        value=""
                                        disabled
                                        data-pendente="1"
                                    >
                                        <?= htmlspecialchars(
                                            $doador['nome'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                        — Pendente de validação
                                    </option>

                                <?php endif; ?>

                            <?php endforeach; ?>

                        </select>

                    </div>

                </div>


                <!-- AVISO DE VALIDAÇÃO -->

                <div
                    id="avisoValidacao"
                    style="
                        display: none;
                        margin-top: 5px;
                        margin-bottom: 15px;
                        padding: 10px;
                        border-radius: 5px;
                        background-color: #fff3cd;
                        color: #856404;
                    "
                >
                    Doadores pendentes precisam ser validados pelo
                    aplicativo antes de realizar uma doação.
                </div>


                <!-- UBS -->

                <div class="row">

                    <div class="column">

                        <label>
                            UBS:<span class="required">*</span>
                        </label>

                        <select
                            name="ubs_id"
                            required
                        >

                            <option
                                value=""
                                disabled
                                selected
                            >
                                Selecione a UBS
                            </option>

                            <?php foreach ($ubs as $unidade): ?>

                                <option
                                    value="<?= (int) $unidade['id']; ?>"
                                >
                                    <?= htmlspecialchars(
                                        $unidade['nome'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                </div>


                <!-- DATA -->

                <div class="row">

                    <div class="column">

                        <label>
                            Data da Doação:<span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            name="data_doacao"
                            required
                        >

                    </div>

                </div>


                <!-- QUANTIDADE -->

                <div class="row">

                    <div class="column">

                        <label>
                            Quantidade (ml):<span class="required">*</span>
                        </label>

                        <input
                            type="number"
                            name="quantidade_ml"
                            min="1"
                            required
                        >

                    </div>

                </div>


                <!-- BOTÃO -->

                <div class="column button-column">

                    <button type="submit">
                        Cadastrar Doação
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


<script>

const pesquisaDoador =
    document.getElementById("pesquisaDoador");

const selectDoador =
    document.getElementById("selectDoador");

const avisoValidacao =
    document.getElementById("avisoValidacao");


pesquisaDoador.addEventListener(
    "keyup",
    function () {

        const filtro =
            this.value
                .toLowerCase()
                .trim();

        const options =
            selectDoador.options;

        let encontrouPendente = false;


        for (
            let i = 0;
            i < options.length;
            i++
        ) {

            const option = options[i];

            // Ignora "Selecione o doador"
            if (i === 0) {
                continue;
            }


            const texto =
                option.text
                    .toLowerCase();


            const encontrou =
                texto.includes(filtro);


            option.style.display =
                encontrou
                    ? ""
                    : "none";


            // Verifica se o resultado encontrado
            // está pendente de validação

            if (
                filtro !== "" &&
                encontrou &&
                option.dataset.pendente === "1"
            ) {

                encontrouPendente = true;

            }

        }


        // Mostra aviso quando a pesquisa
        // encontra um doador pendente

        avisoValidacao.style.display =
            encontrouPendente
                ? "block"
                : "none";

    }
);

</script>

</body>

</html>