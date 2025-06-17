<?php

class Contrat {
    private $conn;
    private $table = 'contrat';
    private $exportDir = __DIR__ . '/../exports/contrats_archives/';

    public $numContrat;
    public $etat;
    public $dateCreation;
    public $dateDebut;
    public $dateFin;
    public $numAppartement;
    public $numLocataire;

    public function __construct($db) {
        $this->conn = $db;
        if (!is_dir($this->exportDir)) {
            mkdir($this->exportDir, 0775, true);
        }
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . '
                  SET
                    etat = :etat,
                    dateCreation = :dateCreation,
                    dateDebut = :dateDebut,
                    dateFin = :dateFin,
                    numAppartement = :numAppartement,
                    numLocataire = :numLocataire';

        $stmt = $this->conn->prepare($query);

        $this->etat = htmlspecialchars(strip_tags($this->etat));
        $this->dateCreation = htmlspecialchars(strip_tags($this->dateCreation));
        $this->dateDebut = htmlspecialchars(strip_tags($this->dateDebut));
        $this->dateFin = htmlspecialchars(strip_tags($this->dateFin));
        $this->numAppartement = htmlspecialchars(strip_tags($this->numAppartement));
        $this->numLocataire = htmlspecialchars(strip_tags($this->numLocataire));

        $stmt->bindParam(':etat', $this->etat);
        $stmt->bindParam(':dateCreation', $this->dateCreation);
        $stmt->bindParam(':dateDebut', $this->dateDebut);
        $stmt->bindParam(':dateFin', $this->dateFin);
        $stmt->bindParam(':numAppartement', $this->numAppartement);
        $stmt->bindParam(':numLocataire', $this->numLocataire);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function read() {
        $query = 'SELECT
                    c.numContrat,
                    c.etat,
                    c.dateCreation,
                    c.dateDebut,
                    c.dateFin,
                    c.numAppartement,
                    a.adresseLocation,
                    a.categorie,
                    c.numLocataire,
                    l.nomLocataire,
                    l.prenomLocataire
                  FROM
                    ' . $this->table . ' c
                  LEFT JOIN
                    appartement a ON c.numAppartement = a.numLocation
                  LEFT JOIN
                    locataire l ON c.numLocataire = l.numLocataire
                  ORDER BY
                    c.dateCreation DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT
                    c.numContrat,
                    c.etat,
                    c.dateCreation,
                    c.dateDebut,
                    c.dateFin,
                    c.numAppartement,
                    a.adresseLocation,
                    a.categorie,
                    c.numLocataire,
                    l.nomLocataire,
                    l.prenomLocataire
                  FROM
                    ' . $this->table . ' c
                  LEFT JOIN
                    appartement a ON c.numAppartement = a.numLocation
                  LEFT JOIN
                    locataire l ON c.numLocataire = l.numLocataire
                  WHERE
                    c.numContrat = ?
                  LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->numContrat);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->etat = $row['etat'];
            $this->dateCreation = $row['dateCreation'];
            $this->dateDebut = $row['dateDebut'];
            $this->dateFin = $row['dateFin'];
            $this->numAppartement = $row['numAppartement'];
            $this->numLocataire = $row['numLocataire'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . '
                  SET
                    etat = :etat,
                    dateCreation = :dateCreation,
                    dateDebut = :dateDebut,
                    dateFin = :dateFin,
                    numAppartement = :numAppartement,
                    numLocataire = :numLocataire
                  WHERE
                    numContrat = :numContrat';

        $stmt = $this->conn->prepare($query);

        $this->etat = htmlspecialchars(strip_tags($this->etat));
        $this->dateCreation = htmlspecialchars(strip_tags($this->dateCreation));
        $this->dateDebut = htmlspecialchars(strip_tags($this->dateDebut));
        $this->dateFin = htmlspecialchars(strip_tags($this->dateFin));
        $this->numAppartement = htmlspecialchars(strip_tags($this->numAppartement));
        $this->numLocataire = htmlspecialchars(strip_tags($this->numLocataire));
        $this->numContrat = htmlspecialchars(strip_tags($this->numContrat));

        $stmt->bindParam(':etat', $this->etat);
        $stmt->bindParam(':dateCreation', $this->dateCreation);
        $stmt->bindParam(':dateDebut', $this->dateDebut);
        $stmt->bindParam(':dateFin', $this->dateFin);
        $stmt->bindParam(':numAppartement', $this->numAppartement);
        $stmt->bindParam(':numLocataire', $this->numLocataire);
        $stmt->bindParam(':numContrat', $this->numContrat);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE numContrat = :numContrat';
        $stmt = $this->conn->prepare($query);

        $this->numContrat = htmlspecialchars(strip_tags($this->numContrat));

        $stmt->bindParam(':numContrat', $this->numContrat);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function exportToXml($numContrat) {
        $this->numContrat = $numContrat;
        if (!$this->read_single()) {
            return false;
        }

        $xml = new SimpleXMLElement('<contrat_archive/>');
        $xml->addChild('numContrat', $this->numContrat);
        $xml->addChild('etat', $this->etat);
        $xml->addChild('dateCreation', $this->dateCreation);
        $xml->addChild('dateDebut', $this->dateDebut);
        $xml->addChild('dateFin', $this->dateFin);
        $xml->addChild('numAppartement', $this->numAppartement);
        $xml->addChild('numLocataire', $this->numLocataire);

        $filePath = $this->exportDir . 'contrat_' . $numContrat . '.xml';
        if ($xml->asXML($filePath)) {
            return $filePath;
        }
        return false;
    }

    public function importFromXml($numContrat) {
        $filePath = $this->exportDir . 'contrat_' . $numContrat . '.xml';
        if (!file_exists($filePath)) {
            return false;
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($filePath);

        if ($xml === false) {
            $errors = [];
            foreach (libxml_get_errors() as $error) {
                $errors[] = $error->message;
            }
            libxml_clear_errors();
            printf("Error parsing XML: %s.\n", implode(', ', $errors));
            return false;
        }

        return [
            'numContrat' => (int)$xml->numContrat,
            'etat' => (string)$xml->etat,
            'dateCreation' => (string)$xml->dateCreation,
            'dateDebut' => (string)$xml->dateDebut,
            'dateFin' => (string)$xml->dateFin,
            'numAppartement' => (int)$xml->numAppartement,
            'numLocataire' => (int)$xml->numLocataire
        ];
    }

    public function deleteXmlFile($numContrat) {
        $filePath = $this->exportDir . 'contrat_' . $numContrat . '.xml';
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return true;
    }
}
