CREATE DATABASE IF NOT EXISTS planten_db;
USE planten_db;

CREATE TABLE IF NOT EXISTS standplaats (
    id INT NOT NULL AUTO_INCREMENT,
    naam VARCHAR(100) NOT NULL UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS planten (
    id INT NOT NULL AUTO_INCREMENT,
    naam VARCHAR(255),
    latijnse_naam VARCHAR(255),
    waterbehoefte VARCHAR(50),
    lichtbehoefte VARCHAR(50),
    groeihoogte_cm INT,
    verkoopprijs_eur DECIMAL(10,2),
    standplaats VARCHAR(100),
    standplaats_id INT,
    voorraad INT,
    bloeitijd VARCHAR(50),
    kleur VARCHAR(50),
    huisdier_vriendelijk VARCHAR(10),
    overview_image VARCHAR(255),
    additional_image1 VARCHAR(255),
    additional_image2 VARCHAR(255),
    PRIMARY KEY (id),
    FOREIGN KEY (standplaats_id) REFERENCES standplaats(id)
);

LOAD DATA INFILE '/var/lib/mysql-files/planten.csv'
INTO TABLE planten
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\r\n'
IGNORE 2 LINES
(naam, latijnse_naam, waterbehoefte, lichtbehoefte, groeihoogte_cm,
 verkoopprijs_eur, standplaats, voorraad, bloeitijd, kleur,
 huisdier_vriendelijk, overview_image, additional_image1, additional_image2);

INSERT INTO standplaats (naam)
SELECT DISTINCT standplaats FROM planten;

UPDATE planten p
JOIN standplaats s ON p.standplaats = s.naam
SET p.standplaats_id = s.id;