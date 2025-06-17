<?php

class Locataire {
    private $conn;
    private $table = 'locataire';

    public $numLocataire;
    public $nomLocataire;
    public $prenomLocataire;
    public $adresse1Locataire;
    public $adresse2Locataire;
    public $codePostalLocataire;
    public $villeLocataire;
    public $numTel1Locataire;
    public $numTel2Locataire;
    public $emailLocataire;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . '
                  SET
                    nomLocataire = :nomLocataire,
                    prenomLocataire = :prenomLocataire,
                    adresse1Locataire = :adresse1Locataire,
                    adresse2Locataire = :adresse2Locataire,
                    codePostalLocataire = :codePostalLocataire,
                    villeLocataire = :villeLocataire,
                    numTel1Locataire = :numTel1Locataire,
                    numTel2Locataire = :numTel2Locataire,
                    emailLocataire = :emailLocataire';

        $stmt = $this->conn->prepare($query);

        $this->nomLocataire = htmlspecialchars(strip_tags($this->nomLocataire));
        $this->prenomLocataire = htmlspecialchars(strip_tags($this->prenomLocataire));
        $this->adresse1Locataire = htmlspecialchars(strip_tags($this->adresse1Locataire));
        $this->adresse2Locataire = htmlspecialchars(strip_tags($this->adresse2Locataire));
        $this->codePostalLocataire = htmlspecialchars(strip_tags($this->codePostalLocataire));
        $this->villeLocataire = htmlspecialchars(strip_tags($this->villeLocataire));
        $this->numTel1Locataire = htmlspecialchars(strip_tags($this->numTel1Locataire));
        $this->numTel2Locataire = htmlspecialchars(strip_tags($this->numTel2Locataire));
        $this->emailLocataire = htmlspecialchars(strip_tags($this->emailLocataire));

        $stmt->bindParam(':nomLocataire', $this->nomLocataire);
        $stmt->bindParam(':prenomLocataire', $this->prenomLocataire);
        $stmt->bindParam(':adresse1Locataire', $this->adresse1Locataire);
        $stmt->bindParam(':adresse2Locataire', $this->adresse2Locataire);
        $stmt->bindParam(':codePostalLocataire', $this->codePostalLocataire);
        $stmt->bindParam(':villeLocataire', $this->villeLocataire);
        $stmt->bindParam(':numTel1Locataire', $this->numTel1Locataire);
        $stmt->bindParam(':numTel2Locataire', $this->numTel2Locataire);
        $stmt->bindParam(':emailLocataire', $this->emailLocataire);

        if ($stmt->execute()) {
            return true;
        }
        
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function read() {
        $query = 'SELECT
                    numLocataire,
                    nomLocataire,
                    prenomLocataire,
                    adresse1Locataire,
                    adresse2Locataire,
                    codePostalLocataire,
                    villeLocataire,
                    numTel1Locataire,
                    numTel2Locataire,
                    emailLocataire
                  FROM
                    ' . $this->table . '
                  ORDER BY
                    numLocataire DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT
                    numLocataire,
                    nomLocataire,
                    prenomLocataire,
                    adresse1Locataire,
                    adresse2Locataire,
                    codePostalLocataire,
                    villeLocataire,
                    numTel1Locataire,
                    numTel2Locataire,
                    emailLocataire
                  FROM
                    ' . $this->table . '
                  WHERE
                    numLocataire = ?
                  LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->numLocataire);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nomLocataire = $row['nomLocataire'];
            $this->prenomLocataire = $row['prenomLocataire'];
            $this->adresse1Locataire = $row['adresse1Locataire'];
            $this->adresse2Locataire = $row['adresse2Locataire'];
            $this->codePostalLocataire = $row['codePostalLocataire'];
            $this->villeLocataire = $row['villeLocataire'];
            $this->numTel1Locataire = $row['numTel1Locataire'];
            $this->numTel2Locataire = $row['numTel2Locataire'];
            $this->emailLocataire = $row['emailLocataire'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . '
                  SET
                    nomLocataire = :nomLocataire,
                    prenomLocataire = :prenomLocataire,
                    adresse1Locataire = :adresse1Locataire,
                    adresse2Locataire = :adresse2Locataire,
                    codePostalLocataire = :codePostalLocataire,
                    villeLocataire = :villeLocataire,
                    numTel1Locataire = :numTel1Locataire,
                    numTel2Locataire = :numTel2Locataire,
                    emailLocataire = :emailLocataire
                  WHERE
                    numLocataire = :numLocataire';

        $stmt = $this->conn->prepare($query);

        $this->nomLocataire = htmlspecialchars(strip_tags($this->nomLocataire));
        $this->prenomLocataire = htmlspecialchars(strip_tags($this->prenomLocataire));
        $this->adresse1Locataire = htmlspecialchars(strip_tags($this->adresse1Locataire));
        $this->adresse2Locataire = htmlspecialchars(strip_tags($this->adresse2Locataire));
        $this->codePostalLocataire = htmlspecialchars(strip_tags($this->codePostalLocataire));
        $this->villeLocataire = htmlspecialchars(strip_tags($this->villeLocataire));
        $this->numTel1Locataire = htmlspecialchars(strip_tags($this->numTel1Locataire));
        $this->numTel2Locataire = htmlspecialchars(strip_tags($this->numTel2Locataire));
        $this->emailLocataire = htmlspecialchars(strip_tags($this->emailLocataire));
        $this->numLocataire = htmlspecialchars(strip_tags($this->numLocataire));

        $stmt->bindParam(':nomLocataire', $this->nomLocataire);
        $stmt->bindParam(':prenomLocataire', $this->prenomLocataire);
        $stmt->bindParam(':adresse1Locataire', $this->adresse1Locataire);
        $stmt->bindParam(':adresse2Locataire', $this->adresse2Locataire);
        $stmt->bindParam(':codePostalLocataire', $this->codePostalLocataire);
        $stmt->bindParam(':villeLocataire', $this->villeLocataire);
        $stmt->bindParam(':numTel1Locataire', $this->numTel1Locataire);
        $stmt->bindParam(':numTel2Locataire', $this->numTel2Locataire);
        $stmt->bindParam(':emailLocataire', $this->emailLocataire);
        $stmt->bindParam(':numLocataire', $this->numLocataire);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE numLocataire = :numLocataire';
        $stmt = $this->conn->prepare($query);

        $this->numLocataire = htmlspecialchars(strip_tags($this->numLocataire));

        $stmt->bindParam(':numLocataire', $this->numLocataire);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
