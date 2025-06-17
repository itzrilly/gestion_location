<?php

class Proprietaire {
    private $conn;
    private $table = 'proprietaire';

    public $num;
    public $nom;
    public $prenom;
    public $adresse1;
    public $adresse2;
    public $codePostal;
    public $ville;
    public $numTel1;
    public $numTel2;
    public $caCumule;
    public $email;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . '
                  SET
                    nom = :nom,
                    prenom = :prenom,
                    adresse1 = :adresse1,
                    adresse2 = :adresse2,
                    codePostal = :codePostal,
                    ville = :ville,
                    numTel1 = :numTel1,
                    numTel2 = :numTel2,
                    caCumule = :caCumule,
                    email = :email';

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->adresse1 = htmlspecialchars(strip_tags($this->adresse1));
        $this->adresse2 = htmlspecialchars(strip_tags($this->adresse2));
        $this->codePostal = htmlspecialchars(strip_tags($this->codePostal));
        $this->ville = htmlspecialchars(strip_tags($this->ville));
        $this->numTel1 = htmlspecialchars(strip_tags($this->numTel1));
        $this->numTel2 = htmlspecialchars(strip_tags($this->numTel2));
        $this->caCumule = htmlspecialchars(strip_tags($this->caCumule));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':adresse1', $this->adresse1);
        $stmt->bindParam(':adresse2', $this->adresse2);
        $stmt->bindParam(':codePostal', $this->codePostal);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':numTel1', $this->numTel1);
        $stmt->bindParam(':numTel2', $this->numTel2);
        $stmt->bindParam(':caCumule', $this->caCumule);
        $stmt->bindParam(':email', $this->email);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function read() {
        $query = 'SELECT
                    num,
                    nom,
                    prenom,
                    adresse1,
                    adresse2,
                    codePostal,
                    ville,
                    numTel1,
                    numTel2,
                    caCumule,
                    email
                  FROM
                    ' . $this->table . '
                  ORDER BY
                    num DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT
                    num,
                    nom,
                    prenom,
                    adresse1,
                    adresse2,
                    codePostal,
                    ville,
                    numTel1,
                    numTel2,
                    caCumule,
                    email
                  FROM
                    ' . $this->table . '
                  WHERE
                    num = ?
                  LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->num);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nom = $row['nom'];
            $this->prenom = $row['prenom'];
            $this->adresse1 = $row['adresse1'];
            $this->adresse2 = $row['adresse2'];
            $this->codePostal = $row['codePostal'];
            $this->ville = $row['ville'];
            $this->numTel1 = $row['numTel1'];
            $this->numTel2 = $row['numTel2'];
            $this->caCumule = $row['caCumule'];
            $this->email = $row['email'];
            return true;
        }
        return false;
    }
    
    public function update() {
        $query = 'UPDATE ' . $this->table . '
                  SET
                    nom = :nom,
                    prenom = :prenom,
                    adresse1 = :adresse1,
                    adresse2 = :adresse2,
                    codePostal = :codePostal,
                    ville = :ville,
                    numTel1 = :numTel1,
                    numTel2 = :numTel2,
                    caCumule = :caCumule,
                    email = :email
                  WHERE
                    num = :num';

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->adresse1 = htmlspecialchars(strip_tags($this->adresse1));
        $this->adresse2 = htmlspecialchars(strip_tags($this->adresse2));
        $this->codePostal = htmlspecialchars(strip_tags($this->codePostal));
        $this->ville = htmlspecialchars(strip_tags($this->ville));
        $this->numTel1 = htmlspecialchars(strip_tags($this->numTel1));
        $this->numTel2 = htmlspecialchars(strip_tags($this->numTel2));
        $this->caCumule = htmlspecialchars(strip_tags($this->caCumule));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->num = htmlspecialchars(strip_tags($this->num));

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':adresse1', $this->adresse1);
        $stmt->bindParam(':adresse2', $this->adresse2);
        $stmt->bindParam(':codePostal', $this->codePostal);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':numTel1', $this->numTel1);
        $stmt->bindParam(':numTel2', $this->numTel2);
        $stmt->bindParam(':caCumule', $this->caCumule);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':num', $this->num);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE num = :num';
        $stmt = $this->conn->prepare($query);

        $this->num = htmlspecialchars(strip_tags($this->num));

        $stmt->bindParam(':num', $this->num);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
