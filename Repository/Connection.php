<?php
include './LoadFirst.php';
class Connection
{
    private $pdo;

    public function __construct()
    {
        $user = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];
        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_DATABASE'];
        $port = $_ENV['DB_PORT'];

        try {
            if ($port) {
                $dsn = "mysql:host=$host;dbname=$db;port=$port";
            } else {
                $dsn = "mysql:host=$host;dbname=$db";
            }

            $this->pdo = new PDO($dsn, $user, $pass);
        } catch (\Exception $e) {
            echo $e->getMessage();
            $this->pdo = null;
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}