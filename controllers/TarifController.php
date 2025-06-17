<?php

class TarifController {
    private $db;
    private $tarif;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->tarif = new Tarif($this->db);
    }

    public function index() {
        $result = $this->tarif->read();
        $tarifs = $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tarif->prixSemHs = $_POST['prixSemHs'] ?? null;
            $this->tarif->prixSemBs = $_POST['prixSemBs'] ?? null;

            if ($this->tarif->create()) {
                header('Location: index.php?controller=home&action=index'); 
                exit();
            } else {
                echo "Erreur lors de la création du tarif.";
            }
        }
        require_once 'views/tarif/create.php';
    }
}