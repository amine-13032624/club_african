<?php
require_once 'config/database.php';

class Paiement {
    private $conn;
    private $table = 'paiement';

    public $id_paiement;
    public $id_membre;
    public $montant;
    public $date_paiement;
    public $methode_paiement;
    public $statut;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les paiements
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un paiement par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_paiement = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les paiements d'un membre
    public function getByMembre($id_membre) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_membre = ? ORDER BY date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_membre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un paiement
    public function ajouter() {
        $query = "INSERT INTO " . $this->table . "
                  (id_membre, montant, date, methode_paiement, statut, description)
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_membre,
            $this->montant,
            $this->date_paiement,
            $this->methode_paiement,
            $this->statut,
            $this->description
        ]);
    }

    // Modifier un paiement
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET montant = ?, date = ?, methode_paiement = ?, statut = ?, description = ?
                  WHERE id_paiement = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->montant,
            $this->date_paiement,
            $this->methode_paiement,
            $this->statut,
            $this->description,
            $this->id_paiement
        ]);
    }

    // Supprimer un paiement
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_paiement = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Obtenir les paiements en attente
    public function getPaiementsAttente() {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE statut = 'en attente'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    // Obtenir le total des paiements
    public function getTotalPaiements() {
        $query = "SELECT SUM(montant) as total FROM " . $this->table . " WHERE statut = 'confirmé'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
?>
