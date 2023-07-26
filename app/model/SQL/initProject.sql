CREATE TABLE Groupe (
    id_groupe INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE Role (
    id_role INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    slug VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE Authorization (
    id_authorization INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_groupe INT,
    id_role INT,
    FOREIGN KEY (id_groupe) REFERENCES Groupe(id_groupe),
    FOREIGN KEY (id_role) REFERENCES Role(id_role)
);

CREATE TABLE User(
    id_user INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    id_groupe INT NOT NULL
);

CREATE TABLE Candidat (
    id_candidat INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    nb_voix INT
);

INSERT INTO
    User (email, password, id_groupe)
VALUES
    ('admin@gmail.com', 'admin', 1),
    ('operator@gmail.com', 'operator', 2);

INSERT INTO
    Role (slug, name)
VALUES
    ('create-candidat', 'Créer candidat'),
    ('update-candidat', 'Modifier candidat'),
    ('delete-candidat', 'Supprimer candidat'),
    ('create-user', 'Créer utilisateur'),
    ('update-user', 'Modifier utilisateur'),
    ('delete-user', 'Supprimer utilisateur');

INSERT INTO
    Candidat (name, nb_voix)
VALUES
    ('Rakoto', 45),
    ('Rabe', 29),
    ('Randria', 33),
    ('Ranaivo', 56);

INSERT INTO
    Groupe (name)
VALUES
    ('admin'),
    ('operator');

INSERT INTO
    Authorization (id_groupe, id_role)
VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (1, 4),
    (1, 5),
    (1, 6),
    (2, 1),
    (2, 2),
    (2, 3);