CREATE DATABASE PCR_BD;
/* création de la base de données du PCR */

CREATE TABLE Abonnes (
	loginAbo varchar(255),
	passAbo varchar(255),
	nomAbo varchar(255),
	prenomAbo varchar(255),
	mailAbo varchar(255),
	actifAbo boolean,
	CONSTRAINT PK_Abo PRIMARY KEY (loginAbo)
);

CREATE TABLE Publications (
	codePub varchar(255),
	titrePub varchar(255),
	typePub varchar(255),
	datePub date,
	CONSTRAINT PK_Pub PRIMARY KEY (codePub)
);

CREATE TABLE Administrateurs (
	loginAdmin varchar(255),
	passAdmin varchar(255),
	nomAdmin varchar(255),
	prenomAdmin varchar(255),
	mailAdmin varchar(255),
	actifAdmin boolean,
	CONSTRAINT PK_Admin PRIMARY KEY (loginAdmin)
);

CREATE TABLE Chercheurs (
	loginCh varchar(255),
	passCh varchar(255),
	nomCh varchar(255),
	prenomCh varchar(255),
	mailCh varchar(255),
	telCh numeric,
	CONSTRAINT PK_Ch PRIMARY KEY (loginCh)
);

CREATE TABLE EquipeProjets (
	codeEq varchar(255),
	nomEq varchar(255),
	CONSTRAINT PK_EqPro PRIMARY KEY (codeEq)
);

CREATE TABLE Projets (
	codeProjet varchar(255),
	titreProjet varchar(255),
	theme varchar(255),
	budget numeric,
	dateDebut date,
	description varchar(255),
	loginChefProjet varchar(255),
	codeEq varchar(255),
	CONSTRAINT PK_Pro PRIMARY KEY (codeProjet),
	CONSTRAINT FK_Pro_Ch FOREIGN KEY (loginChefProjet) REFERENCES Chercheurs(loginCh),
	CONSTRAINT FK_Pro_Eq FOREIGN KEY (codeEq) REFERENCES EquipeProjets (codeEq)
);

CREATE TABLE Fichiers (
	codeFich varchar(255),
	nomFich varchar(255),
	codeProjet varchar(255),
	CONSTRAINT PK_Fich PRIMARY KEY (codeFich),
	CONSTRAINT FK_Pro FOREIGN KEY (codeProjet) REFERENCES Projets (codeProjet)
);

CREATE TABLE Appartenir (
	loginCh varchar(255),
	codeEq varchar(255),
	CONSTRAINT FK_App_Ch FOREIGN KEY (loginCh) REFERENCES Chercheurs (loginCh),
	CONSTRAINT FK_App_Eq FOREIGN KEY (codeEq) REFERENCES EquipeProjets(codeEq)
);

CREATE TABLE Publier (
	codePub varchar(255),
	loginCh varchar(255),
	CONSTRAINT FK_Publier_Pub FOREIGN KEY (codePub) REFERENCES Publications(codePub),
	CONSTRAINT FK_Publier_Ch FOREIGN KEY (loginCh) REFERENCES Chercheurs (loginCh)
);

CREATE TABLE Commentaires (
	codeCom varchar(255),
	contenuCom varchar(255),
	dateCom date,
	codePubCh varchar(255),
	loginCh varchar(255),
	codePubAbo varchar(255),
	loginAbo varchar(255)
	CONSTRAINT FK_Com_Pub_Ch FOREIGN KEY (codePubCh) REFERENCES Publications (codePub),
	CONSTRAINT FK_com_Ch FOREIGN KEY (loginCh) REFERENCES Chercheurs (loginCh),
	CONSTRAINT FK_Com_Pub_Abo FOREIGN KEY (codePubAbo) REFERENCES Publications(codePub),
	CONSTRAINT FK_Com_Abo FOREIGN KEY (loginAbo) REFERENCES Abonnes (loginAbo)
>>>>>>> Stashed changes
);
