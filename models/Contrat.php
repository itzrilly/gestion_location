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
    
    public $adresseLocation;
    public $categorieAppartement;
    public $nomLocataire;
    public $prenomLocataire;

    public function __construct($db) {
        $this->conn = $db;
        if (!is_dir($this->exportDir)) {
            mkdir($this->exportDir, 0775, true);
        }
    }

    public function create() {
        $fields = 'etat, dateCreation, dateDebut, dateFin, numAppartement, numLocataire';
        $values = ':etat, :dateCreation, :dateDebut, :dateFin, :numAppartement, :numLocataire';

        if (!empty($this->numContrat)) {
            $fields = 'numContrat, ' . $fields;
            $values = ':numContrat, ' . $values;
        }

        $query = 'INSERT INTO ' . $this->table . ' (' . $fields . ') VALUES (' . $values . ')';

        $stmt = $this->conn->prepare($query);
        
        if (!empty($this->numContrat)) {
            $stmt->bindParam(':numContrat', htmlspecialchars(strip_tags($this->numContrat)));
        }
        $stmt->bindParam(':etat', htmlspecialchars(strip_tags($this->etat)));
        $stmt->bindParam(':dateCreation', htmlspecialchars(strip_tags($this->dateCreation)));
        $stmt->bindParam(':dateDebut', htmlspecialchars(strip_tags($this->dateDebut)));
        $stmt->bindParam(':dateFin', htmlspecialchars(strip_tags($this->dateFin)));
        $stmt->bindParam(':numAppartement', htmlspecialchars(strip_tags($this->numAppartement)));
        $stmt->bindParam(':numLocataire', htmlspecialchars(strip_tags($this->numLocataire)));

        if ($stmt->execute()) {
            if (empty($this->numContrat)) {
                $this->numContrat = $this->conn->lastInsertId();
            }
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
                    a.categorie as categorieAppartement,
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
                    a.categorie as categorieAppartement,
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
            $this->numContrat = $row['numContrat'];
            $this->etat = $row['etat'];
            $this->dateCreation = $row['dateCreation'];
            $this->dateDebut = $row['dateDebut'];
            $this->dateFin = $row['dateFin'];
            $this->numAppartement = $row['numAppartement'];
            $this->numLocataire = $row['numLocataire'];
            $this->adresseLocation = $row['adresseLocation'];
            $this->categorieAppartement = $row['categorieAppartement'];
            $this->nomLocataire = $row['nomLocataire'];
            $this->prenomLocataire = $row['prenomLocataire'];
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
        $xml->addChild('etat', 'Résilier');
        $xml->addChild('dateCreation', $this->dateCreation);
        $xml->addChild('dateDebut', $this->dateDebut);
        $xml->addChild('dateFin', $this->dateFin);
        $xml->addChild('numAppartement', $this->numAppartement);
        $xml->addChild('numLocataire', $this->numLocataire);
        $xml->addChild('adresseLocation', $this->adresseLocation);
        $xml->addChild('categorieAppartement', $this->categorieAppartement);
        $xml->addChild('nomLocataire', $this->nomLocataire);
        $xml->addChild('prenomLocataire', $this->prenomLocataire);


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
            error_log("Error parsing XML for contract {$numContrat}: " . implode(', ', $errors)); // Log l'erreur
            return false;
        }

        return [
            'numContrat' => (int)$xml->numContrat,
            'etat' => (string)$xml->etat,
            'dateCreation' => (string)$xml->dateCreation,
            'dateDebut' => (string)$xml->dateDebut,
            'dateFin' => (string)$xml->dateFin,
            'numAppartement' => (int)$xml->numAppartement,
            'numLocataire' => (int)$xml->numLocataire,
            'adresseLocation' => (string)$xml->adresseLocation,
            'categorieAppartement' => (string)$xml->categorieAppartement,
            'nomLocataire' => (string)$xml->nomLocataire,
            'prenomLocataire' => (string)$xml->prenomLocataire,
        ];
    }

    public function readAllArchivedFromXml() {
        $archivedContrats = [];
        $files = glob($this->exportDir . 'contrat_*.xml');
        foreach ($files as $filePath) {
            $filename = basename($filePath);
            if (preg_match('/contrat_(\d+)\.xml/', $filename, $matches)) {
                $numContrat = (int)$matches[1];
                $contractData = $this->importFromXml($numContrat);
                if ($contractData) {
                    $contractData['etat'] = 'Résilier';
                    $archivedContrats[] = $contractData;
                }
            }
        }
        return $archivedContrats;
    }


    public function deleteXmlFile($numContrat) {
        $filePath = $this->exportDir . 'contrat_' . $numContrat . '.xml';
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return true; 
    }
}
