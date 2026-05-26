# VoyageVista — Démarrage rapide

Ce guide explique **le plus simplement possible** comment lancer le projet après un clone.

## 1) Prérequis

- MAMP installé (Apache + MySQL)
- PHP 8+
- Un navigateur

## 2) Cloner le projet dans `htdocs`

Place le projet dans **n’importe quel sous-dossier** de `htdocs`.

Exemples valides :

- `c:\MAMP\htdocs\Voyage_Vista_website`
- `c:\MAMP\htdocs\Web2026\Prjt_vista\Voyage_Vista_website`

## 3) Démarrer MAMP

Dans MAMP, démarre :

- Apache
- MySQL

## 4) Créer la base de données

Ouvre phpMyAdmin :

`http://localhost/phpMyAdmin`

1. Crée une base nommée **voyagevista** (utf8mb4 recommandé).
2. Importe les fichiers SQL dans cet ordre :
   1. `sql/voyagevista.sql`
   2. `sql/add_countries_to_voyagevista.sql`
   3. `sql/add_booking_tables_to_voyagevista.sql`

> Si certaines tables existent déjà, phpMyAdmin peut afficher des warnings “already exists”. Ce n’est pas bloquant si la structure est bien présente.

## 5) Vérifier la config DB

Le projet utilise `config/database.php` avec :

- DB : `voyagevista`
- User par défaut : `root`
- Mot de passe par défaut : `root`

Si besoin, change les variables MAMP ou mets des variables d’environnement :

- `DB_USER`
- `DB_PASS`

## 6) Ouvrir le projet

URL principale :

- Si le projet est directement dans `htdocs/Voyage_Vista_website` :
   `http://localhost/Voyage_Vista_website/`
- Si le projet est dans un sous-dossier (ex: `Web2026/Prjt_vista/Voyage_Vista_website`) :
   `http://localhost/Web2026/Prjt_vista/Voyage_Vista_website/`

Pages utiles :

- Accueil : `/index.php`
- Inscription : `/register.php`
- Connexion : `/login.php`
- Dashboard prestataire : `/providers/dashboard.php`
- Notifications : `/notifications.php`

## 7) Test rapide (2 minutes)

1. Crée un compte via `/register.php`.
2. Connecte-toi via `/login.php`.
3. Crée une destination via `/providers/dashboard.php`.
4. Teste une réservation via `/test_reservation.php`.
5. Vérifie les notifications via `/notifications.php`.

## Dépannage rapide

- **Erreur DB** : vérifie que MySQL tourne et que la DB s’appelle `voyagevista`.
- **Page blanche / 500** : regarde les logs PHP/MAMP.
- **Redirection étrange** : vérifie que l’URL correspond exactement au chemin réel du dossier dans `htdocs`.
