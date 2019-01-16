CREATE TABLE IF NOT EXISTS professionnels(
	id INT AUTO_INCREMENT,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	adresse VARCHAR(100) NOT NULL,
	telephone VARCHAR(15) NOT NULL,
	mail VARCHAR(50) NOT NULL,
	mot_de_passe VARCHAR(80) NOT NULL,
	diplome VARCHAR(40) NOT NULL,
	specialite VARCHAR(40),
	photo text,
	confirme BOOLEAN NOT NULL DEFAULT FALSE,
	CONSTRAINT pk_pro PRIMARY KEY(id),
	CONSTRAINT login_passwd UNIQUE(mail,mot_de_passe)
);

CREATE TABLE IF NOT EXISTS forum(
    id INT AUTO_INCREMENT,
    titre VARCHAR(1000),
	date_creation DATETIME,
	nbSujets INT(255),
    CONSTRAINT pk_forum PRIMARY KEY(id)
);


CREATE TABLE IF NOT EXISTS sujet(
    id INT AUTO_INCREMENT,
    id_forum INT,
    titre VARCHAR(1000),
    contenu text,
	date_creation DATETIME,
	id_user INT,
	photo text,
    CONSTRAINT pk_sujet PRIMARY KEY(id),
    CONSTRAINT fk_pub_pro FOREIGN KEY (id_user) REFERENCES professionnels(id),
    CONSTRAINT fk_pub_forum FOREIGN KEY (id_forum) REFERENCES forum(id)
);

CREATE TABLE IF NOT EXISTS commentaire(
	id INT AUTO_INCREMENT,
	id_sujet INT,
	id_user INT,
	contenu text,
	date_creation DATETIME,
     CONSTRAINT pk_com PRIMARY KEY(id),
    CONSTRAINT fk_com_pro FOREIGN KEY (id_user) REFERENCES professionnels(id),
    CONSTRAINT fk_com_sujet FOREIGN KEY (id_sujet) REFERENCES sujet(id)
);

-- Insertion 
INSERT INTO forum (titre, date_creation )VALUES ('L''allergologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L'' anesthésiologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''andrologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La cardiologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La chirurgie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La neurochirurgie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''allergologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La dermatologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''endocrinologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La gastro-entérologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La gériatrie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La gynécologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''hématologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''hépatologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''infectiologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La médecine aiguë', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La médecine du travail', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La médecine générale', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La médecine interne', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La médecine nucléaire', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La médecine palliative', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La médecine physique', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''obstétrique', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''oncologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''odontologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La neurologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La néphrologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La néonatologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''ophtalmologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''orthopédie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''Oto-rhino-laryngologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La médecine préventive', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La pédiatrie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La pédiatrie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La pneumologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La psychiatrie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La médecine préventive', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('L''urologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La rhumatologie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La radiothérapie', NOW());
INSERT INTO forum (titre, date_creation )VALUES ('La radiologie', NOW());





-- DROP TABLE commentaire;
-- DROP TABLE sujet;
-- DROP TABLE professionnels;
-- DROP TABLE forum;
