<?php
require_once 'Membre.php';

class Athelete extends Membre {
    private $numeroLicence;
    private $id_equipe;
    private $date_debut_participation;
    private $taille;
    private $poids;
    private $position;

    public function __construct($db) {
        parent::__construct($db);
        $this->table_name = "athlete";
    }

    // Setter et Getter
    public function setNumeroLicence($numero) { $this->numeroLicence = $numero; }
    public function getNumeroLicence() { return $this->numeroLicence; }
    
    public function setIdEquipe($id) { $this->id_equipe = $id; }
    public function getIdEquipe() { return $this->id_equipe; }
    
    public function setPosition($position) { $this->position = $position; }
    public function getPosition() { return $this->position; }

    public function setTaille($taille) { $this->taille = $taille; }
    public function getTaille() { return $this->taille; }

    public function setPoids($poids) { $this->poids = $poids; }
    public function getPoids() { return $this->poids; }

    // Inscrire un athlète
    public function inscrire() {
        $query = "INSERT INTO Membre (nom, prenom, email, telephone, dateNaissance, categorie, niveau, type_membre) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 'athlete')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            $this->nom, $this->prenom, $this->email, $this->telephone,
            $this->dateNaissance, $this->categorie, $this->niveau
        ]);

        $id_membre = $this->conn->lastInsertId();
        
        $query2 = "INSERT INTO athlete (id_membre, numeroLicence, taille, poids, position, date_debut_participation)
                   VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->execute([$id_membre, $this->numeroLicence, $this->taille, $this->poids, $this->position]);
        
        return $id_membre;
    }

    // Modifier le profil d'un athlète
    public function modifierProfil($id, $data) {
        $query = "UPDATE athlete
                  SET taille = ?, poids = ?, position = ?
                  WHERE id_athlete = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $data['taille'] ?? $this->taille,
            $data['poids'] ?? $this->poids,
            $data['position'] ?? $this->position,
            $id
        ]);
    }

    // Récupérer les performances de l'athlète
    public function consulterPerformances() {
        $query = "SELECT * FROM performance WHERE id_athlete = ? ORDER BY date_performance DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->id_membre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les statistiques
    public function consulterStatistiques($id) {
        $query = "SELECT * FROM performance WHERE id_athlete = ? ORDER BY date_performance DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer toutes les participations aux compétitions
    public function getParticipations($id) {
        $query = "SELECT c.* FROM competition c 
                  INNER JOIN participation p ON c.id_competition = p.id_competition
                  WHERE p.id_athlete = ?
                  ORDER BY c.date_competition DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>