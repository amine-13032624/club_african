<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Membre.php';
require_once __DIR__ . '/../models/Athlete.php';
require_once __DIR__ . '/../models/Entrainement.php';
require_once __DIR__ . '/../models/Paiement.php';
require_once __DIR__ . '/../models/Abonnement.php';

class DashboardController {
    private $db;
    private $membre;
    private $entrainement;
    private $paiement;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->entrainement = new Entrainement($this->db);
        $this->paiement = new Paiement($this->db);
    }

    // Récupérer les statistiques du dashboard
    public function getDashboardStats() {
        return [
            'total_membres' => $this->getTotalMembres(),
            'entrainements_semaine' => $this->getEntrainementsSemaine(),
            'paiements_attente' => $this->getPaiementsAttente(),
            'total_equipes' => $this->getTotalEquipes(),
            'total_competitions' => $this->getTotalCompetitions(),
            'revenus_total' => $this->getRevenusTotal(),
            'membres_recent' => $this->getMembresRecents(),
            'entrainements_semaine_list' => $this->getEntrainementsSeemaineList()
        ];
    }

    // Obtenir le total des membres
    private function getTotalMembres() {
        if (!$this->db) { return 0; }
        $query = "SELECT COUNT(*) as count FROM membre";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    // Obtenir le nombre d'entraînements cette semaine
    private function getEntrainementsSemaine() {
        if (!$this->db) { return 0; }
        $query = "SELECT COUNT(*) as count FROM entrainement 
                   WHERE WEEK(date_entrainement) = WEEK(NOW()) 
                   AND YEAR(date_entrainement) = YEAR(NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    // Obtenir la liste des entraînements de la semaine
    private function getEntrainementsSeemaineList() {
        if (!$this->db) { return []; }
        return $this->entrainement->getEntrainementsSemaine();
    }

    // Obtenir le nombre de paiements en attente
    private function getPaiementsAttente() {
        if (!$this->db) { return 0; }
        return $this->paiement->getPaiementsAttente();
    }

    // Obtenir le total des équipes
    private function getTotalEquipes() {
        if (!$this->db) { return 0; }
        $query = "SELECT COUNT(*) as count FROM equipe";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    // Obtenir le total des compétitions
    private function getTotalCompetitions() {
        if (!$this->db) { return 0; }
        $query = "SELECT COUNT(*) as count FROM competition";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    // Obtenir les revenus totaux
    private function getRevenusTotal() {
        if (!$this->db) { return 0; }
        return $this->paiement->getTotalPaiements();
    }

    // Obtenir les membres récemment inscrits
    private function getMembresRecents() {
        if (!$this->db) { return []; }
        $query = "SELECT id_membre, nom, prenom, email, dateInscription, type_membre 
                  FROM membre 
                  ORDER BY dateInscription DESC 
                  LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir les statistiques par catégorie
    public function getStatistiquesCategories() {
        if (!$this->db) { return []; }
        $query = "SELECT categorie, COUNT(*) as count FROM membre GROUP BY categorie";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir les statistiques par niveau
    public function getStatistiquesNiveaux() {
        if (!$this->db) { return []; }
        $query = "SELECT niveau, COUNT(*) as count FROM membre GROUP BY niveau";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir les compétitions à venir
    public function getComingCompetitions() {
        if (!$this->db) { return []; }
        $query = "SELECT * FROM competition 
                  WHERE date_competition >= NOW()
                  ORDER BY date_competition 
                  LIMIT 10";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
