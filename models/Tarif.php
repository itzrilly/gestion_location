<?php

class Tarif {
    private $conn;
    private $table = 'tarif';

    public $codeTarif;
    public $prixSemHs;
    public $prixSemBs;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET prixSemHs = :prixSemHs, prixSemBs = :prixSemBs';

        $stmt = $this->conn->prepare($query);

        $this->prixSemHs = htmlspecialchars(strip_tags($this->prixSemHs));
        $this->prixSemBs = htmlspecialchars(strip_tags($this->prixSemBs));

        $stmt->bindParam(':prixSemHs', $this->prixSemHs);
        $stmt->bindParam(':prixSemBs', $this->prixSemBs);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function read() {
        $query = 'SELECT codeTarif, prixSemHs, prixSemBs FROM ' . $this->table . ' ORDER BY codeTarif DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT codeTarif, prixSemHs, prixSemBs FROM ' . $this->table . ' WHERE codeTarif = ? LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->codeTarif);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->prixSemHs = $row['prixSemHs'];
            $this->prixSemBs = $row['prixSemBs'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET prixSemHs = :prixSemHs, prixSemBs = :prixSemBs WHERE codeTarif = :codeTarif';

        $stmt = $this->conn->prepare($query);

        $this->prixSemHs = htmlspecialchars(strip_tags($this->prixSemHs));
        $this->prixSemBs = htmlspecialchars(strip_tags($this->prixSemBs));
        $this->codeTarif = htmlspecialchars(strip_tags($this->codeTarif));

        $stmt->bindParam(':prixSemHs', $this->prixSemHs);
        $stmt->bindParam(':prixSemBs', $this->prixSemBs);
        $stmt->bindParam(':codeTarif', $this->codeTarif);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE codeTarif = :codeTarif';
        $stmt = $this->conn->prepare($query);

        $this->codeTarif = htmlspecialchars(strip_tags($this->codeTarif));

        $stmt->bindParam(':codeTarif', $this->codeTarif);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}