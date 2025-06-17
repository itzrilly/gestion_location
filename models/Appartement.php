<?php

class Appartement {
    private $conn;
    private $table = 'appartement';

    public $numLocation;
    public $categorie;
    public $type;
    public $nbPersonnes;
    public $adresseLocation;
    public $photo;
    public $equipements;
    public $codeTarif;
    public $numProprietaire;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
                  SET categorie = :categorie, 
                      type = :type, 
                      nbPersonnes = :nbPersonnes, 
                      adresseLocation = :adresseLocation, 
                      photo = :photo, 
                      equipements = :equipements, 
                      codeTarif = :codeTarif, 
                      numProprietaire = :numProprietaire';

        $stmt = $this->conn->prepare($query);

        $this->categorie = htmlspecialchars(strip_tags($this->categorie));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->nbPersonnes = htmlspecialchars(strip_tags($this->nbPersonnes));
        $this->adresseLocation = htmlspecialchars(strip_tags($this->adresseLocation));
        $this->photo = htmlspecialchars(strip_tags($this->photo));
        $this->equipements = htmlspecialchars(strip_tags($this->equipements));
        $this->codeTarif = htmlspecialchars(strip_tags($this->codeTarif));
        $this->numProprietaire = htmlspecialchars(strip_tags($this->numProprietaire));

        $stmt->bindParam(':categorie', $this->categorie);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':nbPersonnes', $this->nbPersonnes);
        $stmt->bindParam(':adresseLocation', $this->adresseLocation);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':equipements', $this->equipements);
        $stmt->bindParam(':codeTarif', $this->codeTarif);
        $stmt->bindParam(':numProprietaire', $this->numProprietaire);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }


    public function read() {
        $query = 'SELECT
                    a.numLocation,
                    a.categorie,
                    a.type,
                    a.nbPersonnes,
                    a.adresseLocation,
                    a.photo,
                    a.equipements,
                    a.codeTarif,
                    t.prixSemHs,
                    t.prixSemBs,
                    a.numProprietaire,
                    p.nom as proprietaire_nom,
                    p.prenom as proprietaire_prenom
                  FROM
                    ' . $this->table . ' a
                  LEFT JOIN
                    tarif t ON a.codeTarif = t.codeTarif
                  LEFT JOIN
                    proprietaire p ON a.numProprietaire = p.num
                  ORDER BY
                    a.numLocation DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    public function read_single() {
        $query = 'SELECT
                    a.numLocation,
                    a.categorie,
                    a.type,
                    a.nbPersonnes,
                    a.adresseLocation,
                    a.photo,
                    a.equipements,
                    a.codeTarif,
                    t.prixSemHs,
                    t.prixSemBs,
                    a.numProprietaire,
                    p.nom as proprietaire_nom,
                    p.prenom as proprietaire_prenom
                  FROM
                    ' . $this->table . ' a
                  LEFT JOIN
                    tarif t ON a.codeTarif = t.codeTarif
                  LEFT JOIN
                    proprietaire p ON a.numProprietaire = p.num
                  WHERE
                    a.numLocation = ?
                  LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->numLocation);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->categorie = $row['categorie'];
            $this->type = $row['type'];
            $this->nbPersonnes = $row['nbPersonnes'];
            $this->adresseLocation = $row['adresseLocation'];
            $this->photo = $row['photo'];
            $this->equipements = $row['equipements'];
            $this->codeTarif = $row['codeTarif'];
            $this->numProprietaire = $row['numProprietaire'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . '
                  SET
                    categorie = :categorie,
                    type = :type,
                    nbPersonnes = :nbPersonnes,
                    adresseLocation = :adresseLocation,
                    photo = :photo,
                    equipements = :equipements,
                    codeTarif = :codeTarif,
                    numProprietaire = :numProprietaire
                  WHERE
                    numLocation = :numLocation';

        $stmt = $this->conn->prepare($query);

        $this->categorie = htmlspecialchars(strip_tags($this->categorie));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->nbPersonnes = htmlspecialchars(strip_tags($this->nbPersonnes));
        $this->adresseLocation = htmlspecialchars(strip_tags($this->adresseLocation));
        $this->photo = htmlspecialchars(strip_tags($this->photo));
        $this->equipements = htmlspecialchars(strip_tags($this->equipements));
        $this->codeTarif = htmlspecialchars(strip_tags($this->codeTarif));
        $this->numProprietaire = htmlspecialchars(strip_tags($this->numProprietaire));
        $this->numLocation = htmlspecialchars(strip_tags($this->numLocation));

        $stmt->bindParam(':categorie', $this->categorie);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':nbPersonnes', $this->nbPersonnes);
        $stmt->bindParam(':adresseLocation', $this->adresseLocation);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':equipements', $this->equipements);
        $stmt->bindParam(':codeTarif', $this->codeTarif);
        $stmt->bindParam(':numProprietaire', $this->numProprietaire);
        $stmt->bindParam(':numLocation', $this->numLocation);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
