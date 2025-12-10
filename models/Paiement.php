<?php
require_once __DIR__ . '/../config/database.php';

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

    // Effectuer un paiement en ligne (Diagram method)
    public function effectuerPaiementEnLigne($paiement_data) {
        // Simuler le traitement du paiement en ligne
        $query = "INSERT INTO " . $this->table . "
                  (id_membre, montant, date, methode_paiement, statut, description)
                  VALUES (?, ?, NOW(), ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        $result = $stmt->execute([
            $paiement_data['id_membre'] ?? $this->id_membre,
            $paiement_data['montant'] ?? $this->montant,
            $paiement_data['methode'] ?? 'carte_bancaire',
            'en attente',
            $paiement_data['description'] ?? ''
        ]);
        
        if ($result) {
            $id_paiement = $this->conn->lastInsertId();
            
            // Simuler la validation du paiement en ligne
            // En production, cela appellerait une API de passerelle de paiement
            $this->validerPaiement($id_paiement);
            
            return true;
        }
        
        return false;
    }

    // Générer un reçu (Diagram method)
    public function genererRecu($id_paiement = null) {
        $id = $id_paiement ?? $this->id_paiement;
        
        $query = "SELECT p.*, m.nom, m.prenom, m.email
                  FROM " . $this->table . " p
                  INNER JOIN membre m ON p.id_membre = m.id_membre
                  WHERE p.id_paiement = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $paiement = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$paiement) {
            return false;
        }
        
        // Générer un numéro de reçu unique
        $numero_recu = 'REC-' . $id . '-' . date('YmdHis');
        
        // Créer un enregistrement de reçu
        $query_recu = "INSERT INTO recus (id_paiement, numero_recu, date_emission, statut)
                      VALUES (?, ?, NOW(), 'émis')";
        
        $stmt_recu = $this->conn->prepare($query_recu);
        
        if ($stmt_recu->execute([$id, $numero_recu])) {
            return [
                'numero_recu' => $numero_recu,
                'paiement' => $paiement,
                'date_emission' => date('Y-m-d H:i:s')
            ];
        }
        
        return false;
    }

    // Valider un paiement (méthode interne)
    private function validerPaiement($id_paiement) {
        $query = "UPDATE " . $this->table . "
                  SET statut = 'confirmé'
                  WHERE id_paiement = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id_paiement]);
    }
}
?>

