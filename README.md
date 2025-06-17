-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gestion_location;
USE gestion_location;

-- Table proprietaire
CREATE TABLE proprietaire (
    num INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    adresse1 VARCHAR(100) NOT NULL,
    adresse2 VARCHAR(100),
    codePostal VARCHAR(10) NOT NULL,
    ville VARCHAR(50) NOT NULL,
    numTel1 VARCHAR(20) NOT NULL,
    numTel2 VARCHAR(20),
    caCumule DECIMAL(10,2) DEFAULT 0,
    email VARCHAR(100)
);

-- Table tarif
CREATE TABLE tarif (
    codeTarif INT AUTO_INCREMENT PRIMARY KEY,
    prixSemHs DECIMAL(10,2) NOT NULL,
    prixSemBs DECIMAL(10,2) NOT NULL
);

-- Table appartement
CREATE TABLE appartement (
    numLocation INT AUTO_INCREMENT PRIMARY KEY,
    categorie VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    nbPersonnes INT NOT NULL,
    adresseLocation VARCHAR(100) NOT NULL,
    photo VARCHAR(255),
    equipements TEXT,
    codeTarif INT NOT NULL,
    numProprietaire INT NOT NULL,
    FOREIGN KEY (codeTarif) REFERENCES tarif(codeTarif),
    FOREIGN KEY (numProprietaire) REFERENCES proprietaire(num)
);

-- Table locataire
CREATE TABLE locataire (
    numLocataire INT AUTO_INCREMENT PRIMARY KEY,
    nomLocataire VARCHAR(50) NOT NULL,
    prenomLocataire VARCHAR(50) NOT NULL,
    adresse1Locataire VARCHAR(100) NOT NULL,
    adresse2Locataire VARCHAR(100),
    codePostalLocataire VARCHAR(10) NOT NULL,
    villeLocataire VARCHAR(50) NOT NULL,
    numTel1Locataire VARCHAR(20) NOT NULL,
    numTel2Locataire VARCHAR(20),
    emailLocataire VARCHAR(100)
);

-- Table contrat
CREATE TABLE contrat (
    numContrat INT AUTO_INCREMENT PRIMARY KEY,
    etat VARCHAR(20) NOT NULL,
    dateCreation DATE NOT NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    numAppartement INT NOT NULL,
    numLocataire INT NOT NULL,
    FOREIGN KEY (numAppartement) REFERENCES appartement(numLocation),
    FOREIGN KEY (numLocataire) REFERENCES locataire(numLocataire)
);