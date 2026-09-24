<h1 id="path2" style="text-align:center;">Editar UBS</h1>

<div class="container">

    <form action="index.php?rota=atualizar-ubs" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= (int) $ubs['id']; ?>"
        >

        <div class="contentform">

            <div class="form-container">

                <div class="row">

                    <div class="column">

                        <label>
                            Nome da UBS:<span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nome"
                            value="<?= htmlspecialchars($ubs['nome']); ?>"
                            required
                        >

                    </div>

                </div>

                <div class="column button-column">

                    <button type="submit">
                        Salvar Alterações
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>