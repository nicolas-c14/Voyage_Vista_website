# VoyageVista - Database Setup

This guide explains how to create the database from scratch for a fresh local install.

## Requirements

- MAMP installed and running
- Apache started
- MySQL started
- phpMyAdmin available at `http://localhost:8888/phpMyAdmin/` or the MAMP URL configured on your machine

## Create the database from zero

1. Open phpMyAdmin.
2. Click `New`.
3. Create a database named `voyagevista`.
4. Choose `utf8` as collation if phpMyAdmin asks.
5. Open the new `voyagevista` database.
6. Click the `Import` tab.
7. Select the file `sql/voyagevista.sql` from this project.
8. Click `Go` / `Execute`.

## What the SQL import creates

The import file creates these tables:

- `users`
- `destinations`
- `hotels`
- `reservations`

It also adds the foreign keys and sample user data needed by the app.

## Local database connection

The app is configured to use these defaults in `config/database.php`:

- host: `localhost`
- database: `voyagevista`
- user: `root`
- password: `root`

If your local MySQL account is different, update `config/database.php`.

## Verify the setup

After the import, check that these tables exist in phpMyAdmin:

- `users`
- `destinations`
- `hotels`
- `reservations`

Then open the site and test:

- `index.php`
- `login.php`
- `admin/add-destination.php`
- `reservations/my-reservations.php`

## If the database already exists

If you already imported an older version of the database, use `sql/migrate_existing_database.sql` instead of reimporting everything.
