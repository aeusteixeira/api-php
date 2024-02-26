<?php

namespace App\Config;

use PDO;
use PDOException;
use Dotenv;

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $connection;

    /**
     * Construtor da classe Database.
     * 
     * Define as configurações do banco de dados a partir das variáveis de ambiente.
     */
    public function __construct() {
        $this->host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASSWORD;
    }

    /**
     * Obtém a conexão com o banco de dados.
     *
     * @return PDO|null A conexão com o banco de dados ou null em caso de falha.
     */
    public function getConnection(): ?PDO {
        $this->connection = null;

        try {
            $dsn = $this->getDsn();
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->setCharset();
        } catch (PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }

        return $this->connection;
    }

    /**
     * Constrói a string DSN para a conexão PDO.
     *
     * @return string A string DSN.
     */
    private function getDsn(): string {
        return "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
    }

    /**
     * Define o charset da conexão para UTF-8.
     */
    private function setCharset(): void {
        $this->connection->exec("set names utf8");
    }
}
