<?php
namespace App\Table;

use PDO;
use Exception;
use App\PaginatedQuery;
use App\Table\Exception\NotFoundException;

abstract class Table{
    
    protected $pdo;
    protected $table =null;
    protected $class = null;

    public function __construct(PDO $pdo){
        if ($this->table === null) {
            throw new Exception("la classe " . get_class($this) . " n'a pas de propriete \$table");
        }
        if ($this->class === null) {
            throw new Exception("la classe " . get_class($this) . " n'a pas de propriete \$table");
        }
        $this->pdo = $pdo;
    }
    public function find(int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM  '. $this->table.' WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch() ?: null;
        if($result === false){
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    /** cette methode nous permettra de verifier si un champs existe
     * elle verifie siune valeur existe dans la table
     * @param string $field champs a rechercher
     * @param mixted $value valeur associe au champs
     */
    public function exists (string $field, $value, ?int $excerpt = null): bool{
        $sql = "SELECT COUNT(id) FROM  {$this->table} WHERE $field = ?";
        $params = [$value];
        if($excerpt !== null){
            $sql .= " AND id != ?";
            $params[] = $excerpt;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }

    public function delete(int $id){
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");

        $ok = $query->execute([$id]);
        if ($ok === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }

    public function create(array $data): int {
        $sqlField = [];
        foreach ($data as $key => $value) {
            $sqlField[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("INSERT INTO {$this->table} set ". implode(', ', $sqlField));

        $ok = $query->execute($data);
        if ($ok === false) {
            throw new Exception("Impossible de creer l'enregistrement  dans la table {$this->table}");
        }
        return (int) $this->pdo->lastInsertId();
    }

    public function update(array $data, int $id){
        $sqlField = [];
        foreach ($data as $key => $value) {
            $sqlField[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} set ". implode(', ', $sqlField) . " WHERE id = :id");

        $ok = $query->execute(array_merge($data, ['id' => $id ]));
        if ($ok === false) {
            throw new Exception("Impossible de modifier l'enregistrement  dans la table {$this->table}");
        }
    }

    

    public function all(){
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }
}