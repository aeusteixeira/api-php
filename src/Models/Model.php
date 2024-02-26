<?php

namespace App\Models;

use App\Config\Database;
use Exception;
use PDO;
use PDOException;
use PDOStatement;

abstract class Model {
    protected $connection;
    protected $table;

    /**
     * Construtor da classe Model.
     * 
     * Conecta ao banco de dados.
     */
    public function __construct() {
        try {
            $database = new Database();
            $this->connection = $database->getConnection();
        } catch (PDOException $e) {
            throw new Exception("Erro de conexão: " . $e->getMessage());
        }
    }

    /**
     * Cria um novo registro na tabela.
     *
     * @param array $data Dados do novo registro.
     * @return array Dados do registro recém-criado.
     */
    public function create(array $data): array {
        try {
            $fields = $this->getFields($data);
            $placeholders = $this->getPlaceholders($data);
            $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
            $stmt = $this->prepareAndBind($sql, $data);
            $stmt->execute();
            return $this->findOrFail($this->connection->lastInsertId());
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar registro: " . $e->getMessage());
        }
    }

    /**
     * Lê um registro da tabela pelo ID ou retorna uma exceção se não encontrado.
     *
     * @param int $id ID do registro a ser lido.
     * @return array Dados do registro.
     * @throws Exception Se o registro não for encontrado.
     */
    public function findOrFail(int $id): array {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                throw new Exception("Registro não encontrado.");
            }
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Erro ao ler registro: " . $e->getMessage());
        }
    }


    /**
     * Atualiza um registro na tabela pelo ID.
     *
     * @param int $id ID do registro a ser atualizado.
     * @param array $data Dados para atualização.
     * @return array Dados do registro atualizado.
     */
    public function update($id, $data) {
        try {
            $updates = $this->getUpdateString($data);
            if (empty($updates)) {
                throw new Exception("Nenhum dado fornecido para atualização");
            }
    
            $sql = "UPDATE {$this->table} SET {$updates} WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
    
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->bindValue(':id', $id);
    
            $stmt->execute();
            return $this->findOrFail($id);
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar registro: " . $e->getMessage());
        }
    }
    

    /**
     * Deleta um registro da tabela pelo ID.
     *
     * @param int $id ID do registro a ser deletado.
     * @return bool Verdadeiro se o registro foi deletado, falso caso contrário.
     * @throws Exception Se o registro não for encontrado ou ocorrer um erro ao deletar.
     */
    public function delete(int $id): bool {
        $this->findOrFail($id);

        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao deletar registro: " . $e->getMessage());
        }
    }


    /**
     * Obtém todos os registros da tabela associada ao modelo.
     *
     * Este método executa uma consulta SQL para selecionar todos os registros
     * da tabela especificada na propriedade `$table` do modelo. Ele retorna
     * um array de arrays associativos, onde cada array interno representa um
     * registro da tabela.
     *
     * @return array|null Um array de registros ou null em caso de falha.
     * @throws Exception Se ocorrer um erro durante a execução da consulta SQL.
     */
    public function all(): ?array {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar todos os registros: " . $e->getMessage());
        }
    }


    /**
     * Obtém a relação entre modelos.
     *
     * @param string $relatedModel Modelo relacionado.
     * @param string $foreignKey Chave estrangeira.
     * @param mixed $localKeyValue Valor da chave local.
     * @return array Relação entre modelos.
     */
    public function getRelationship(string $relatedModel, string $foreignKey, $localKeyValue): array {
        try {
            $relatedTable = (new $relatedModel())->getTable();
            $sql = "SELECT * FROM {$relatedTable} WHERE {$foreignKey} = :localKeyValue";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':localKeyValue', $localKeyValue);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao obter relação: " . $e->getMessage());
        }
    }

    /**
     * Obtém o nome da tabela do modelo.
     *
     * @return string Nome da tabela.
     */
    public function getTable(): string {
        return $this->table;
    }

/**
 * Prepara e vincula valores a uma declaração SQL.
 *
 * @param string $sql Declaração SQL.
 * @param array $data Dados para vincular.
 * @param int|null $id ID opcional para vincular.
 * @return PDOStatement Declaração preparada.
 */
private function prepareAndBind(string $sql, array $data, ?int $id = null): PDOStatement {
    $stmt = $this->connection->prepare($sql);
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    if ($id !== null) {
        $stmt->bindValue(':id', $id);
    }
    return $stmt;
}


    /**
     * Obtém uma string de campos separados por vírgula a partir de um array de dados.
     *
     * @param array $data Dados para extrair os campos.
     * @return string String de campos separados por vírgula.
     */
    private function getFields(array $data): string {
        return implode(', ', array_keys($data));
    }

    /**
     * Obtém uma string de placeholders separados por vírgula a partir de um array de dados.
     *
     * @param array $data Dados para extrair os placeholders.
     * @return string String de placeholders separados por vírgula.
     */
    private function getPlaceholders(array $data): string {
        return ':' . implode(', :', array_keys($data));
    }

    /**
     * Obtém uma string de atualizações para uma declaração SQL a partir de um array de dados.
     *
     * @param array $data Dados para criar a string de atualizações.
     * @return string String de atualizações para uma declaração SQL.
     */
    private function getUpdateString($data) {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = :$key";
        }
        return implode(', ', $updates);
    }

}