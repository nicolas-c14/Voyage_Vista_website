-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 30 mai 2026 à 09:44
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `voyagevista`
--

-- --------------------------------------------------------

--
-- Structure de la table `accommodations`
--

CREATE TABLE `accommodations` (
  `id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` text,
  `price_per_night` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `accommodations`
--

INSERT INTO `accommodations` (`id`, `destination_id`, `name`, `type`, `description`, `price_per_night`, `image`) VALUES
(1, 11, 'Hotel Paris Centre', 'Hôtel', 'Hôtel 4 étoiles au centre de Paris', '120.00', 'paris-hotel.jpg'),
(2, 12, 'London Bridge Rooms', 'Auberge', 'Auberge moderne proche du centre', '90.00', 'london-hotel.jpg'),
(3, 10, 'Barcelona Beach Hotel', 'Hôtel', 'Hôtel avec vue sur mer', '140.00', 'barcelona-hotel.jpg'),
(4, 11, 'Hilton Paris', 'Hôtel', 'Hôtel magnifique', '180.00', '1780063896_téléchargement.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `country` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `country`, `description`, `image`, `price`, `created_at`) VALUES
(5, 'Prague', 'République tchèque', 'Un trésor médiéval avec ses ponts gothiques, sa vieille ville charmante et ses ruelles historiques. Prague charme par son architecture féerique et son ambiance de conte.', 'Prague.jpg', '200.00', '2026-05-27 16:56:58'),
(6, 'Vienne', 'Autriche', 'Élégante et raffinée, Vienne séduit par ses palais impériaux, ses cafés traditionnels et sa musique classique. C’est une destination culturelle au charme majestueux.', 'Vienne.jpg', '225.00', '2026-05-27 16:57:43'),
(7, 'Lisbonne', 'Portugal', 'Une ville lumineuse aux ruelles pavées, tramways jaunes et miradors offrant des vues spectaculaires. Lisbonne se savoure avec ses pâtisseries, ses quartiers historiques et ses ambiances typiques.', 'Lisbonne.jpg', '230.00', '2026-05-27 16:59:52'),
(8, 'Berlin', 'Allemagne', 'Capitale dynamique et culturelle, Berlin combine histoire, street art et quartiers bohèmes. C’est une destination qui séduit par sa créativité, ses musées et son énergie moderne.', 'Berlin.jpg', '210.00', '2026-05-27 17:01:33'),
(9, 'Amsterdam', 'Pays-Bas', 'Un décor romantique de canaux, de maisons en briques et de ponts fleuris. Amsterdam offre une ambiance paisible, des musées de classe mondiale et des balades à vélo inoubliables.', 'Amsterdam.jpg', '220.00', '2026-05-27 17:02:32'),
(10, 'Barcelone', 'Espagne', 'Une ville vibrante où l’architecture de Gaudí se mêle au soleil, à la plage et à la cuisine méditerranéenne. Barcelone invite à flâner dans le quartier gothique et à profiter d’une vie nocturne animée.', 'Barcelone.jpg', '250.00', '2026-05-27 17:03:40'),
(11, 'Paris', 'France', 'La Ville Lumière, connue pour ses monuments iconiques, ses cafés élégants et son art de vivre. Paris est une destination romantique où chaque rue offre une nouvelle découverte.', 'Paris.jpg', '270.00', '2026-05-27 17:05:27'),
(12, 'Londres', 'Royaume-Uni', 'Mélange de traditions royales et de modernité urbaine, Londres propose des monuments emblématiques, des musées gratuits et des quartiers très différents à explorer.', 'londres.jpg', '260.00', '2026-05-27 17:06:12');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 'Réservation annulée', 'Votre réservation pour Barcelona Beach Hotel a été annulée.', 1, '2026-05-30 09:41:39');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accommodation_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `persons` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(50) NOT NULL DEFAULT 'confirmée',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `accommodation_id`, `check_in`, `check_out`, `persons`, `total_price`, `status`, `created_at`) VALUES
(1, 1, 3, '2026-05-31', '2026-06-04', 1, '560.00', 'cancelled', '2026-05-30 09:13:54');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','admin','agency') DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Nicolas', 'Copet', 'nicolascopet3@gmail.com', '$2y$10$BWfAPCzzlnoWhamha73AxO8jkNnRajjKX2XEkz2kLXL9tOEsNntlG', 'admin', '2026-05-25 19:20:59'),
(2, 'Pablo', 'Escobar', 'pablo.e@gmail.com', '$2y$10$DQa3JjS2flLmdtX/bx9HPOJo0rPltr.45XQpWtgvFXtOE7.7ffzgO', 'client', '2026-05-25 19:23:15'),
(3, 'Jerome', 'Pas', 'Jp@gmail.com', '$2y$10$8XqzoCvXnI8dbPdEapuk3u575UD7toyMYVcKWnZV4LkPGozP0vvGq', 'client', '2026-05-25 19:37:11'),
(4, 'Ghali', 'Benharbit', 'g6b@gmail.com', '$2y$10$AmAiHviIC7PYVNcH8TxY.OTVhy29IxrbWGhKrFMym8k3UljNwSsnO', 'admin', '2026-05-26 21:48:23'),
(6, 'Client', 'Client', 'client@test.com', '$2y$10$Du6hl49L06/Dpj3LRvtsMOmH9c26eEhUJSUpaypUWLkTiHrkVy.Cy', 'client', '2026-05-29 11:12:39'),
(7, 'Admin', 'Admin', 'admin@test.com', '$2y$10$PwGigczwiMFoEfDSW9i5z./evxDCt2lhsn.vZV67Um31Y/kStQwPq', 'admin', '2026-05-29 11:13:20'),
(8, 'Agency', 'Agency', 'agency@test.com', '$2y$10$hyLMgrieMsgu7BqvhSL/f.U.JQPfvA3.fzGRIg/b8r5fnuLU8utM.', 'agency', '2026-05-29 11:13:57');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Index pour la table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `accommodation_id` (`accommodation_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accommodations`
--
ALTER TABLE `accommodations`
  ADD CONSTRAINT `accommodations_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
