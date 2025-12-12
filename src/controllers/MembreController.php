<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Athlete.php';
require_once __DIR__ . '/../models/Entraineur.php';
require_once __DIR__ . '/../models/Staff.php';

class MembreController {
    private $db;
    private $athlete;
    private $entraineur;
    private $staff;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->athlete = new Athlete($this->db);
        $this->entraineur = new Entraineur($this->db);
        $this->staff = new Staff($this->db);
    }

    // Ajouter un athlète
    public function ajouterAthlete($data) {
        $this->athlete->setNom($data['nom']);
        $this->athlete->setPrenom($data['prenom']);
        $this->athlete->setEmail($data['email']);
        $this->athlete->setTelephone($data['telephone']);
        $this->athlete->setDateNaissance($data['dateNaissance']);
        $this->athlete->setCategorie($data['categorie']);
        $this->athlete->setNiveau($data['niveau']);
        $this->athlete->setNumeroLicence($data['numeroLicence']);
        $this->athlete->setIdEquipe($data['id_equipe'] ?? null);
        $this->athlete->setTaille($data['taille'] ?? null);
        $this->athlete->setPoids($data['poids'] ?? null);
        $this->athlete->setPosition($data['position'] ?? null);

        return $this->athlete->inscrire();
    }

    // Ajouter un entraîneur
    public function ajouterEntraineur($data) {
        $this->entraineur->setNom($data['nom']);
        $this->entraineur->setPrenom($data['prenom']);
        $this->entraineur->setEmail($data['email']);
        $this->entraineur->setTelephone($data['telephone']);
        $this->entraineur->setDateNaissance($data['dateNaissance']);
        $this->entraineur->setCategorie($data['categorie']);
        $this->entraineur->setNiveau($data['niveau']);
        $this->entraineur->setSpecialite($data['specialite']);
        $this->entraineur->setDiplome($data['diplome']);
        $this->entraineur->setAnneeExperience($data['annees_experience']);
        $this->entraineur->setIdEquipe($data['id_equipe'] ?? null);

        return $this->entraineur->inscrire();
    }

    // Ajouter un staff
    public function ajouterStaff($data) {
        $this->staff->setNom($data['nom']);
        $this->staff->setPrenom($data['prenom']);
        $this->staff->setEmail($data['email']);
        $this->staff->setTelephone($data['telephone']);
        $this->staff->setDateNaissance($data['dateNaissance']);
        $this->staff->setCategorie($data['categorie']);
        $this->staff->setNiveau($data['niveau']);
        $this->staff->setFonction($data['fonction']);
        $this->staff->setDepartement($data['departement']);

        return $this->staff->inscrire();
    }

    // Récupérer tous les membres
    public function getTousMembres() {
        if (!$this->db) { return []; }
        $query = "SELECT * FROM membre ORDER BY nom, prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un membre par ID
    public function getMembreById($id) {
        if (!$this->db) { return null; }
        $query = "SELECT * FROM membre WHERE id_membre = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les athlètes
    public function getTousAthletes() {
        if (!$this->db) { return []; }
        $query = "SELECT m.*, a.numeroLicence, a.position, e.nom as nom_equipe
                  FROM athlete a
                  INNER JOIN membre m ON a.id_membre = m.id_membre
                  LEFT JOIN equipe e ON a.id_equipe = e.id_equipe
                  ORDER BY m.nom, m.prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les entraîneurs
    public function getTousEntraineurs() {
        if (!$this->db) { return []; }
        $query = "SELECT m.*, en.specialite, en.diplome, e.nom as nom_equipe
                  FROM entraineur en
                  INNER JOIN membre m ON en.id_membre = m.id_membre
                  LEFT JOIN equipe e ON en.id_equipe = e.id_equipe
                  ORDER BY m.nom, m.prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les staff
    public function getTousStaff() {
        if (!$this->db) { return []; }
        $query = "SELECT m.*, s.fonction, s.departement
                  FROM staff s
                  INNER JOIN membre m ON s.id_membre = m.id_membre
                  ORDER BY m.nom, m.prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lister les membres
    public function listerMembres($type = null) {
        if (!$this->db) { return []; }
        $query = "SELECT * FROM membre";
        if ($type) {
            $query .= " WHERE type_membre = ?";
        }
        
        $stmt = $this->db->prepare($query);
        if ($type) {
            $stmt->execute([$type]);
        } else {
            $stmt->execute();
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Modifier un membre
    public function modifierMembre($id, $data) {
        if (!$this->db) { return false; }
        $query = "UPDATE membre SET 
                  nom = ?,
                  prenom = ?,
                  email = ?,
                  telephone = ?,
                  dateNaissance = ?,
                  categorie = ?,
                  niveau = ?
                  WHERE id_membre = ?";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['dateNaissance'],
            $data['categorie'],
            $data['niveau'],
            $id
        ]);
    }

    // Supprimer un membre
    public function supprimerMembre($id) {
        if (!$this->db) { return false; }
        // D'abord récupérer le type du membre
        $membre = $this->getMembreById($id);
        if (!$membre) {
            return false;
        }

        // Supprimer des tables liées
        $tableLiee = '';
        switch ($membre['type_membre']) {
            case 'athlete':
                $tableLiee = 'athlete';
                break;
            case 'entraineur':
                $tableLiee = 'entraineur';
                break;
            case 'staff':
                $tableLiee = 'staff';
                break;
        }

        if ($tableLiee) {
            $query = "DELETE FROM $tableLiee WHERE id_membre = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        }

        // Supprimer de la table membre
        $query = "DELETE FROM membre WHERE id_membre = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    // Récupérer le profil d'un athlète
    public function getProfilAthlete($id) {
        if (!$this->db) { return null; }
        $query = "SELECT m.*, a.numeroLicence, a.taille, a.poids, a.position, 
                  e.nom as nom_equipe
                  FROM athlete a
                  INNER JOIN membre m ON a.id_membre = m.id_membre
                  LEFT JOIN equipe e ON a.id_equipe = e.id_equipe
                  WHERE a.id_membre = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
