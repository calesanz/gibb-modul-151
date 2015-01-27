-- Author: Elias Schmidhalter
-- Table Creation
CREATE TABLE KATEGORIE (kategorieid INTEGER PRIMARY KEY,kategoriename text NOT NULL);

CREATE TABLE UMFRAGE(umfrageid INTEGER PRIMARY KEY, umfragetitel text NOT NULL);

CREATE TABLE FRAGE(frageid INTEGER PRIMARY KEY,umfrage integer NOT NULL,fragetext text NOT NULL,kategorie int NOT NULL, CONSTRAINT fk_umfrage FOREIGN KEY(umfrage) REFERENCES UMFRAGE(umfrageid),CONSTRAINT fk_kategorie FOREIGN KEY(kategorie) REFERENCES KATEGORIE(id));

CREATE TABLE BENUTZER(benutzerid INTEGER PRIMARY KEY,benutzername text NOT NULL, passwort text NOT NULL,
	email text NOT NULL,
	vorname text NOT NULL,
	nachname text NOT NULL,
	UNIQUE(benutzername) ON CONFLICT FAIL,
	UNIQUE(email) ON CONFLICT FAIL
);

CREATE TABLE ANTWORT(benutzerid integer NOT NULL, frage integer NOT NULL,gewichtung integer NOT NULL,
UNIQUE(benutzerid,frage) ON CONFLICT FAIL,
CONSTRAINT fk_benutzer FOREIGN KEY(benutzerid) REFERENCES BENUTZER(benutzerid),
CONSTRAINT fk_frage FOREIGN KEY(frage) REFERENCES FRAGE(frageid));

-- Login
-- SELECT id,username,email FROM USER WHERE username = "" AND password = "";

-- Insert Statements for Testing
-- INSERT INTO KATEGORIE (kategoriename) VALUES('Spass');
-- INSERT INTO UMFRAGE(umfragetitel) VALUES ('Lustig');
-- INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Lustig'),'Wie lustig ist das leben?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Spass') );
-- INSERT INTO BENUTZER(benutzername,vorname,nachname,passwort,email) VALUES ('eliass','Elias','Schmidhalter','7c4a8d09ca3762af61e59520943dc26494f8941b','elias@schmidhalter.me');
-- INSERT INTO ANTWORT (benutzerid,frage,gewichtung) VALUES ((SELECT benutzerid FROM BENUTZER WHERE benutzername='elias'),(SELECT frageid FROM FRAGE WHERE frageid=1),50);


-- Meine Umfrage
INSERT INTO UMFRAGE(umfragetitel) VALUES ('Genussmittel & Süchte');

INSERT INTO KATEGORIE (kategoriename) VALUES('Alkohol');
INSERT INTO KATEGORIE (kategoriename) VALUES('Drogen');
INSERT INTO KATEGORIE (kategoriename) VALUES('Zigaretten');
INSERT INTO KATEGORIE (kategoriename) VALUES('Onlinesucht');
INSERT INTO KATEGORIE (kategoriename) VALUES('Süssigkeiten');


INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Trinken Sie oft Alkohol?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Alkohol') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Betrinken Sie sich oft?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Alkohol') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Trinken Sie oft mehr als eine Portion Alkohol? (1-2 Gläser)',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Alkohol') );

INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Konsumieren Sie oder haben Sie schon einmal Drogen konsumiert?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Drogen') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Denken Sie oft daran, Drogen zu konsumieren?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Drogen') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Fühlen Sie sich schlecht, wenn Sie Drogen konsumieren?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Drogen') );

INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Rauchen Sie oft Zigaretten?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Zigaretten') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Rauchen Sie mehr als ein halbes "Päckli" am Tag?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Zigaretten') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Rauchen Sie oft morgens nach dem Aufstehen?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Zigaretten') );

INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Verbringen Sie oft mehr als 2 Stunden pro Tag online?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Onlinesucht') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Vernachlässigen Sie Ihre "real life" Kontakte um online zu sein?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Onlinesucht') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Fällt es Ihnen schwer, einen Tag offline zu sein?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Onlinesucht') );

INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Essen Sie oft Süssigkeiten?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Süssigkeiten') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Essen Sie mehr Süssigkeiten als andere Lebensmittel?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Süssigkeiten') );
INSERT INTO FRAGE(umfrage,fragetext,kategorie) VALUES ((SELECT umfrageid FROM UMFRAGE where umfragetitel = 'Genussmittel & Süchte'),'Essen Sie schon vor einer Mahlzeit Süssigkeiten?',  (SELECT kategorieid from KATEGORIE WHERE kategoriename = 'Süssigkeiten') );




