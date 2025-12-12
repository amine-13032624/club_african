<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Equipe.php';

class EquipeController {
    private $db;
    private $equipe;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->equipe = new Equipe($this->db);
    }

    // CREATE - Ajouter une équipe
    public function ajouter($data) {
        $this->equipe->nom = $data['nom'] ?? '';
        $this->equipe->sport = $data['sport'] ?? '';
        $this->equipe->discipline = $data['discipline'] ?? null;
        $this->equipe->id_entraineur_principal = $data['id_entraineur_principal'] ?? null;
        $this->equipe->nombre_joueurs = $data['nombre_joueurs'] ?? 0;
        $this->equipe->couleur_principale = $data['couleur_principale'] ?? '';
        $this->equipe->couleur_secondaire = $data['couleur_secondaire'] ?? '';

        if ($this->equipe->ajouter()) {
            return [
                'success' => true,
                'message' => 'Équipe créée avec succès',
                'id_equipe' => $this->db->lastInsertId()
            ];
        }

        return [
            'success' => false,
            'message' => 'Erreur lors de la création de l\'équipe'
        ];
    }

    // READ - Récupérer toutes les équipes
    public function getTousEquipes() {
        $query = "SELECT e.*, m.nom as nom_entraineur, m.prenom as prenom_entraineur
                  FROM equipe e
                  LEFT JOIN entraineur en ON e.id_entraineur_principal = en.id_entraineur
                  LEFT JOIN membre m ON en.id_membre = m.id_membre
                  ORDER BY e.nom";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ - Récupérer une équipe par ID
    public function getEquipeById($id) {
        $equipe = $this->equipe->getById($id);
        
        if (!$equipe) {
            return null;
        }

        // Récupérer les athlètes de l'équipe
        $equipe['athletes'] = $this->getAthletes($id);
        
        // Récupérer les statistiques
        $equipe['statistiques'] = $this->equipe->suivreEquipe($id);

        return $equipe;
    }

    // READ - Récupérer les athlètes d'une équipe
    public function getAthletes($id_equipe) {
        $query = "SELECT m.*, a.id_athlete, a.numeroLicence, a.position, a.taille, a.poids
                  FROM athlete a
                  INNER JOIN membre m ON a.id_membre = m.id_membre
                  WHERE a.id_equipe = ?
                  ORDER BY m.nom, m.prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_equipe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE - Modifier une équipe
    public function modifier($id, $data) {
        $this->equipe->id_equipe = $id;
        $this->equipe->nom = $data['nom'] ?? '';
        $this->equipe->sport = $data['sport'] ?? '';
        $this->equipe->discipline = $data['discipline'] ?? null;
        $this->equipe->id_entraineur_principal = $data['id_entraineur_principal'] ?? null;
        $this->equipe->nombre_joueurs = $data['nombre_joueurs'] ?? 0;
        $this->equipe->couleur_principale = $data['couleur_principale'] ?? '';
        $this->equipe->couleur_secondaire = $data['couleur_secondaire'] ?? '';

        if ($this->equipe->modifier()) {
            return [
                'success' => true,
                'message' => 'Équipe modifiée avec succès'
            ];
        }

        return [
            'success' => false,
            'message' => 'Erreur lors de la modification de l\'équipe'
        ];
    }

    // DELETE - Supprimer une équipe
    public function supprimer($id) {
        if ($this->equipe->supprimer($id)) {
            return [
                'success' => true,
                'message' => 'Équipe supprimée avec succès'
            ];
        }

        return [
            'success' => false,
            'message' => 'Erreur lors de la suppression de l\'équipe'
        ];
    }

    // Ajouter un athlète à une équipe
    public function ajouterAthlete($id_equipe, $id_athlete) {
        $this->equipe->id_equipe = $id_equipe;
        
        if ($this->equipe->ajouterAthlete($id_athlete)) {
            return [
                'success' => true,
                'message' => 'Athlète ajouté à l\'équipe avec succès'
            ];
        }

        return [
            'success' => false,
            'message' => 'Erreur lors de l\'ajout de l\'athlète'
        ];
    }

    // Obtenir les statistiques d'une équipe
    public function getStatistiques($id_equipe) {
        return $this->equipe->suivreEquipe($id_equipe);
    }

    // Créer une équipe (alias pour ajouter)
    public function creer($data) {
        return $this->ajouter($data);
    }

    // Récupérer les équipes avec détails complets
    public function getEquipesAvecDetails() {
        $equipes = $this->getTousEquipes();
        
        foreach ($equipes as &$equipe) {
            $equipe['athletes'] = $this->getAthletes($equipe['id_equipe']);
            $equipe['statistiques'] = $this->equipe->suivreEquipe($equipe['id_equipe']);
        }

        return $equipes;
    }

    // Compter le nombre d'équipes
    public function countEquipes() {
        $query = "SELECT COUNT(*) as count FROM equipe";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    // Rechercher une équipe par nom
    public function rechercherParNom($nom) {
        $query = "SELECT e.*, m.nom as nom_entraineur, m.prenom as prenom_entraineur
                  FROM equipe e
                  LEFT JOIN entraineur en ON e.id_entraineur_principal = en.id_entraineur
                  LEFT JOIN membre m ON en.id_membre = m.id_membre
                  WHERE e.nom LIKE ?
                  ORDER BY e.nom";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['%' . $nom . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
