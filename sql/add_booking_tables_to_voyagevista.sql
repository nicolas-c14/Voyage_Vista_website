USE `voyagevista`;

CREATE TABLE IF NOT EXISTS `transports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(50) NOT NULL,
  `company` VARCHAR(255) DEFAULT NULL,
  `origin` VARCHAR(255) DEFAULT NULL,
  `destination` VARCHAR(255) DEFAULT NULL,
  `departure` DATETIME DEFAULT NULL,
  `arrival` DATETIME DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `capacity` INT NOT NULL DEFAULT 0,
  `available` INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `hebergements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `destination_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `type` VARCHAR(100) DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `capacity` INT NOT NULL DEFAULT 0,
  `price_night` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `equipments` TEXT DEFAULT NULL,
  `note` DECIMAL(3,2) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_hebergements_destination` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `chambres` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `hebergement_id` INT NOT NULL,
  `type` VARCHAR(100) DEFAULT NULL,
  `capacity` INT NOT NULL DEFAULT 1,
  `price_night` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `available` TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT `fk_chambres_hebergement` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `activites` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `destination_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `categorie` VARCHAR(100) DEFAULT NULL,
  `duree_minutes` INT DEFAULT NULL,
  `price_person` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `capacity_max` INT DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_activites_destination` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `reservations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `destination_id` INT NOT NULL,
  `check_in` DATE NOT NULL,
  `check_out` DATE NOT NULL,
  `travelers` INT NOT NULL DEFAULT 1,
  `total` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `reference` VARCHAR(100) NOT NULL UNIQUE,
  `status` ENUM('pending','confirmed','cancelled') NOT NULL DEFAULT 'confirmed',
  `payment_last4` CHAR(4) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_reservations_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reservations_destination` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `reservation_transports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `reservation_id` INT NOT NULL,
  `transport_id` INT NOT NULL,
  `nb_voyageurs` INT NOT NULL DEFAULT 1,
  `price_total` DECIMAL(10,2) NOT NULL DEFAULT 0,
  CONSTRAINT `fk_reservation_transports_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reservation_transports_transport` FOREIGN KEY (`transport_id`) REFERENCES `transports` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `reservation_hebergements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `reservation_id` INT NOT NULL,
  `hebergement_id` INT NOT NULL,
  `nights` INT NOT NULL DEFAULT 1,
  `price_total` DECIMAL(10,2) NOT NULL DEFAULT 0,
  CONSTRAINT `fk_reservation_hebergements_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reservation_hebergements_hebergement` FOREIGN KEY (`hebergement_id`) REFERENCES `hebergements` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `reservation_activites` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `reservation_id` INT NOT NULL,
  `activite_id` INT NOT NULL,
  `activity_date` DATE DEFAULT NULL,
  `nb_participants` INT NOT NULL DEFAULT 1,
  `price_total` DECIMAL(10,2) NOT NULL DEFAULT 0,
  CONSTRAINT `fk_reservation_activites_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reservation_activites_activite` FOREIGN KEY (`activite_id`) REFERENCES `activites` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `read_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
