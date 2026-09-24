<?php

AuthMiddleware::iniciarSessao();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?rota=login');
    exit;
}

?>

<!doctype html>

<html lang="pt-br">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <link
        rel="shortcut icon"
        href="/SistemaBS/public/images/favicon.png"
        type="image/x-icon"
    >

    <title>SCBST</title>

    <link
        rel="stylesheet"
        href="/SistemaBS/public/css/style.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    >

</head>

<body>

<header>

    <nav>

        <a
            class="navbar-brand"
            href="index.php?rota=dashboard"
        >
            <img
                class="logo"
                src="/SistemaBS/public/images/logo.png"
                alt="Logo"
            >
        </a>


        <button
            id="abrirMenu"
            class="hamburguer"
        >
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>


        <!-- =========================
             MENU MOBILE
        ========================== -->

        <div
            id="menuFullscreen"
            class="menu-fullscreen"
        >

            <button
                id="fecharMenu"
                class="fechar"
            >
                ×
            </button>


            <a
                href="index.php?rota=dashboard"
                class="icone-home"
            >
                <i class="fas fa-home"></i>
            </a>


            <ul class="linkshamb">

                <!-- MOVIMENTAÇÕES -->

                <h2 class="menuhamb">
                    Movimentações
                </h2>

                <li>
                    <a href="index.php?rota=nova-doacao">
                        Cadastrar Doação
                    </a>
                </li>

                <hr class="espacamentomenus">

                <li>
                    <a href="index.php?rota=doacoes">
                        Listar Doações
                    </a>
                </li>

                <hr class="espacamentomenus">

                <li>
                    <a href="index.php?rota=nova-retirada">
                        Cadastrar Retirada
                    </a>
                </li>

                <hr class="espacamentomenus">

                <li>
                    <a href="index.php?rota=retiradas">
                        Listar Retiradas
                    </a>
                </li>

                <hr class="espacamentomenus">


                <!-- DOADORES -->

                <h2 class="menuhamb">
                    Menu Doador
                </h2>

                <li>
                    <a href="index.php?rota=novo">
                        Cadastrar Doadores
                    </a>
                </li>

                <hr class="espacamentomenus">

                <li>
                    <a href="index.php?rota=doadores">
                        Listar Doadores
                    </a>
                </li>

                <hr class="espacamentomenus">


                <!-- UBS -->

                <h2 class="menuhamb">
                    UBS
                </h2>

                <li>
                    <a href="index.php?rota=nova-ubs">
                        Cadastrar UBS
                    </a>
                </li>

                <hr class="espacamentomenus">

                <li>
                    <a href="index.php?rota=ubs">
                        Listar UBS
                    </a>
                </li>

                <hr class="espacamentomenus">


                <!-- ESTOQUE -->

                <h2 class="menuhamb">
                    Estoque
                </h2>

                <li>
                    <a href="index.php?rota=editar-estoque">
                        Editar Estoque
                    </a>
                </li>

                <hr class="espacamentomenus">


                <!-- ADMINISTRAÇÃO -->

                <?php if (AuthMiddleware::isAdmin()): ?>

                    <h2 class="menuhamb">
                        Funcionários
                    </h2>

                    <li>
                        <a href="index.php?rota=usuarios">
                            Listar Funcionários
                        </a>
                    </li>

                    <hr class="espacamentomenus">

                    <li>
                        <a href="index.php?rota=novo-usuario">
                            Cadastrar Funcionário
                        </a>
                    </li>

                    <hr class="espacamentomenus">

                <?php endif; ?>


                <!-- USUÁRIO -->

                <h2 class="menuhamb">
                    Usuário
                </h2>

                <li>
                    <a href="index.php?rota=logout">
                        Encerrar sessão
                    </a>
                </li>

                <hr class="espacamentomenus">

            </ul>

        </div>


        <!-- =========================
             MENU DESKTOP
        ========================== -->

        <div class="navbar-nav">


            <!-- DOADORES -->

            <div class="nav-item dropdown">

                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                >
                    <ion-icon
                        class="icones"
                        name="list-circle-outline"
                    ></ion-icon>

                    Doador
                </a>

                <ul class="dropdown-menu">

                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=novo"
                        >
                            Cadastrar Doadores
                        </a>
                    </li>

                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=doadores"
                        >
                            Listar Doadores
                        </a>
                    </li>

                </ul>

            </div>


            <!-- DOAÇÕES -->

            <div class="nav-item dropdown">

                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                >
                    <ion-icon
                        class="icones"
                        name="list-circle-outline"
                    ></ion-icon>

                    Doações
                </a>

                <ul class="dropdown-menu">

                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=nova-doacao"
                        >
                            Cadastrar Doação
                        </a>
                    </li>

                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=doacoes"
                        >
                            Listar Doações
                        </a>
                    </li>

                </ul>

            </div>


            <!-- RETIRADAS -->

            <div class="nav-item dropdown">

                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                >
                    <ion-icon
                        class="icones"
                        name="list-circle-outline"
                    ></ion-icon>

                    Retiradas
                </a>

                <ul class="dropdown-menu">

                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=nova-retirada"
                        >
                            Cadastrar Retirada
                        </a>
                    </li>

                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=retiradas"
                        >
                            Listar Retiradas
                        </a>
                    </li>

                </ul>

            </div>


            <!-- UBS -->

            <div class="nav-item dropdown">

                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                >
                    <ion-icon
                        class="icones"
                        name="business-outline"
                    ></ion-icon>

                    UBS
                </a>

                <ul class="dropdown-menu">

                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=nova-ubs"
                        >
                            Cadastrar UBS
                        </a>
                    </li>

                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=ubs"
                        >
                            Listar UBS
                        </a>
                    </li>

                </ul>

            </div>


            <!-- USUÁRIO -->

            <div class="nav-item dropdown">

                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                >
                    <ion-icon
                        class="icones"
                        name="person-circle-outline"
                    ></ion-icon>

                    <?= htmlspecialchars(
                        $_SESSION['usuario'] ?? ''
                    ); ?>

                </a>

                <ul class="dropdown-menu">


                    <!-- OPÇÕES SOMENTE PARA ADMIN -->

                    <?php if (AuthMiddleware::isAdmin()): ?>

                        <li>
                            <a
                                class="dropdown-item"
                                href="index.php?rota=usuarios"
                            >
                                Funcionários
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="index.php?rota=novo-usuario"
                            >
                                Cadastrar Funcionário
                            </a>
                        </li>

                    <?php endif; ?>


                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=editar-estoque"
                        >
                            Editar Estoque
                        </a>
                    </li>


                    <li>
                        <a
                            class="dropdown-item"
                            href="index.php?rota=logout"
                        >
                            Encerrar sessão
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </nav>

</header>


<br><br>


<!-- =========================
     CONTEÚDO PRINCIPAL
========================== -->

<div class="container">

    <div class="content">

        <?= $content ?? ''; ?>

    </div>

</div>


<!-- =========================
     RODAPÉ
========================== -->

<footer>

    <div class="container">

        <div class="footer-content">

            <p>
                &copy;
                <span id="anoAtual"></span>
                Banco de Sangue de Taquaritinga.
                <br>
                Todos os direitos reservados
            </p>


            <div class="footer-address">

                <p>
                    <strong>Navegação:</strong>
                </p>

                <a
                    href="index.php?rota=dashboard"
                    class="footer-link"
                >
                    Dashboard
                </a>

                <a
                    href="index.php?rota=novo"
                    class="footer-link"
                >
                    Cadastrar Doador
                </a>

                <a
                    href="index.php?rota=doadores"
                    class="footer-link"
                >
                    Listar Doadores
                </a>

            </div>


            <div class="footer-address">

                <p>
                    <strong>Endereço:</strong>
                </p>

                <p>
                    <i class="fas fa-map-marker-alt"></i>

                    Av. Dr. Flávio Henrique Lemos, 585
                </p>

            </div>


            <div class="footer-contact">

                <p>
                    <strong>Contato:</strong>
                </p>

                <p>
                    <i class="fas fa-envelope"></i>
                    contato@bancodesanguetaq.com
                </p>

                <p>
                    <i class="fas fa-phone"></i>
                    (16) 1234-5678
                </p>

            </div>

        </div>

    </div>

</footer>


<!-- =========================
     IONICONS
========================== -->

<script
    type="module"
    src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
></script>

<script
    nomodule
    src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
></script>


<!-- =========================
     JAVASCRIPT
========================== -->

<script>

const anoElemento =
    document.getElementById('anoAtual');

if (anoElemento) {
    anoElemento.textContent =
        new Date().getFullYear();
}


const abrirMenu =
    document.getElementById('abrirMenu');

const fecharMenu =
    document.getElementById('fecharMenu');

const menuFullscreen =
    document.getElementById('menuFullscreen');


if (
    abrirMenu &&
    fecharMenu &&
    menuFullscreen
) {

    abrirMenu.addEventListener(
        'click',
        function() {
            menuFullscreen.classList.add(
                'ativo'
            );
        }
    );

    fecharMenu.addEventListener(
        'click',
        function() {
            menuFullscreen.classList.remove(
                'ativo'
            );
        }
    );

}

</script>

</body>

</html>