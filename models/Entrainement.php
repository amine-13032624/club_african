<?php
require_once 'config/database.php';

class Entrainement {
    private $conn;
    private $table = 'entrainement';

    public $id_entrainement;
    public $id_entraineur;
    public $id_equipe;
    public $titre;
    public $description;
    public $date_entrainement;
    public $heure_debut;
    public $heure_fin;
    public $lieu;
    public $type;
    public $niveau;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les entraînements
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date_entrainement DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un entraînement par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_entrainement = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les entraînements de la semaine
    public function getEntrainementsSemaine() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE WEEK(date_entrainement) = WEEK(NOW()) 
                  AND YEAR(date_entrainement) = YEAR(NOW())
                  ORDER BY date_entrainement, heure_debut";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les entraînements d'un entraîneur
    public function getByEntraineur($id_entraineur) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_entraineur = ? ORDER BY date_entrainement DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_entraineur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un entraînement
    public function ajouter() {
        $query = "INSERT INTO " . $this->table . "
                  (id_entraineur, id_equipe, titre, description, date_entrainement, heure_debut, heure_fin, lieu, type, niveau)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_entraineur,
            $this->id_equipe,
            $this->titre,
            $this->description,
            $this->date_entrainement,
            $this->heure_debut,
            $this->heure_fin,
            $this->lieu,
            $this->type,
            $this->niveau
        ]);
    }

    // Modifier un entraînement
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET id_entraineur = ?, id_equipe = ?, titre = ?, description = ?, 
                      date_entrainement = ?, heure_debut = ?, heure_fin = ?, lieu = ?, type = ?, niveau = ?
                  WHERE id_entrainement = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_entraineur,
            $this->id_equipe,
            $this->titre,
            $this->description,
            $this->date_entrainement,
            $this->heure_debut,
            $this->heure_fin,
            $this->lieu,
            $this->type,
            $this->niveau,
            $this->id_entrainement
        ]);
    }

    // Supprimer un entraînement
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_entrainement = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Obtenir le nombre d'entraînements
    public function getCount() {
        $query = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>
