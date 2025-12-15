<?php
// /includes/db.php

class Database {
    private static $host = 'localhost';
    private static $db_name = 'ifticket';
    private static $username = 'root'; // ALtere para seu usuário
    private static $password = '';     // ALtere para sua senha
    private static $conn;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4";
                self::$conn = new PDO($dsn, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $exception) {
                // Em ambiente de produção, logar o erro e mostrar uma mensagem genérica
                echo "Erro de conexão: " . $exception->getMessage();
                exit();
            }
        }
        return self::$conn;
    }
}
?>