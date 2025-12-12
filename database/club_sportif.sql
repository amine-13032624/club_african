DROP DATABASE IF EXISTS club_sportif;
CREATE DATABASE IF NOT EXISTS club_sportif DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
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
CREATE TABLE entrainement (
    id_entrainement INT PRIMARY KEY AUTO_INCREMENT,
    id_entraineur INT,
    id_equipe INT,
    titre VARCHAR(150),
    description TEXT,
    date_entrainement DATETIME,
    heure_debut TIME,
    heure_fin TIME,
    lieu VARCHAR(100),
    type VARCHAR(50),
    niveau VARCHAR(50),
    FOREIGN KEY (id_entraineur) REFERENCES entraineur(id_entraineur),
    FOREIGN KEY (id_equipe) REFERENCES equipe(id_equipe)
);

-- Table Paiement
CREATE TABLE paiement (
    id_paiement INT PRIMARY KEY AUTO_INCREMENT,
    id_membre INT,
    montant DECIMAL(10,2),
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    methode_paiement VARCHAR(50),
    statut VARCHAR(20) DEFAULT 'en attente',
    description TEXT,
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);

-- Table Competition
CREATE TABLE competition (
    id_competition INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    date_competition DATE,
    lieu VARCHAR(100),
    type VARCHAR(50),
    niveau VARCHAR(50),
    id_equipe INT,
    resultat VARCHAR(50),
    nombre_participants INT DEFAULT 0,
    FOREIGN KEY (id_equipe) REFERENCES equipe(id_equipe)
);

-- Table Performance
CREATE TABLE performance (
    id_performance INT PRIMARY KEY AUTO_INCREMENT,
    id_athlete INT,
    id_competition INT,
    id_entraineur INT,
    type_performance VARCHAR(100),
    valeur DECIMAL(10,2),
    unite VARCHAR(50),
    date_performance DATETIME DEFAULT CURRENT_TIMESTAMP,
    commentaire TEXT,
    FOREIGN KEY (id_athlete) REFERENCES athlete(id_athlete),
    FOREIGN KEY (id_competition) REFERENCES competition(id_competition),
    FOREIGN KEY (id_entraineur) REFERENCES entraineur(id_entraineur)
);

-- Table Participation (liaison competition-athlete)
CREATE TABLE participation (
    id_participation INT PRIMARY KEY AUTO_INCREMENT,
    id_competition INT,
    id_athlete INT,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(20) DEFAULT 'inscrit',
    UNIQUE KEY uniq_competition_athlete (id_competition, id_athlete),
    FOREIGN KEY (id_competition) REFERENCES competition(id_competition),
    FOREIGN KEY (id_athlete) REFERENCES athlete(id_athlete)
);

-- Table Recus (génération de reçus pour paiements)
CREATE TABLE recus (
    id_recu INT PRIMARY KEY AUTO_INCREMENT,
    id_paiement INT,
    numero_recu VARCHAR(100) UNIQUE,
    date_emission DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(20) DEFAULT 'emis',
    FOREIGN KEY (id_paiement) REFERENCES paiement(id_paiement)
);

-- Table Reminders (rappels d'entraînements)
CREATE TABLE reminders (
    id_reminder INT PRIMARY KEY AUTO_INCREMENT,
    id_entrainement INT,
    email_sent TINYINT(1) DEFAULT 0,
    date_sent DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(20),
    FOREIGN KEY (id_entrainement) REFERENCES entrainement(id_entrainement)
);

-- Table Sponsor
CREATE TABLE sponsor (
    id_sponsor INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    secteur VARCHAR(100),
    montant_contribution DECIMAL(12,2),
    date_debut DATE,
    date_fin DATE,
    contact VARCHAR(100),
    telephone VARCHAR(20),
    email VARCHAR(100),
    statut VARCHAR(20) DEFAULT 'actif'
);

-- Table Contrat (liaison sponsor-athlete)
CREATE TABLE contrat (
    id_contrat INT PRIMARY KEY AUTO_INCREMENT,
    id_athlete INT,
    id_sponsor INT,
    description TEXT,
    date_debut DATE,
    date_fin DATE,
    montant DECIMAL(12,2),
    statut VARCHAR(20) DEFAULT 'actif',
    conditions TEXT,
    FOREIGN KEY (id_athlete) REFERENCES athlete(id_athlete),
    FOREIGN KEY (id_sponsor) REFERENCES sponsor(id_sponsor)
);

-- Table Depenses (suivi financier)
CREATE TABLE depenses (
    id_depense INT PRIMARY KEY AUTO_INCREMENT,
    type_depense VARCHAR(100),
    montant DECIMAL(12,2),
    date_depense DATE,
    statut VARCHAR(20) DEFAULT 'validee',
    description TEXT
);

-- Table Rapports (générés par le staff)
CREATE TABLE rapports (
    id_rapport INT PRIMARY KEY AUTO_INCREMENT,
    id_staff INT,
    titre VARCHAR(150),
    description TEXT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    contenu TEXT,
    FOREIGN KEY (id_staff) REFERENCES staff(id_staff)
);
