DROP DATABASE IF EXISTS club_sportif;
CREATE DATABASE IF NOT EXISTS club_sportif;
USE club_sportif;

-- Table Club
CREATE TABLE Club (
    id_club INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    adresse VARCHAR(200),
    telephone VARCHAR(20),
    email VARCHAR(100)
);

-- Table Membre (abstract)
CREATE TABLE Membre (
    id_membre INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telephone VARCHAR(20),
    dateNaissance DATE,
    dateInscription DATE DEFAULT CURRENT_DATE,
    categorie VARCHAR(50),
    niveau VARCHAR(50),
    type_membre ENUM('athlete', 'entraineur', 'staff') NOT NULL
);

-- Table Athlete
CREATE TABLE Athlete (
    id_athlete INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT,
    numeroLicence VARCHAR(50) UNIQUE,
    FOREIGN KEY (id_membre) REFERENCES Membre(id_membre)
);

-- Table Entraineur
CREATE TABLE Entraineur (
    id_entraineur INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT,
    specialite VARCHAR(100),
    diplome VARCHAR(100),
    FOREIGN KEY (id_membre) REFERENCES Membre(id_membre)
);

-- Table Staff
CREATE TABLE Staff (
    id_staff INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT,
    fonction VARCHAR(100),
    FOREIGN KEY (id_membre) REFERENCES Membre(id_membre)
);

-- Table Abonnement
CREATE TABLE Abonnement (
    id_abonnement INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT,
    type VARCHAR(50),
    dateDebut DATE,
    dateFin DATE,
    prix DECIMAL(10,2),
    statut ENUM('actif', 'inactif', 'expire') DEFAULT 'actif',
    FOREIGN KEY (id_membre) REFERENCES Membre(id_membre)
);

-- Table Equipe (must be before Entrainement for foreign key)
CREATE TABLE Equipe (
    id_equipe INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    discipline VARCHAR(100)
);

-- Table Entrainement
CREATE TABLE Entrainement (
    id_entrainement INT PRIMARY KEY AUTO_INCREMENT,
    id_entraineur INT,
    id_equipe INT,
    titre VARCHAR(100),
    description TEXT,
    date_entrainement DATE,
    heure_debut TIME,
    heure_fin TIME,
    lieu VARCHAR(100),
    type VARCHAR(50),
    niveau VARCHAR(50),
    FOREIGN KEY (id_entraineur) REFERENCES Entraineur(id_entraineur),
    FOREIGN KEY (id_equipe) REFERENCES Equipe(id_equipe)
);

-- Table Participation Entrainement
CREATE TABLE ParticipationEntrainement (
    id_athlete INT,
    id_entrainement INT,
    PRIMARY KEY (id_athlete, id_entrainement),
    FOREIGN KEY (id_athlete) REFERENCES Athlete(id_athlete),
    FOREIGN KEY (id_entrainement) REFERENCES Entrainement(id_entrainement)
);

-- Table Performance
CREATE TABLE Performance (
    id_performance INT PRIMARY KEY AUTO_INCREMENT,
    id_athlete INT,
    date DATE,
    type VARCHAR(50),
    valeur DECIMAL(10,2),
    commentaire TEXT,
    FOREIGN KEY (id_athlete) REFERENCES Athlete(id_athlete)
);

-- Table Competition
CREATE TABLE Competition (
    id_competition INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    date DATE,
    lieu VARCHAR(100),
    type VARCHAR(50)
);

-- Table Participation Competition
CREATE TABLE ParticipationCompetition (
    id_athlete INT,
    id_competition INT,
    PRIMARY KEY (id_athlete, id_competition),
    FOREIGN KEY (id_athlete) REFERENCES Athlete(id_athlete),
    FOREIGN KEY (id_competition) REFERENCES Competition(id_competition)
);

-- Table Paiement
CREATE TABLE Paiement (
    id_paiement INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT,
    date DATE,
    montant DECIMAL(10,2),
    typePaiement VARCHAR(50),
    statut ENUM('paye', 'en_attente', 'annule') DEFAULT 'en_attente',
    FOREIGN KEY (id_membre) REFERENCES Membre(id_membre)
);

-- Table Sponsor
CREATE TABLE Sponsor (
    id_sponsor INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    contact VARCHAR(100),
    email VARCHAR(100)
);

-- Table Contrat
CREATE TABLE Contrat (
    id_contrat INT PRIMARY KEY AUTO_INCREMENT,
    id_sponsor INT,
    dateDebut DATE,
    dateFin DATE,
    montant DECIMAL(10,2),
    conditions TEXT,
    FOREIGN KEY (id_sponsor) REFERENCES Sponsor(id_sponsor)
);

-- Table Membre_Equipe
CREATE TABLE Membre_Equipe (
    id_membre INT,
    id_equipe INT,
    PRIMARY KEY (id_membre, id_equipe),
    FOREIGN KEY (id_membre) REFERENCES Membre(id_membre),
    FOREIGN KEY (id_equipe) REFERENCES Equipe(id_equipe)
);