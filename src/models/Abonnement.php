<?php
require_once __DIR__ . '/../config/database.php';

class Abonnement {
    private $conn;
    private $table = 'abonnement';

    public $id_abonnement;
    public $id_membre;
    public $type;
    public $prix;
    public $date_debut;
    public $date_fin;
    public $statut;
    public $nombre_seances;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les abonnements
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date_debut DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un abonnement par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_abonnement = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les abonnements d'un membre
    public function getByMembre($id_membre) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_membre = ? ORDER BY date_debut DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_membre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un abonnement
    public function ajouter() {
        $query = "INSERT INTO " . $this->table . "
                  (id_membre, type, prix, date_debut, date_fin, statut, nombre_seances)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_membre,
            $this->type,
            $this->prix,
            $this->date_debut,
            $this->date_fin,
            $this->statut,
            $this->nombre_seances
        ]);
    }

    // Modifier un abonnement
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET type = ?, prix = ?, date_debut = ?, date_fin = ?, statut = ?, nombre_seances = ?
                  WHERE id_abonnement = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->type,
            $this->prix,
            $this->date_debut,
            $this->date_fin,
            $this->statut,
            $this->nombre_seances,
            $this->id_abonnement
        ]);
    }

    // Supprimer un abonnement
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_abonnement = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Obtenir les abonnements actifs
    public function getAbonnementsActifs() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE statut = 'actif' AND date_fin >= NOW()
                  ORDER BY date_fin";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Renouveler un abonnement (Diagram method)
    public function renouveler($id_abonnement, $nombre_mois = 1) {
        $query = "UPDATE " . $this->table . "
                  SET date_fin = DATE_ADD(date_fin, INTERVAL ? MONTH),
                      statut = 'actif'
                  WHERE id_abonnement = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nombre_mois, $id_abonnement]);
    }

    // Vérifier la validité d'un abonnement (Diagram method)
    public function verifierValidite($id_abonnement = null) {
        $id = $id_abonnement ?? $this->id_abonnement;
        
        $query = "SELECT * FROM " . $this->table . " WHERE id_abonnement = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $abonnement = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$abonnement) {
            return false;
        }
        
        // Vérifie si la date de fin est dans le futur et statut est actif
        $is_valid = ($abonnement['statut'] === 'actif' && strtotime($abonnement['date_fin']) > time());
        
        // Mise à jour du statut si nécessaire
        if (!$is_valid && $abonnement['statut'] === 'actif') {
            $query_update = "UPDATE " . $this->table . " SET statut = 'expire' WHERE id_abonnement = ?";
            $stmt_update = $this->conn->prepare($query_update);
            $stmt_update->execute([$id]);
        }
        
        return $is_valid;
    }
}
?>
