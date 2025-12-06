<?php
require_once 'config/database.php';

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
}
?>
