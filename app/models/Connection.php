<?php

class Connection {

    private $pdo;

    public function __construct() {
        $this->loadEnv(__DIR__ . '/../../.env');
        $this->connect();
    }

    private function loadEnv($path) {

        if (!file_exists($path)) {
            throw new Exception(".env file not found at: " . $path);
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {

            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);

            $_ENV[trim($name)] = trim($value);
        }
    }

    private function connect() {
        $required = ['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS'];

        foreach ($required as $var) {
            if (!isset($_ENV[$var])) {
                throw new Exception("Missing environment variable: $var");
            }
        }

        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $db   = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

        $this->pdo = new PDO($dsn, $user, $pass);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function getConnection() {
        return $this->pdo;
    }
}