-- Création de la base de données
CREATE DATABASE IF NOT EXISTS projet_user_management;
USE projet_user_management;

-- Création de la table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    firstname VARCHAR(50) NOT NULL,
    gender ENUM('Homme', 'Femme', 'Autre') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    project_name VARCHAR(100) NOT NULL,
    project_date DATE NOT NULL,
    category ENUM('Technologie', 'Art', 'Science', 'Autre') NOT NULL,
    video_path VARCHAR(255),
    verification_code VARCHAR(6),
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Création d'un index sur l'email pour optimiser les recherches
CREATE INDEX idx_email ON users(email);

-- Création d'une table pour stocker les tokens d'authentification (optionnel)
CREATE TABLE IF NOT EXISTS auth_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Création d'un index sur le token pour optimiser les recherches
CREATE INDEX idx_token ON auth_tokens(token);

-- Insertion de quelques données de test (à supprimer en production)
INSERT INTO users (username, firstname, gender, email, password, project_name, project_date, category, is_verified)
VALUES 
('johndoe', 'John', 'Homme', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Projet A', '2023-01-01', 'Technologie', 1),
('janedoe', 'Jane', 'Femme', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Projet B', '2023-02-15', 'Art', 1);
