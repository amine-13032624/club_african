<?php
require_once 'config/database.php';

abstract class Membre {
    protected $id_membre;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $telephone;
    protected $dateNaissance;
    protected $dateInscription;
    protected $categorie;
    protected $niveau;
    
    protected $conn;
    protected $table_name;

    public function __construct($db) {
        $this->conn = $db;
        $this->table_name = "membre";
    }

    // Méthodes abstraites
    abstract public function inscrire();
    abstract public function modifierProfil($id, $data);

    // Getters et Setters
    public function getId() { return $this->id_membre; }
    public function getNom() { return $this->nom; }
    public function setNom($nom) { $this->nom = $nom; }
    public function getPrenom() { return $this->prenom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }
    public function getTelephone() { return $this->telephone; }
    public function setTelephone($telephone) { $this->telephone = $telephone; }
    public function getDateNaissance() { return $this->dateNaissance; }
    public function setDateNaissance($date) { $this->dateNaissance = $date; }
    public function getCategorie() { return $this->categorie; }
    public function setCategorie($categorie) { $this->categorie = $categorie; }
    public function getNiveau() { return $this->niveau; }
    public function setNiveau($niveau) { $this->niveau = $niveau; }
    
    // Méthodes communes
    public function getInfoComplet() {
        return [
            'id' => $this->id_membre,
            'nom_complet' => $this->prenom . ' ' . $this->nom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'categorie' => $this->categorie,
            'niveau' => $this->niveau
        ];
    }
}
?>