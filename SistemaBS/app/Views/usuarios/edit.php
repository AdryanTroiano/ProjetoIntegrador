<link
    rel="stylesheet"
    href="/SistemaBS/public/css/usuarios.css"
>

<div class="usuarios-page">

    <div class="usuarios-container">

        <h2>Editar Usuário</h2>

        <?php if (!empty($erro)): ?>
            <p class="usuarios-erro">
                <?= htmlspecialchars($erro) ?>
            </p>
        <?php endif; ?>

        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['mensagem'])):
        ?>
            <p class="usuarios-sucesso">
                <?= htmlspecialchars($_SESSION['mensagem']) ?>
            </p>

            <?php unset($_SESSION['mensagem']); ?>
        <?php endif; ?>

        <form
            action="index.php?rota=atualizar-usuario"
            method="POST"
            id="formEdicao"
        >

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($usuario['id']) ?>"
            >


            <div class="usuarios-campo">

                <label for="nome">
                    Nome Completo:
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    value="<?= htmlspecialchars($usuario['usuario']) ?>"
                    required
                >

            </div>


            <div class="usuarios-campo">

                <label for="email">
                    E-mail:
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= htmlspecialchars($usuario['email']) ?>"
                    required
                >

            </div>


            <div class="usuarios-campo">

                <label for="senha">
                    Nova Senha (deixe em branco para não alterar):
                </label>

                <input
                    type="password"
                    id="senha"
                    name="senha"
                >

            </div>


            <div class="usuarios-campo">

                <label for="confirmar_senha">
                    Confirmar Senha:
                </label>

                <input
                    type="password"
                    id="confirmar_senha"
                    name="confirmar_senha"
                >

            </div>


            <input
                type="submit"
                value="Salvar Alterações"
                class="usuarios-submit"
            >

        </form>


        <p
            id="erroSenha"
            class="usuarios-erro"
            style="display: none;"
        >
            As senhas não coincidem. Tente novamente.
        </p>

    </div>

</div>


<script>
const form = document.getElementById('formEdicao');

form.addEventListener('submit', function (event) {

    const senha =
        document.getElementById('senha').value;

    const confirmarSenha =
        document.getElementById('confirmar_senha').value;

    const erro =
        document.getElementById('erroSenha');

    if (senha || confirmarSenha) {

        if (senha !== confirmarSenha) {
            event.preventDefault();

            erro.style.display = 'block';

            return;
        }
    }

    erro.style.display = 'none';
});
</script>