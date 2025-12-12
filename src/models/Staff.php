<?php
require_once __DIR__ . '/Membre.php';

class Staff extends Membre {
    private $fonction;
    private $departement;
    private $date_embauche;

    public function __construct($db) {
        parent::__construct($db);
        $this->table_name = "staff";
    }

    // Setters et Getters
    public function setFonction($fonction) { $this->fonction = $fonction; }
    public function getFonction() { return $this->fonction; }
    
    public function setDepartement($departement) { $this->departement = $departement; }
    public function getDepartement() { return $this->departement; }
    
    public function setDateEmbauche($date) { $this->date_embauche = $date; }
    public function getDateEmbauche() { return $this->date_embauche; }

    // Inscrire un staff
    public function inscrire() {
        $query = "INSERT INTO membre (nom, prenom, email, telephone, dateNaissance, categorie, niveau, type_membre) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 'staff')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            $this->nom, $this->prenom, $this->email, $this->telephone,
            $this->dateNaissance, $this->categorie, $this->niveau
        ]);

        $id_membre = $this->conn->lastInsertId();
        
        $query2 = "INSERT INTO staff (id_membre, fonction, departement, date_embauche)
                   VALUES (?, ?, ?, NOW())";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->execute([$id_membre, $this->fonction, $this->departement]);
        
        return $id_membre;
    }

    // Modifier le profil du staff
    public function modifierProfil($id, $data) {
        $query = "UPDATE " . $this->table_name . "
                  SET fonction = ?, departement = ?
                  WHERE id_staff = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $data['fonction'] ?? $this->fonction,
            $data['departement'] ?? $this->departement,
            $id
        ]);
    }

    // Récupérer les informations du staff
    public function getInfoStaff($id) {
        $query = "SELECT m.*, s.fonction, s.departement, s.date_embauche
                  FROM staff s
                  INNER JOIN membre m ON s.id_membre = m.id_membre
                  WHERE s.id_staff = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Générer un rapport (Diagram method)
    public function genererRapport($rapport_data) {
        $query = "INSERT INTO rapports (id_staff, titre, description, date_creation, contenu)
                  VALUES (?, ?, ?, NOW(), ?)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id_membre,
            $rapport_data['titre'] ?? '',
            $rapport_data['description'] ?? '',
            $rapport_data['contenu'] ?? ''
        ]);
    }

    // Récupérer tous les rapports générés par ce staff
    public function getRapports() {
        $query = "SELECT * FROM rapports 
                  WHERE id_staff = ? 
                  ORDER BY date_creation DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->id_membre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
