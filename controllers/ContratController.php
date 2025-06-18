<?php

class ContratController {
    private $db;
    private $contrat;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->contrat = new Contrat($this->db);
    }

    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $stmt = $this->contrat->read();
        $activeContrats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $archivedContrats = $this->contrat->readAllArchivedFromXml();
        
        $allContrats = array_merge($activeContrats, $archivedContrats);

        usort($allContrats, function($a, $b) {
            return strtotime($b['dateCreation']) - strtotime($a['dateCreation']);
        });

        $contrats = $allContrats;

        require_once 'views/contrat/index.php';
    }

    public function create() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appartementExists = $this->checkAppartementExists($_POST['numAppartement']);
            $locataireExists = $this->checkLocataireExists($_POST['numLocataire']);

            if (!$appartementExists || !$locataireExists) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Erreur de validation : ' .
                                 (!$appartementExists ? 'L\'appartement sélectionné n\'existe pas.' : '') .
                                 (!$locataireExists ? ' Le locataire sélectionné n\'existe pas.' : '')
                ];
                header('Location: ?controller=contrat&action=create');
                exit;
            }

            $this->contrat->numContrat = null;
            $this->contrat->etat = $_POST['etat'] ?? '';
            $this->contrat->dateCreation = $_POST['dateCreation'] ?? date('Y-m-d');
            $this->contrat->dateDebut = $_POST['dateDebut'] ?? '';
            $this->contrat->dateFin = $_POST['dateFin'] ?? '';
            $this->contrat->numAppartement = $_POST['numAppartement'] ?? null;
            $this->contrat->numLocataire = $_POST['numLocataire'] ?? null;

            if ($this->contrat->create()) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Contrat créé avec succès.'
                ];
                header('Location: ?controller=contrat&action=index');
                exit;
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Erreur lors de la création du contrat.'
                ];
                header('Location: ?controller=contrat&action=create');
                exit;
            }
        }
        
        $appartements = $this->getAppartements();
        $locataires = $this->getLocataires();
        
        require_once 'views/contrat/create.php';
    }

    public function edit() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $numContrat = $_GET['id'] ?? $_POST['numContrat'] ?? null;

        $contratInDb = $this->contrat->read_single();
        if (!$contratInDb) {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Ce contrat est archivé et ne peut pas être modifié directement. Veuillez le rétablir d\'abord.'
            ];
            header('Location: ?controller=contrat&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appartementExists = $this->checkAppartementExists($_POST['numAppartement']);
            $locataireExists = $this->checkLocataireExists($_POST['numLocataire']);

            if (!$appartementExists || !$locataireExists) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Erreur de validation : ' .
                                 (!$appartementExists ? 'L\'appartement sélectionné n\'existe pas.' : '') .
                                 (!$locataireExists ? ' Le locataire sélectionné n\'existe pas.' : '')
                ];
                header('Location: ?controller=contrat&action=edit&id=' . $numContrat);
                exit;
            }

            $this->contrat->numContrat = $numContrat;
            $this->contrat->etat = $_POST['etat'] ?? '';
            $this->contrat->dateCreation = $_POST['dateCreation'] ?? '';
            $this->contrat->dateDebut = $_POST['dateDebut'] ?? '';
            $this->contrat->dateFin = $_POST['dateFin'] ?? '';
            $this->contrat->numAppartement = $_POST['numAppartement'] ?? null;
            $this->contrat->numLocataire = $_POST['numLocataire'] ?? null;

            if ($this->contrat->update()) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Contrat mis à jour avec succès.'
                ];
                header('Location: ?controller=contrat&action=index');
                exit;
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Erreur lors de la mise à jour du contrat.'
                ];
                header('Location: ?controller=contrat&action=edit&id=' . $numContrat);
                exit;
            }
        } 
        else {
            if (!$numContrat) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Aucun contrat spécifié pour la modification.'
                ];
                header('Location: ?controller=contrat&action=index');
                exit;
            }
        }

        $appartements = $this->getAppartements();
        $locataires = $this->getLocataires();
        
        require_once 'views/contrat/edit.php';
    }

    public function terminate() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $numContrat = $_GET['id'] ?? null;

        if ($numContrat) {
            $this->contrat->numContrat = $numContrat;
            
            if (!$this->contrat->read_single()) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Contrat à résilier non trouvé en base de données.'
                ];
                header('Location: ?controller=contrat&action=index');
                exit;
            }

            if ($this->contrat->exportToXml($numContrat)) {
                if ($this->contrat->delete()) {
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Contrat résilié et archivé avec succès.'
                    ];
                } else {
                    $_SESSION['flash'] = [
                        'type' => 'danger',
                        'message' => 'Contrat archivé, mais erreur lors de la suppression de la base de données.'
                    ];
                }
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Erreur lors de l\'archivage du contrat en XML. Le contrat n\'a pas été supprimé de la base de données.'
                ];
            }
        } else {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Aucun contrat spécifié pour la résiliation.'
            ];
        }
        header('Location: ?controller=contrat&action=index');
        exit;
    }

    public function restore() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $numContrat = $_GET['id'] ?? null;

        if ($numContrat) {
            $contractData = $this->contrat->importFromXml($numContrat);

            if ($contractData) {
                $this->contrat->numContrat = $contractData['numContrat'];
                $this->contrat->etat = 'Actif';
                $this->contrat->dateCreation = $contractData['dateCreation'];
                $this->contrat->dateDebut = $contractData['dateDebut'];
                $this->contrat->dateFin = $contractData['dateFin'];
                $this->contrat->numAppartement = $contractData['numAppartement'];
                $this->contrat->numLocataire = $contractData['numLocataire'];
                
                $appartementExists = $this->checkAppartementExists($this->contrat->numAppartement);
                $locataireExists = $this->checkLocataireExists($this->contrat->numLocataire);

                if (!$appartementExists || !$locataireExists) {
                    $_SESSION['flash'] = [
                        'type' => 'danger',
                        'message' => 'Impossible de rétablir le contrat. L\'appartement ou le locataire associé n\'existe plus.'
                    ];
                    header('Location: ?controller=contrat&action=index');
                    exit;
                }

                if ($this->contrat->create()) {
                    if ($this->contrat->deleteXmlFile($numContrat)) {
                        $_SESSION['flash'] = [
                            'type' => 'success',
                            'message' => 'Contrat rétabli et fichier XML supprimé avec succès.'
                        ];
                    } else {
                        $_SESSION['flash'] = [
                            'type' => 'warning',
                            'message' => 'Contrat rétabli, mais erreur lors de la suppression du fichier XML. Supprimez-le manuellement si nécessaire.'
                        ];
                    }
                } else {
                    $_SESSION['flash'] = [
                        'type' => 'danger',
                        'message' => 'Erreur lors du rétablissement du contrat en base de données. Le fichier XML est toujours présent.'
                    ];
                }
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Fichier d\'archive XML pour le contrat non trouvé ou corrompu.'
                ];
            }
        } else {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Aucun contrat spécifié pour le rétablissement.'
            ];
        }
        header('Location: ?controller=contrat&action=index');
        exit;
    }

    public function print() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $contrats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'views/contrat/print.php';
    }
    
    private function checkAppartementExists($numAppartement) {
        $query = "SELECT COUNT(*) FROM appartement WHERE numLocation = :numAppartement";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':numAppartement', $numAppartement);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    private function checkLocataireExists($numLocataire) {
        $query = "SELECT COUNT(*) FROM locataire WHERE numLocataire = :numLocataire";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':numLocataire', $numLocataire);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    private function getAppartements() {
        $query = "SELECT numLocation, categorie, type, adresseLocation FROM appartement ORDER BY adresseLocation ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    private function getLocataires() {
        $query = "SELECT numLocataire, nomLocataire, prenomLocataire FROM locataire ORDER BY nomLocataire ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
