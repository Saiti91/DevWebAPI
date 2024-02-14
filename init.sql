CREATE TABLE appartements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    superficie int,
    nb_occupant int,
    rue varchar(255),
    ville varchar(255),
    cp int,
    prix int,
    proprietaire varchar(255)
);
CREATE TABLE users (
    id serial PRIMARY KEY,
    Nom varchar(255),
    Prenom varchar(255)
);
CREATE TABLE reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    appartement_id INT,
    prix INT DEFAULT 0,
    date_debut DATETIME,
    date_fin DATETIME,
    FOREIGN KEY (client_id) REFERENCES users(id),
    FOREIGN KEY (appartement_id) REFERENCES appartement(id)
);
