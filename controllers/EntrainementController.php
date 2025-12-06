<?php
require_once 'config/database.php';
require_once 'models/Entrainement.php';
require_once 'models/Equipe.php';

class EntrainementController {
    private $db;
    private $entrainement;
    private $equipe;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->entrainement = new Entrainement($this->db);
        $this->equipe = new Equipe($this->db);
    }

    // Ajouter un entraînement
    public function ajouter($data) {
        $this->entrainement->id_entraineur = $data['id_entraineur'];
        $this->entrainement->id_equipe = $data['id_equipe'];
        $this->entrainement->titre = $data['titre'];
        $this->entrainement->description = $data['description'] ?? null;
        $this->entrainement->date_entrainement = $data['date_entrainement'];
        $this->entrainement->heure_debut = $data['heure_debut'];
        $this->entrainement->heure_fin = $data['heure_fin'];
        $this->entrainement->lieu = $data['lieu'];
        $this->entrainement->type = $data['type'];
        $this->entrainement->niveau = $data['niveau'];

        return $this->entrainement->ajouter();
    }

    // Modifier un entraînement
    public function modifier($id, $data) {
        $this->entrainement->id_entrainement = $id;
        $this->entrainement->id_entraineur = $data['id_entraineur'];
        $this->entrainement->id_equipe = $data['id_equipe'];
        $this->entrainement->titre = $data['titre'];
        $this->entrainement->description = $data['description'] ?? null;
        $this->entrainement->date_entrainement = $data['date_entrainement'];
        $this->entrainement->heure_debut = $data['heure_debut'];
        $this->entrainement->heure_fin = $data['heure_fin'];
        $this->entrainement->lieu = $data['lieu'];
        $this->entrainement->type = $data['type'];
        $this->entrainement->niveau = $data['niveau'];

        return $this->entrainement->modifier();
    }

    // Supprimer un entraînement
    public function supprimer($id) {
        return $this->entrainement->supprimer($id);
    }

    // Récupérer tous les entraînements
    public function getAll() {
        return $this->entrainement->getAll();
    }

    // Récupérer un entraînement par ID
    public function getById($id) {
        return $this->entrainement->getById($id);
    }

    // Récupérer les entraînements de la semaine
    public function getEntrainementsSemaine() {
        return $this->entrainement->getEntrainementsSemaine();
    }

    // Récupérer les entraînements d'un entraîneur
    public function getByEntraineur($id_entraineur) {
        return $this->entrainement->getByEntraineur($id_entraineur);
    }

    // Récupérer les entraînements d'une équipe
    public function getByEquipe($id_equipe) {
        $query = "SELECT * FROM entrainement WHERE id_equipe = ? ORDER BY date_entrainement DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_equipe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les entraînements d'une date
    public function getByDate($date) {
        $query = "SELECT * FROM entrainement WHERE DATE(date_entrainement) = ? ORDER BY heure_debut";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer le planning du mois
    public function getPlanning($mois, $annee) {
        $query = "SELECT * FROM entrainement 
                  WHERE MONTH(date_entrainement) = ? 
                  AND YEAR(date_entrainement) = ?
                  ORDER BY date_entrainement, heure_debut";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$mois, $annee]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer toutes les équipes
    public function getToutesEquipes() {
        return $this->equipe->getAll();
    }

    // Récupérer tous les entraîneurs
    public function getTousEntraineurs() {
        $query = "SELECT m.*, en.specialite 
                  FROM entraineur en
                  INNER JOIN membre m ON en.id_membre = m.id_membre
                  ORDER BY m.nom, m.prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une équipe
    public function ajouterEquipe($data) {
        $this->equipe->nom = $data['nom'];
        $this->equipe->sport = $data['sport'];
        $this->equipe->id_entraineur_principal = $data['id_entraineur_principal'];
        $this->equipe->nombre_joueurs = $data['nombre_joueurs'];
        $this->equipe->couleur_principale = $data['couleur_principale'];
        $this->equipe->couleur_secondaire = $data['couleur_secondaire'];

        return $this->equipe->ajouter();
    }

    // Obtenir le nombre total d'entraînements
    public function getCountEntrainements() {
        return $this->entrainement->getCount();
    }
}
?>
