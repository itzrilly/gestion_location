<?php

class AppartementController {
    private $db;
    private $appartement;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->appartement = new Appartement($this->db);
    }

    public function create() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tarifExists = $this->checkTarifExists($_POST['codeTarif']);
            $proprietaireExists = $this->checkProprietaireExists($_POST['numProprietaire']);

            if(!$tarifExists || !$proprietaireExists) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => !$tarifExists ? 'Le code tarif n\'existe pas' : 'Le propriétaire n\'existe pas'
                ];
                header('Location: ?controller=appartement&action=create');
                exit;
            }

            $uploadDir = 'uploads/';
            if(!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $photoName = '';
            if(!empty($_FILES['photo']['name'])) {
                $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $photoName = uniqid() . '.' . $extension;
                $uploadFile = $uploadDir . $photoName;
                
                if(move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                    $this->appartement->photo = $uploadFile;
                } else {
                    $_SESSION['flash'] = [
                        'type' => 'danger',
                        'message' => 'Erreur lors du téléchargement de la photo.'
                    ];
                    header('Location: ?controller=appartement&action=create');
                    exit;
                }
            } else {
                $this->appartement->photo = '';
            }

            $this->appartement->categorie = $_POST['categorie'] ?? '';
            $this->appartement->type = $_POST['type'] ?? '';
            $this->appartement->nbPersonnes = $_POST['nbPersonnes'] ?? 0;
            $this->appartement->adresseLocation = $_POST['adresseLocation'] ?? '';
            $this->appartement->equipements = $_POST['equipements'] ?? '';
            $this->appartement->codeTarif = $_POST['codeTarif'] ?? null;
            $this->appartement->numProprietaire = $_POST['numProprietaire'] ?? null;

            if($this->appartement->create()) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Appartement créé avec succès'
                ];
                header('Location: ?controller=appartement&action=create');
                exit;
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Erreur lors de la création de l\'appartement'
                ];
                header('Location: ?controller=appartement&action=create');
                exit;
            }
        }
        
        $tarifs = $this->getTarifs();
        $proprietaires = $this->getProprietaires();
        
        require_once 'views/appartement/create.php';
    }

    private function checkTarifExists($codeTarif) {
        $query = "SELECT COUNT(*) FROM tarif WHERE codeTarif = :codeTarif";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':codeTarif', $codeTarif);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    private function checkProprietaireExists($numProprietaire) {
        $query = "SELECT COUNT(*) FROM proprietaire WHERE num = :numProprietaire";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':numProprietaire', $numProprietaire);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    private function getTarifs() {
        $query = "SELECT codeTarif, prixSemHs, prixSemBs FROM tarif";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    private function getProprietaires() {
        $query = "SELECT num, nom, prenom FROM proprietaire";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
