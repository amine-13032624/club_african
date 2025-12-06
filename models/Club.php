<?php
require_once 'config/database.php';

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
}
?>
