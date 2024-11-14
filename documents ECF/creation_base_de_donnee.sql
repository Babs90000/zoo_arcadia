/* CREATION DES TABLES  */


CREATE TABLE roles (
role_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
label VARCHAR(50) NOT NULL
);

CREATE TABLE utilisateurs (
    username VARCHAR(50) PRIMARY KEY,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(role_id),
    password VARCHAR(60) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL
);




CREATE TABLE habitats (
    habitat_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nom VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    commentaire_habitat VARCHAR(50)
);


CREATE TABLE races (
    race_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    label VARCHAR(50) NOT NULL
);


CREATE TABLE animaux (
    animal_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    etat VARCHAR(50) NOT NULL,
    habitat_id INT,
    FOREIGN KEY (habitat_id) REFERENCES habitats(habitat_id),
    race_id INT,
    FOREIGN KEY (race_id) REFERENCES races(race_id),
    description TEXT,
    age VARCHAR(50) NOT NULL
);

CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    heure_ouverture VARCHAR(255) NOT NULL,
    heure_fermeture VARCHAR(255) NOT NULL,
    prix VARCHAR(255) NOT NULL,
    disponibilite VARCHAR(255) NOT NULL
);

CREATE TABLE images (
    image_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    image_data BLOB NOT NULL,
    habitat_id INT,
    FOREIGN KEY (habitat_id) REFERENCES habitats(habitat_id) ON DELETE CASCADE,
    animal_id INT,
    FOREIGN KEY (animal_id) REFERENCES animaux(animal_id) ON DELETE CASCADE,
    service_id INT,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE
);
CREATE TABLE rapports_veterinaires (
    rapport_veterinaire_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(50),
    animal_id INT NOT NULL,
    FOREIGN KEY (username) REFERENCES utilisateurs(username) ON DELETE SET NULL,
    FOREIGN KEY (animal_id) REFERENCES animaux(animal_id) ON DELETE CASCADE,
    etat_animal VARCHAR(50) NOT NULL,
    nourriture_proposee VARCHAR(50) NOT NULL,
    grammage_nourriture INT NOT NULL,
    date_passage DATE NOT NULL ,
    detail_etat_animal VARCHAR(50)
);


CREATE TABLE avis (
    avis_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    pseudo VARCHAR(50) NOT NULL,
    commentaire TEXT NOT NULL,
    isVisible BOOL NOT NULL);


    CREATE TABLE horaires_ouverture (
    horaire_id INT AUTO_INCREMENT PRIMARY KEY,
    type_jour VARCHAR(50) NOT NULL,
    heure_ouverture VARCHAR(5) NOT NULL,
    heure_fermeture VARCHAR(5) NOT NULL
    );

/* le formatage des horaires comme ci-dessous ne fonctione pas donc je vais definir ce champs comme un varchar
    UPDATE horaires_ouverture
    SET heure_ouverture = TIME_FORMAT(heure_ouverture, '%H:%i'),
    heure_fermeture = TIME_FORMAT(heure_fermeture, '%H:%i'); */



/* FIN DE CREATION DES TABLES  */


/* INSERTION DES DONNEES  */

INSERT INTO roles (label) VALUES ('admin'), ('employe'), ('veterinaire');

INSERT INTO services (nom, description, heure_ouverture, heure_fermeture, prix, disponibilite) VALUES
('Restauration', 'Divers restaurants et stands de nourriture sont disponibles dans le zoo.', '10:00', '18:00', 'Variable', 'Tous les jours'),
('Visite des habitats avec un guide', 'Visite guidée gratuite des habitats des animaux.', '10:00', '16:00', 'Gratuit', 'Tous les jours'),
('Visite du zoo en petit train', 'Tour du zoo en petit train avec des arrêts aux principales attractions.', '10:00', '17:00', '5€ par personne', 'Tous les jours');

INSERT INTO horaires_ouverture (type_jour, heure_ouverture, heure_fermeture) VALUES
('En semaine', '8H', '18H'),
('Autres jours', '8H', '19H30');


ALTER TABLE images MODIFY COLUMN image_data LONGBLOB;


/* FIN D'INSERTION DES DONNEES  */


ALTER TABLE images MODIFY COLUMN image_data LONGBLOB;

/* FIN D'INSERTION DES DONNEES  */
