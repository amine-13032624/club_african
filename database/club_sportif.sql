DROP DATABASE IF EXISTS club_sportif;
CREATE DATABASE IF NOT EXISTS club_sportif;
USE club_sportif;

-- Table Club
CREATE TABLE club (
    id_club INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    adresse VARCHAR(200),
    telephone VARCHAR(20),
    email VARCHAR(100)
);

-- Table Membre (abstract)
CREATE TABLE membre (
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

-- Table Entraineur (must be before Equipe)
CREATE TABLE entraineur (
    id_entraineur INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT UNIQUE,
    specialite VARCHAR(100),
    diplome VARCHAR(100),
    annees_experience INT DEFAULT 0,
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);

-- Table Staff
CREATE TABLE staff (
    id_staff INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT UNIQUE,
    fonction VARCHAR(100),
    departement VARCHAR(100),
    date_embauche DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);

-- Table Equipe (must be before Athlete)
CREATE TABLE equipe (
    id_equipe INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    sport VARCHAR(100),
    discipline VARCHAR(100),
    id_entraineur_principal INT,
    nombre_joueurs INT DEFAULT 0,
    couleur_principale VARCHAR(50),
    couleur_secondaire VARCHAR(50),
    date_creation DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_entraineur_principal) REFERENCES entraineur(id_entraineur)
);

-- Table Athlete
CREATE TABLE athlete (
    id_athlete INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT UNIQUE,
    numeroLicence VARCHAR(50) UNIQUE,
    taille DECIMAL(5,2),
    poids DECIMAL(5,2),
    position VARCHAR(50),
    id_equipe INT,
    date_debut_participation DATE,
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre),
    FOREIGN KEY (id_equipe) REFERENCES equipe(id_equipe)
);

-- Table Abonnement
CREATE TABLE abonnement (
    id_abonnement INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT,
    type VARCHAR(50),
    date_debut DATE,
    date_fin DATE,
    prix DECIMAL(10,2),
    nombre_seances INT DEFAULT 0,
    statut ENUM('actif', 'inactif', 'expire') DEFAULT 'actif',
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);

-- Table Entrainement