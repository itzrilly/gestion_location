<?php

class LocataireController {
    private $db;
    private $locataire;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->locataire = new Locataire($this->db);
    }

    public function index() {
        $result = $this->locataire->read();
        $locataires = $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->locataire->nomLocataire = $_POST['nomLocataire'] ?? '';
            $this->locataire->prenomLocataire = $_POST['prenomLocataire'] ?? '';
            $this->locataire->adresse1Locataire = $_POST['adresse1Locataire'] ?? '';
            $this->locataire->adresse2Locataire = $_POST['adresse2Locataire'] ?? '';
            $this->locataire->codePostalLocataire = $_POST['codePostalLocataire'] ?? '';
            $this->locataire->villeLocataire = $_POST['villeLocataire'] ?? '';
            $this->locataire->numTel1Locataire = $_POST['numTel1Locataire'] ?? '';
            $this->locataire->numTel2Locataire = $_POST['numTel2Locataire'] ?? '';
            $this->locataire->emailLocataire = $_POST['emailLocataire'] ?? '';

            if ($this->locataire->create()) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Locataire créé avec succès'
                ];
                header('Location: index.php?controller=locataire&action=create');
                exit();
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Erreur lors de la création du locataire'
                ];
                header('Location: index.php?controller=locataire&action=create');
                exit();
            }
        }

        require_once 'views/locataire/create.php';
    }

    public function print() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $stmt = $this->locataire->read();
        $locataires = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/locataire/print.php';
    }
}
