<?php

class AuthMiddleware
{
    public static function iniciarSessao(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function verificarLogin(): void
    {
        self::iniciarSessao();

        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?rota=login');
            exit;
        }
    }

    public static function isAdmin(): bool
    {
        self::iniciarSessao();

        return isset($_SESSION['usuario_nivel'])
            && $_SESSION['usuario_nivel'] === 'admin';
    }

    public static function isPadrao(): bool
    {
        self::iniciarSessao();

        return isset($_SESSION['usuario_nivel'])
            && $_SESSION['usuario_nivel'] === 'padrao';
    }

    public static function verificarAdmin(): void
    {
        self::verificarLogin();

        if (!self::isAdmin()) {
            header('Location: index.php?rota=doadores');
            exit;
        }
    }
}