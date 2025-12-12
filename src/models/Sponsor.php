<?php
require_once __DIR__ . '/../config/database.php';

class Sponsor {
    private $conn;
    private $table = 'sponsor';

    public $id_sponsor;
    public $nom;
    public $secteur;
    public $montant_contribution;
    public $date_debut;
    public $date_fin;
    public $contact;
    public $telephone;
    public $email;
    public $statut;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les sponsors
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nom";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un sponsor par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_sponsor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un sponsor
    public function ajouter() {
        $query = "INSERT INTO " . $this->table . "
                  (nom, secteur, montant_contribution, date_debut, date_fin, contact, telephone, email, statut)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->secteur,
            $this->montant_contribution,
            $this->date_debut,
            $this->date_fin,
            $this->contact,
            $this->telephone,
            $this->email,
            $this->statut
        ]);
    }

    // Modifier un sponsor
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET nom = ?, secteur = ?, montant_contribution = ?, date_debut = ?, 
                      date_fin = ?, contact = ?, telephone = ?, email = ?, statut = ?
                  WHERE id_sponsor = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->secteur,
            $this->montant_contribution,
            $this->date_debut,
            $this->date_fin,
            $this->contact,
            $this->telephone,
            $this->email,
            $this->statut,
            $this->id_sponsor
        ]);
    }

    // Supprimer un sponsor
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_sponsor = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Obtenir les sponsors actifs
    public function getSponsorsActifs() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE statut = 'actif' AND date_fin >= NOW()
                  ORDER BY montant_contribution DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
