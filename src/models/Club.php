<?php
require_once __DIR__ . '/../config/database.php';

class Club {
    private $conn;
    private $table = 'club';

    public $id_club;
    public $nom;
    public $adresse;
    public $telephone;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les clubs
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un club par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_club = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un club
    public function ajouter() {
        $query = "INSERT INTO " . $this->table . "
                  (nom, adresse, telephone, email)
                  VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->adresse,
            $this->telephone,
            $this->email
        ]);
    }

    // Modifier un club
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET nom = ?, adresse = ?, telephone = ?, email = ?
                  WHERE id_club = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->adresse,
            $this->telephone,
            $this->email,
            $this->id_club
        ]);
    }

    // Supprimer un club
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_club = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Obtenir les informations du club principal
    public function getClubInfo() {
        $query = "SELECT * FROM " . $this->table . " LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Générer le tableau de bord (Diagram method)
    public function genererTableauDeBord($id_club = null) {
        $id = $id_club ?? $this->id_club;
        
        return [
            'club_info' => $this->getClubInfo(),
            'total_membres' => $this->getTotalMembres(),
            'total_athletes' => $this->getTotalAthletes(),
            'total_entraineurs' => $this->getTotalEntraineurs(),
            'total_equipes' => $this->getTotalEquipes(),
            'total_competitions' => $this->getTotalCompetitions(),
            'revenus_total' => $this->getRevenusTotal(),
            'depenses_total' => $this->getDepensesTotal(),
            'balance' => $this->getRevenusTotal() - $this->getDepensesTotal(),
            'membres_actifs' => $this->getMembresActifs(),
            'competitions_a_venir' => $this->getCompetitionsAVenir(),
            'entrainements_semaine' => $this->getEntrainementsSemaineCount()
        ];
    }

    // Consulter les statistiques (Diagram method)
    public function consulterStatistiques() {
        return [
            'statistiques_membres' => $this->getStatistiquesMembers(),
            'statistiques_competitions' => $this->getStatistiquesCompetitions(),
            'statistiques_performances' => $this->getStatistiquesPerformances(),
            'statistiques_equipes' => $this->getStatistiquesEquipes()
        ];
    }

    // Suivre dépenses et revenus (Diagram method)
    public function suivreDepensesRevenus() {
        return [
            'total_revenus' => $this->getRevenusTotal(),
            'total_depenses' => $this->getDepensesTotal(),
            'balance_nette' => $this->getRevenusTotal() - $this->getDepensesTotal(),
            'revenus_par_type' => $this->getRevenusParType(),
            'depenses_par_type' => $this->getDepensesParType()
        ];
    }

    // Méthodes helper pour le tableau de bord
    private function getTotalMembres() {
        $query = "SELECT COUNT(*) as count FROM membre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    private function getTotalAthletes() {
        $query = "SELECT COUNT(*) as count FROM athlete";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    private function getTotalEntraineurs() {
        $query = "SELECT COUNT(*) as count FROM entraineur";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    private function getTotalEquipes() {
        $query = "SELECT COUNT(*) as count FROM equipe";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    private function getTotalCompetitions() {
        $query = "SELECT COUNT(*) as count FROM competition";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    private function getRevenusTotal() {
        $query = "SELECT COALESCE(SUM(montant), 0) as total FROM paiement WHERE statut = 'confirmé'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    private function getDepensesTotal() {
        $query = "SELECT COALESCE(SUM(montant), 0) as total FROM depenses WHERE statut = 'validée'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    private function getMembresActifs() {
        $query = "SELECT m.id_membre, m.nom, m.prenom, m.email, m.type_membre
                  FROM membre m
                  ORDER BY m.id_membre DESC
                  LIMIT 10";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getCompetitionsAVenir() {
        $query = "SELECT * FROM competition 
                  WHERE date_competition >= NOW()
                  ORDER BY date_competition
                  LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getEntrainementsSemaineCount() {
        $query = "SELECT COUNT(*) as count FROM entrainement 
                  WHERE WEEK(date_entrainement) = WEEK(NOW()) 
                  AND YEAR(date_entrainement) = YEAR(NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    private function getStatistiquesMembers() {
        $query = "SELECT type_membre, COUNT(*) as count 
                  FROM membre 
                  GROUP BY type_membre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getStatistiquesCompetitions() {
        $query = "SELECT type, COUNT(*) as count 
                  FROM competition 
                  GROUP BY type";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getStatistiquesPerformances() {
        $query = "SELECT 
                    COUNT(*) as total_performances,
                    AVG(valeur) as moyenne,
                    MAX(valeur) as meilleure,
                    MIN(valeur) as pire
                  FROM performance";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getStatistiquesEquipes() {
        $query = "SELECT nombre_joueurs, COUNT(*) as count 
                  FROM equipe 
                  GROUP BY nombre_joueurs
                  ORDER BY nombre_joueurs";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getRevenusParType() {
        $query = "SELECT methode_paiement, SUM(montant) as total 
                  FROM paiement 
                  WHERE statut = 'confirmé'
                  GROUP BY methode_paiement";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getDepensesParType() {
        $query = "SELECT type_depense, SUM(montant) as total 
                  FROM depenses 
                  WHERE statut = 'validée'
                  GROUP BY type_depense";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
