-- VoyageVista schema (minimal to start)
-- Run in your MySQL/MAMP environment: mysql -u root -p < voyagevista_schema.sql

CREATE DATABASE IF NOT EXISTS `voyagevista` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `voyagevista`;

-- Users
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL DEFAULT 'client',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Countries (will be seeded from europe_countries.sql)
CREATE TABLE IF NOT EXISTS `countries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `iso_code` CHAR(2) NOT NULL UNIQUE,
  `name` VARCHAR(100) NOT NULL
);

-- Destinations
CREATE TABLE IF NOT EXISTS `destinations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `country` VARCHAR(150) NOT NULL,
  `region` VARCHAR(255) DEFAULT NULL,
  `description` TEXT,
  `type` VARCHAR(50) DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `price_base` DECIMAL(10,2) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Transport
CREATE TABLE IF NOT EXISTS `transports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(50) NOT NULL,
  `company` VARCHAR(255),
  `origin` VARCHAR(255),
  `destination` INT, -- FK to destinations.id
  `departure` DATETIME,
  `arrival` DATETIME,
  `price` DECIMAL(10,2),
  `capacity` INT DEFAULT 0,
  `available` INT DEFAULT 0
);

-- Hebergements
CREATE TABLE IF NOT EXISTS `hebergements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `type` VARCHAR(100),
  `destination_id` INT,
  `address` VARCHAR(255),
  `capacity` INT DEFAULT 0,
  `price_night` DECIMAL(10,2) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Chambres
CREATE TABLE IF NOT EXISTS `chambres` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `hebergement_id` INT NOT NULL,
  `type` VARCHAR(100),
  `capacity` INT DEFAULT 1,
  `price_night` DECIMAL(10,2) DEFAULT 0,
  `available` TINYINT(1) DEFAULT 1
);

-- Activites
CREATE TABLE IF NOT EXISTS `activites` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `destination_id` INT,
  `categorie` VARCHAR(100),
  `duree_minutes` INT,
  `price_person` DECIMAL(10,2),
  `capacite_max` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Reservations (master)
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `date_reservation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `statut` VARCHAR(50) DEFAULT 'pending',
  `total` DECIMAL(10,2) DEFAULT 0,
  `reference` VARCHAR(100) UNIQUE
);

-- Reservation details
CREATE TABLE IF NOT EXISTS `reservation_transports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `reservation_id` INT NOT NULL,
  `transport_id` INT NOT NULL,
  `nb_voyageurs` INT DEFAULT 1
);

CREATE TABLE IF NOT EXISTS `reservation_hebergements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `reservation_id` INT NOT NULL,
  `chambre_id` INT NOT NULL,
  `date_entree` DATE,
  `date_sortie` DATE
);

CREATE TABLE IF NOT EXISTS `reservation_activites` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `reservation_id` INT NOT NULL,
  `activite_id` INT NOT NULL,
  `date` DATE,
  `nb_participants` INT DEFAULT 1
);

-- Notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `type` VARCHAR(50),
  `title` VARCHAR(255),
  `content` TEXT,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indexes and constraints can be added as needed.
