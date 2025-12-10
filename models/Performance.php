<?php
require_once __DIR__ . '/../config/database.php';

class Performance {
    private $conn;
    private $table = 'performance';

    public $id_performance;
    public $id_athlete;
    public $id_competition;
    public $type_performance;
    public $valeur;
    public $unite;
    public $date_performance;
    public $commentaire;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer toutes les performances
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date_performance DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une performance par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_performance = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les performances d'un athlète
    public function getByAthlete($id_athlete) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_athlete = ? ORDER BY date_performance DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_athlete]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une performance
    public function ajouter() {
        $query = "INSERT INTO " . $this->table . "
                  (id_athlete, id_competition, type_performance, valeur, unite, date_performance, commentaire)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_athlete,
            $this->id_competition,
            $this->type_performance,
            $this->valeur,
            $this->unite,
            $this->date_performance,
            $this->commentaire
        ]);
    }

    // Modifier une performance
    public function modifier() {
        $query = "UPDATE " . $this->table . "
                  SET id_athlete = ?, id_competition = ?, type_performance = ?, 
                      valeur = ?, unite = ?, date_performance = ?, commentaire = ?
                  WHERE id_performance = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_athlete,
            $this->id_competition,
            $this->type_performance,
            $this->valeur,
            $this->unite,
            $this->date_performance,
            $this->commentaire,
            $this->id_performance
        ]);
    }

    // Supprimer une performance
    public function supprimer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_performance = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Obtenir les meilleures performances
    public function getTopPerformances($limit = 10) {
        $query = "SELECT p.*, m.nom, m.prenom 
                  FROM " . $this->table . " p
                  INNER JOIN athlete a ON p.id_athlete = a.id_athlete
                  INNER JOIN membre m ON a.id_membre = m.id_membre
                  ORDER BY p.valeur DESC
                  LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Enregistrer une performance (Diagram method)
    public function enregistrer($id_athlete, $data) {
        $query = "INSERT INTO " . $this->table . "
                  (id_athlete, id_competition, type_performance, valeur, unite, date_performance, commentaire)
                  VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $id_athlete,
            $data['id_competition'] ?? null,
            $data['type'] ?? 'standard',
            $data['valeur'] ?? 0,
            $data['unite'] ?? '',
            $data['commentaire'] ?? ''
        ]);
    }

    // Analyser les performances (Diagram method)
    public function analyser($id_athlete) {
        $query = "SELECT 
                    COUNT(*) as total_performances,
                    AVG(valeur) as moyenne,
                    MAX(valeur) as meilleure,
                    MIN(valeur) as pire,
                    STDDEV(valeur) as ecart_type,
                    DATE_FORMAT(MAX(date_performance), '%Y-%m-%d') as derniere_date
                  FROM " . $this->table . "
                  WHERE id_athlete = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_athlete]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

