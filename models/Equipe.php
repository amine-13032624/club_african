<?php
require_once 'config/database.php';

class Equipe {
    private $conn;
    private $table = 'equipe';

    public $id_equipe;
    public $nom;
    public $sport;
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
                  (nom, sport, id_entraineur_principal, nombre_joueurs, couleur_principale, couleur_secondaire, date_creation)
                  VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->sport,
            $this->id_entraineur_principal,
            $this->nombre_joueurs,
            $this->couleur_principale,
            $this->couleur_secondaire
        ]);
    }

    // Modifier une équipe
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET nom = ?, sport = ?, id_entraineur_principal = ?, nombre_joueurs = ?, 
                      couleur_principale = ?, couleur_secondaire = ?
                  WHERE id_equipe = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->nom,
            $this->sport,
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
}
?>
