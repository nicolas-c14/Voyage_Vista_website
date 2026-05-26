-- Migration pour une base VoyageVista déjà importée
-- A exécuter une seule fois dans phpMyAdmin sur la base `voyagevista`.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

-- Destinations: colonnes utilisées par le code actuel
ALTER TABLE `destinations`
  ADD COLUMN `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `image`;

ALTER TABLE `destinations`
  ADD COLUMN `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `price`;

-- Réservations: table attendue par reservations/book.php et reservations/my-reservations.php
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `travel_date` date NOT NULL,
  `persons` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `destination_id` (`destination_id`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

COMMIT;