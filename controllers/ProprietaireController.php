<?php

class ProprietaireController {
    private $db;
    private $proprietaire;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->proprietaire = new Proprietaire($this->db);
    }

    public function index() {
        $result = $this->proprietaire->read();
        $proprietaires = $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->proprietaire->nom = $_POST['nom'] ?? '';
            $this->proprietaire->prenom = $_POST['prenom'] ?? '';
            $this->proprietaire->adresse1 = $_POST['adresse1'] ?? '';
            $this->proprietaire->adresse2 = $_POST['adresse2'] ?? '';
            $this->proprietaire->codePostal = $_POST['codePostal'] ?? '';
            $this->proprietaire->ville = $_POST['ville'] ?? '';
            $this->proprietaire->numTel1 = $_POST['numTel1'] ?? '';
            $this->proprietaire->numTel2 = $_POST['numTel2'] ?? '';

            $this->proprietaire->caCumule = isset($_POST['caCumule']) && is_numeric($_POST['caCumule']) ? (float)$_POST['caCumule'] : 0.00;
            $this->proprietaire->email = $_POST['email'] ?? '';

            if ($this->proprietaire->create()) {
                header('Location: index.php?controller=home&action=index');
                exit(); 
            } else {
                echo "Erreur lors de la création du propriétaire.";
            }
        }
        
        require_once 'views/proprietaire/create.php';
    }

    public function print() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $stmt = $this->proprietaire->read();
        $proprietaires = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        require_once 'views/proprietaire/print.php';
    }
}
