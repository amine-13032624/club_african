<?php
require_once __DIR__ . '/../config/database.php';

class Equipe {
    private $conn;
    private $table = 'equipe';

    public $id_equipe;
    public $nom;
    public $sport;
    public $discipline;
    public $id_entraineur_principal;
    public $nombre_joueurs;
    public $couleur_principale;
    public $couleur_secondaire;
    public $date_creation;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer toutes les équipes
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nom";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une équipe par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_equipe = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter une équipe
    public function ajouter() {
        $query = "INSERT INTO " . $this->table . "
                  (nom, sport, discipline, id_entraineur_principal, nombre_joueurs, couleur_principale, couleur_secondaire, date_creation)
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->sport,
            $this->discipline,
            $this->id_entraineur_principal,
            $this->nombre_joueurs,
            $this->couleur_principale,
            $this->couleur_secondaire
        ]);
    }

    // Modifier une équipe
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET nom = ?, sport = ?, discipline = ?, id_entraineur_principal = ?, nombre_joueurs = ?, 
                      couleur_principale = ?, couleur_secondaire = ?
                  WHERE id_equipe = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->sport,
            $this->discipline,
            $this->id_entraineur_principal,
            $this->nombre_joueurs,
            $this->couleur_principale,
            $this->couleur_secondaire,
            $this->id_equipe
        ]);
    }

    // Supprimer une équipe
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_equipe = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Récupérer les athlètes d'une équipe
    public function getAthletes($id) {
        $query = "SELECT m.*, a.numeroLicence, a.position 
                  FROM athlete a
                  INNER JOIN membre m ON a.id_membre = m.id_membre
                  WHERE a.id_equipe = ?
                  ORDER BY m.nom, m.prenom";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Créer une équipe (Diagram method - wrapper for ajouter)
    public function creer() {
        return $this->ajouter();
    }

    // Ajouter un athlète à l'équipe (Diagram method)
    public function ajouterAthlete($id_athlete) {
        $query = "UPDATE athlete SET id_equipe = ? WHERE id_athlete = ?";
        $stmt = $this->conn->prepare($query);
        
        if ($stmt->execute([$this->id_equipe, $id_athlete])) {
            // Mettre à jour le nombre de joueurs
            return $this->updateNombreJoueurs();
        }
        
        return false;
    }

    // Suivre l'équipe - obtenir les statistiques de l'équipe (Diagram method)
    public function suivreEquipe($id_equipe = null) {
        $id = $id_equipe ?? $this->id_equipe;
        
        $query = "SELECT 
                    e.*,
                    COUNT(DISTINCT a.id_athlete) as total_athletes,
                    COUNT(DISTINCT c.id_competition) as competitions_participees,
                    COUNT(DISTINCT p.id_performance) as total_performances
                  FROM equipe e
                  LEFT JOIN athlete a ON e.id_equipe = a.id_equipe
                  LEFT JOIN competition c ON e.id_equipe = c.id_equipe OR (
                      SELECT COUNT(*) FROM participation pr 
                      WHERE pr.id_competition = c.id_competition 
                      AND pr.id_athlete IN (SELECT id_athlete FROM athlete WHERE id_equipe = e.id_equipe)
                  ) > 0
                  LEFT JOIN performance p ON a.id_athlete = p.id_athlete
                  WHERE e.id_equipe = ?
                  GROUP BY e.id_equipe";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour le nombre de joueurs
    private function updateNombreJoueurs() {
        $query = "UPDATE equipe e
                  SET nombre_joueurs = (SELECT COUNT(*) FROM athlete WHERE id_equipe = e.id_equipe)
                  WHERE id_equipe = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->id_equipe]);
    }
}
?>
