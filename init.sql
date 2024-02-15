CREATE TABLE appartements (
                              id SERIAL PRIMARY KEY,
                              superficie INT,
                              nb_occupant INT,
                              rue VARCHAR(255),
                              ville VARCHAR(255),
                              cp INT,
                              prix INT,
                              proprietaire VARCHAR(255)
);

CREATE TABLE users (
                       id SERIAL PRIMARY KEY,
                       Nom VARCHAR(255),
                       Prenom VARCHAR(255),
                       token VARCHAR(255),
                       Droit INT
);

CREATE TABLE reservation (
                             id SERIAL PRIMARY KEY,
                             client_id INT,
                             appartement_id INT,
                             prix INT DEFAULT 0,
                             date_debut TIMESTAMP,
                             date_fin TIMESTAMP,
                             FOREIGN KEY (client_id) REFERENCES users(id),
                             FOREIGN KEY (appartement_id) REFERENCES appartements(id)
);
