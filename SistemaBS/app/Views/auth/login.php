<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link
        rel="shortcut icon"
        href="/SistemaBS/public/images/favicon.png"
        type="image/x-icon"
    >

    <title>Login</title>

    <link
        rel="stylesheet"
        href="/SistemaBS/public/css/login.css"
    >

</head>

<body>

    <!-- Container VLibras -->

    <div vw class="enabled">

        <div
            vw-access-button
            class="active"
        ></div>

        <div vw-plugin-wrapper>

            <div
                class="vw-plugin-top-wrapper"
            ></div>

        </div>

    </div>


    <div class="login-container">

        <div class="login-box">

            <img
                src="/SistemaBS/public/images/logo-legacy.png"
                alt="Logo da empresa"
            >

            <h2>Login</h2>


            <?php if (!empty($erro)): ?>

                <p
                    style="
                        color: #a4161a;
                        margin-bottom: 15px;
                    "
                >
                    <?= htmlspecialchars($erro); ?>
                </p>

            <?php endif; ?>


            <form
                action="index.php?rota=autenticar"
                method="POST"
            >

                <div class="textbox">

                    <label for="user">
                        Usuário:
                    </label>

                    <input
                        type="text"
                        id="user"
                        name="usuario"
                        placeholder="Digite seu nome de usuário"
                        required
                    >

                </div>


                <div class="textbox">

                    <label for="password">
                        Senha:
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="senha"
                        placeholder="Digite sua senha"
                        required
                    >

                </div>


                <input
                    type="submit"
                    value="Entrar"
                >

            </form>

        </div>

    </div>


    <script>

        const form =
            document.querySelector('form');

        form.addEventListener(
            'submit',
            function(event) {

                event.preventDefault();

                document.body.classList.add(
                    'fade-out'
                );

                setTimeout(
                    () => {
                        form.submit();
                    },
                    500
                );

            }
        );

    </script>


    <script
        src="https://vlibras.gov.br/app/vlibras-plugin.js"
    ></script>

    <script>

        new window.VLibras.Widget(
            'https://vlibras.gov.br/app'
        );

    </script>

</body>

</html>