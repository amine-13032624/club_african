<?php
require_once 'config/database.php';
require_once 'models/Paiement.php';
require_once 'models/Abonnement.php';

class PaiementController {
    private $db;
    private $paiement;
    private $abonnement;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->paiement = new Paiement($this->db);
        $this->abonnement = new Abonnement($this->db);
    }

    // Ajouter un paiement
    public function ajouter($data) {
        $this->paiement->id_membre = $data['id_membre'];
        $this->paiement->montant = $data['montant'];
        $this->paiement->date_paiement = $data['date_paiement'];
        $this->paiement->methode_paiement = $data['methode_paiement'];
        $this->paiement->statut = $data['statut'];
        $this->paiement->description = $data['description'] ?? null;

        return $this->paiement->ajouter();
    }

    // Modifier un paiement
    public function modifier($id, $data) {
        $this->paiement->id_paiement = $id;
        $this->paiement->montant = $data['montant'];
        $this->paiement->date_paiement = $data['date_paiement'];
        $this->paiement->methode_paiement = $data['methode_paiement'];
        $this->paiement->statut = $data['statut'];
        $this->paiement->description = $data['description'] ?? null;

        return $this->paiement->modifier();
    }

    // Supprimer un paiement
    public function supprimer($id) {
        return $this->paiement->supprimer($id);
    }

    // Récupérer tous les paiements
    public function getAll() {
        return $this->paiement->getAll();
    }

    // Récupérer un paiement par ID
    public function getById($id) {
        return $this->paiement->getById($id);
    }

    // Récupérer les paiements d'un membre
    public function getByMembre($id_membre) {
        return $this->paiement->getByMembre($id_membre);
    }

    // Récupérer les paiements en attente
    public function getPaiementsAttente() {
        $query = "SELECT p.*, m.nom, m.prenom, m.email
                  FROM paiement p
                  INNER JOIN membre m ON p.id_membre = m.id_membre
                  WHERE p.statut = 'en attente'
                  ORDER BY p.date_paiement DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les paiements confirmés
    public function getPaiementsConfirmes() {
        $query = "SELECT p.*, m.nom, m.prenom, m.email
                  FROM paiement p
                  INNER JOIN membre m ON p.id_membre = m.id_membre
                  WHERE p.statut = 'confirmé'
                  ORDER BY p.date_paiement DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir les paiements du mois
    public function getPaiementsMois($mois, $annee) {
        $query = "SELECT p.*, m.nom, m.prenom
                  FROM paiement p
                  INNER JOIN membre m ON p.id_membre = m.id_membre
                  WHERE MONTH(p.date_paiement) = ? 
                  AND YEAR(p.date_paiement) = ?
                  ORDER BY p.date_paiement DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$mois, $annee]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir le total des paiements
    public function getTotalPaiements() {
        return $this->paiement->getTotalPaiements();
    }

    // Obtenir le nombre de paiements en attente
    public function getCountPaiementsAttente() {
        return $this->paiement->getPaiementsAttente();
    }

    // Ajouter un abonnement
    public function ajouterAbonnement($data) {
        $this->abonnement->id_membre = $data['id_membre'];
        $this->abonnement->type = $data['type'];
        $this->abonnement->prix = $data['prix'];
        $this->abonnement->date_debut = $data['date_debut'];
        $this->abonnement->date_fin = $data['date_fin'];
        $this->abonnement->statut = $data['statut'];
        $this->abonnement->nombre_seances = $data['nombre_seances'] ?? null;

        return $this->abonnement->ajouter();
    }

    // Modifier un abonnement
    public function modifierAbonnement($id, $data) {
        $this->abonnement->id_abonnement = $id;
        $this->abonnement->type = $data['type'];
        $this->abonnement->prix = $data['prix'];
        $this->abonnement->date_debut = $data['date_debut'];
        $this->abonnement->date_fin = $data['date_fin'];
        $this->abonnement->statut = $data['statut'];
        $this->abonnement->nombre_seances = $data['nombre_seances'] ?? null;

        return $this->abonnement->modifier();
    }

    // Récupérer tous les abonnements
    public function getTousAbonnements() {
        return $this->abonnement->getAll();
    }

    // Récupérer les abonnements actifs
    public function getAbonnementsActifs() {
        return $this->abonnement->getAbonnementsActifs();
    }

    // Récupérer les abonnements d'un membre
    public function getAbonnementsMembre($id_membre) {
        return $this->abonnement->getByMembre($id_membre);
    }

    // Obtenir les statistiques des paiements
    public function getStatistiquessPaiements() {
        $query = "SELECT 
                    COUNT(*) as total_paiements,
                    SUM(CASE WHEN statut = 'confirmé' THEN 1 ELSE 0 END) as paiements_confirmes,
                    SUM(CASE WHEN statut = 'en attente' THEN 1 ELSE 0 END) as paiements_attente,
                    SUM(CASE WHEN statut = 'confirmé' THEN montant ELSE 0 END) as total_montant
                  FROM paiement";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtenir le total des paiements par méthode
    public function getTotalParMethode() {
        $query = "SELECT methode_paiement, 
                         COUNT(*) as nombre,
                         SUM(montant) as total
                  FROM paiement
                  WHERE statut = 'confirmé'
                  GROUP BY methode_paiement";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
