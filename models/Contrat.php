<?php
require_once 'config/database.php';

class Contrat {
    private $conn;
    private $table = 'contrat';

    public $id_contrat;
    public $id_athlete;
    public $id_sponsor;
    public $description;
    public $date_debut;
    public $date_fin;
    public $montant;
    public $statut;
    public $conditions;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les contrats
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date_debut DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un contrat par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_contrat = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un contrat
    public function ajouter() {
        $query = "INSERT INTO " . $this->table . "
                  (id_athlete, id_sponsor, description, date_debut, date_fin, montant, statut, conditions)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_athlete,
            $this->id_sponsor,
            $this->description,
            $this->date_debut,
            $this->date_fin,
            $this->montant,
            $this->statut,
            $this->conditions
        ]);
    }

    // Modifier un contrat
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET id_athlete = ?, id_sponsor = ?, description = ?, date_debut = ?, 
                      date_fin = ?, montant = ?, statut = ?, conditions = ?
                  WHERE id_contrat = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_athlete,
            $this->id_sponsor,
            $this->description,
            $this->date_debut,
            $this->date_fin,
            $this->montant,
            $this->statut,
            $this->conditions,
            $this->id_contrat
        ]);
    }

    // Supprimer un contrat
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_contrat = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Obtenir les contrats actifs
    public function getContratsActifs() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE statut = 'actif' AND date_fin >= NOW()
                  ORDER BY date_fin";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
