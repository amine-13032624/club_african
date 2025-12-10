<?php
require_once 'Membre.php';

class Entraineur extends Membre {
    private $specialite;
    private $diplome;
    private $annees_experience;
    private $id_equipe;

    public function __construct($db) {
        parent::__construct($db);
        $this->table_name = "entraineur";
    }

    // Setters et Getters
    public function setSpecialite($specialite) { $this->specialite = $specialite; }
    public function getSpecialite() { return $this->specialite; }
    
    public function setDiplome($diplome) { $this->diplome = $diplome; }
    public function getDiplome() { return $this->diplome; }
    
    public function setAnneeExperience($annees) { $this->annees_experience = $annees; }
    public function getAnneeExperience() { return $this->annees_experience; }
    
    public function setIdEquipe($id) { $this->id_equipe = $id; }
    public function getIdEquipe() { return $this->id_equipe; }

    // Inscrire un entraîneur
    public function inscrire() {
        $query = "INSERT INTO membre (nom, prenom, email, telephone, dateNaissance, categorie, niveau, type_membre) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 'entraineur')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            $this->nom, $this->prenom, $this->email, $this->telephone,
            $this->dateNaissance, $this->categorie, $this->niveau
        ]);

        $id_membre = $this->conn->lastInsertId();
        
        $query2 = "INSERT INTO entraineur (id_membre, specialite, diplome, annees_experience)
                   VALUES (?, ?, ?, ?)";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->execute([$id_membre, $this->specialite, $this->diplome, $this->annees_experience]);
        
        return $id_membre;
    }

    // Modifier le profil d'un entraîneur
    public function modifierProfil($id, $data) {
        $query = "UPDATE entraineur
                  SET specialite = ?, diplome = ?, annees_experience = ?
                  WHERE id_entraineur = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $data['specialite'] ?? $this->specialite,
            $data['diplome'] ?? $this->diplome,
            $data['annees_experience'] ?? $this->annees_experience,
            $id
        ]);
    }

    // Récupérer les entraînements dirigés
    public function getEntrainements($id) {
        $query = "SELECT * FROM entrainement WHERE id_entraineur = ? ORDER BY date_entrainement DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les athlètes de l'équipe
    public function getAthletes($id_equipe) {
        $query = "SELECT m.*, a.numeroLicence, a.position 
                  FROM athlete a
                  INNER JOIN membre m ON a.id_membre = m.id_membre
                  WHERE a.id_equipe = ?
                  ORDER BY m.nom, m.prenom";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_equipe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Planifier un entraînement (Diagram method)
    public function planifierEntrainement($data) {
        $query = "INSERT INTO entrainement (id_entraineur, id_equipe, titre, description, date_entrainement, heure_debut, heure_fin, lieu, type, niveau)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_membre,
            $data['id_equipe'] ?? $this->id_equipe,
            $data['titre'] ?? '',
            $data['description'] ?? '',
            $data['date'] ?? date('Y-m-d'),
            $data['heure_debut'] ?? '',
            $data['heure_fin'] ?? '',
            $data['lieu'] ?? '',
            $data['type'] ?? 'standard',
            $data['niveau'] ?? $this->niveau
        ]);
    }

    // Évaluer un athlète (Diagram method)
    public function evaluerAthlete($id_athlete, $evaluation_data) {
        $query = "INSERT INTO performance (id_athlete, id_entraineur, date_performance, type, valeur, commentaire)
                  VALUES (?, ?, NOW(), ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $id_athlete,
            $this->id_membre,
            $evaluation_data['type'] ?? 'evaluation',
            $evaluation_data['valeur'] ?? 0,
            $evaluation_data['commentaire'] ?? ''
        ]);
    }
}
?>
