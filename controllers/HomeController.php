<?php
class HomeController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function index() {
        $stats = $this->getDashboardStats();
        
        $latestContracts = $this->getLatestContracts(5);
        
        $latestApartments = $this->getLatestApartments(5);
        
        require_once 'views/home/index.php';
    }

    private function getDashboardStats() {
        $stats = [
            'total_proprietaires' => 0,
            'total_appartements' => 0,
            'total_locataires' => 0,
            'total_contrats' => 0,
            'contrats_actifs' => 0
        ];

        try {
            $query = "SELECT COUNT(*) as total FROM proprietaire";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_proprietaires'] = $result['total'];

            $query = "SELECT COUNT(*) as total FROM appartement";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_appartements'] = $result['total'];

            $query = "SELECT COUNT(*) as total FROM locataire";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_locataires'] = $result['total'];

            $query = "SELECT COUNT(*) as total FROM contrat";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_contrats'] = $result['total'];

            $query = "SELECT COUNT(*) as total FROM contrat 
                     WHERE dateDebut <= CURDATE() AND dateFin >= CURDATE()";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['contrats_actifs'] = $result['total'];

        } catch(PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }

        return $stats;
    }

    private function getLatestContracts($limit = 5) {
        $query = "SELECT c.numContrat, c.dateDebut, c.dateFin, 
                         l.nomLocataire, l.prenomLocataire,
                         a.adresseLocation
                  FROM contrat c
                  JOIN locataire l ON c.numLocataire = l.numLocataire
                  JOIN appartement a ON c.numAppartement = a.numLocation
                  ORDER BY c.dateCreation DESC
                  LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    private function getLatestApartments($limit = 5) {
        $query = "SELECT a.numLocation, a.categorie, a.type, a.adresseLocation,
                         p.nom as nomProprietaire, p.prenom as prenomProprietaire
                  FROM appartement a
                  JOIN proprietaire p ON a.numProprietaire = p.num
                  ORDER BY a.numLocation DESC
                  LIMIT :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function about() {
        require_once 'views/home/about.php';
    }

    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);
            
            $success = true; 
            
            require_once 'views/home/contact_result.php';
        } else {
            require_once 'views/home/contact.php';
        }
    }
}
?>