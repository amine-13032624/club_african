<?php
require_once __DIR__ . '/../config/database.php';

class Competition {
    private $conn;
    private $table = 'competition';

    public $id_competition;
    public $nom;
    public $date_competition;
    public $lieu;
    public $type;
    public $niveau;
    public $id_equipe;
    public $resultat;
    public $nombre_participants;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer toutes les compétitions
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date_competition DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une compétition par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_competition = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les compétitions d'une équipe
    public function getByEquipe($id_equipe) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_equipe = ? ORDER BY date_competition DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_equipe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une compétition
    public function ajouter() {
        $query = "INSERT INTO " . $this->table . "
                  (nom, date_competition, lieu, type, niveau, id_equipe, nombre_participants)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->date_competition,
            $this->lieu,
            $this->type,
            $this->niveau,
            $this->id_equipe,
            $this->nombre_participants
        ]);
    }

    // Modifier une compétition
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET nom = ?, date_competition = ?, lieu = ?, type = ?, 
                      niveau = ?, id_equipe = ?, resultat = ?, nombre_participants = ?
                  WHERE id_competition = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->date_competition,
            $this->lieu,
            $this->type,
            $this->niveau,
            $this->id_equipe,
            $this->resultat,
            $this->nombre_participants,
            $this->id_competition
        ]);
    }

    // Supprimer une compétition
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_competition = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Obtenir les compétitions à venir
    public function getComingCompetitions() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE date_competition >= NOW()
                  ORDER BY date_competition";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Organiser un tournoi (Diagram method)
    public function organiserTournoi($tournoi_data) {
        $query = "INSERT INTO " . $this->table . "
                  (nom, date_competition, lieu, type, niveau, nombre_participants)
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $tournoi_data['nom'] ?? '',
            $tournoi_data['date'] ?? date('Y-m-d'),
            $tournoi_data['lieu'] ?? '',
            $tournoi_data['type'] ?? 'tournoi',
            $tournoi_data['niveau'] ?? 'amateur',
            $tournoi_data['nombre_participants'] ?? 0
        ]);
    }

    // Inscrire un participant (Diagram method)
    public function inscrireParticipant($id_competition, $id_athlete) {
        $query = "INSERT INTO participation (id_competition, id_athlete, date_inscription, statut)
                  VALUES (?, ?, NOW(), 'inscrit')
                  ON DUPLICATE KEY UPDATE statut = 'inscrit'";
        
        $stmt = $this->conn->prepare($query);
        
        if ($stmt->execute([$id_competition, $id_athlete])) {
            // Mettre à jour le nombre de participants
            return $this->updateNombreParticipants($id_competition);
        }
        
        return false;
    }

    // Mettre à jour le nombre de participants
    private function updateNombreParticipants($id_competition) {
        $query = "UPDATE " . $this->table . " c
                  SET nombre_participants = (SELECT COUNT(*) FROM participation WHERE id_competition = c.id_competition)
                  WHERE id_competition = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id_competition]);
    }

    // Récupérer les participants d'une compétition
    public function getParticipants($id_competition) {
        $query = "SELECT p.*, m.nom, m.prenom, a.numeroLicence
                  FROM participation p
                  INNER JOIN athlete a ON p.id_athlete = a.id_athlete
                  INNER JOIN membre m ON a.id_membre = m.id_membre
                  WHERE p.id_competition = ?
                  ORDER BY m.nom, m.prenom";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_competition]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

