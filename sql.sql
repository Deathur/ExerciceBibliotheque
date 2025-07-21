DROP TABLE IF EXISTS Livres;

CREATE TABLE
    Livres (
        id_livres int AUTO_INCREMENT NOT NULL,
        nomLivres VARCHAR(255),
        dispoLivres BOOLEAN,
        PRIMARY KEY (id_livres)
    ) ENGINE = InnoDB;

DROP TABLE IF EXISTS Ecrivains;

CREATE TABLE
    Ecrivains (
        id_ecrivains int AUTO_INCREMENT NOT NULL,
        nomEcrivains VARCHAR(255),
        prenomEcrivains VARCHAR(255),
        nationalitéEcrivains VARCHAR(255),
        PRIMARY KEY (id_ecrivains)
    ) ENGINE = InnoDB;

DROP TABLE IF EXISTS Genres;

CREATE TABLE
    Genres (
        id_genres int AUTO_INCREMENT NOT NULL,
        nomGenres VARCHAR(255),
        PRIMARY KEY (id_genres)
    ) ENGINE = InnoDB;

DROP TABLE IF EXISTS Utilisateurs;

CREATE TABLE
    Utilisateurs (
        id_utilisateurs int AUTO_INCREMENT NOT NULL,
        nomUtilisateurs VARCHAR(255),
        prenomUtilisateurs VARCHAR(255),
        mailUtilisateurs VARCHAR(255),
        PRIMARY KEY (id_utilisateurs)
    ) ENGINE = InnoDB;

DROP TABLE IF EXISTS Emprunts;

CREATE TABLE
    Emprunts (
        id_emprunts int AUTO_INCREMENT NOT NULL,
        dateEmprunts VARCHAR(255),
        renduEmprunts BOOLEAN,
        id_utilisateurs INT NOT NULL,
        id_livres INT NOT NULL,
        PRIMARY KEY (id_emprunts)
    ) ENGINE = InnoDB;

DROP TABLE IF EXISTS Ecrire;

CREATE TABLE
    Ecrire (
        id_livres int AUTO_INCREMENT NOT NULL,
        id_ecrivains INT NOT NULL,
        PRIMARY KEY (id_livres, id_ecrivains)
    ) ENGINE = InnoDB;

DROP TABLE IF EXISTS Appartient;

CREATE TABLE
    Appartient (
        id_livres int AUTO_INCREMENT NOT NULL,
        id_genres INT NOT NULL,
        PRIMARY KEY (id_livres, id_genres)
    ) ENGINE = InnoDB;

ALTER TABLE Emprunts ADD CONSTRAINT FK_Emprunts_id_utilisateurs FOREIGN KEY (id_utilisateurs) REFERENCES Utilisateurs (id_utilisateurs);

ALTER TABLE Emprunts ADD CONSTRAINT FK_Emprunts_id_livres FOREIGN KEY (id_livres) REFERENCES Livres (id_livres);

ALTER TABLE Ecrire ADD CONSTRAINT FK_Ecrire_id_livres FOREIGN KEY (id_livres) REFERENCES Livres (id_livres);

ALTER TABLE Ecrire ADD CONSTRAINT FK_Ecrire_id_ecrivains FOREIGN KEY (id_ecrivains) REFERENCES Ecrivains (id_ecrivains);

ALTER TABLE Appartient ADD CONSTRAINT FK_Appartient_id_livres FOREIGN KEY (id_livres) REFERENCES Livres (id_livres);

ALTER TABLE Appartient ADD CONSTRAINT FK_Appartient_id_genres FOREIGN KEY (id_genres) REFERENCES Genres (id_genres);