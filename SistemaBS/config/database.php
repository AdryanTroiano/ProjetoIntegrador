<?php

class Database
{
    private const HOST = 'localhost';
    private const DB_NAME = 'BSTQ';
    private const USER = 'root';
    private const PASSWORD = '';

    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    'mysql:host=' . self::HOST . ';dbname=' . self::DB_NAME . ';charset=utf8mb4',
                    self::USER,
                    self::PASSWORD
                );

                self::$connection->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                self::$connection->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );

            } catch (PDOException $e) {
                die('Falha na conexão com o banco de dados: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}