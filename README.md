# Projet Gestion des Événements (Event Manager)

Application web de gestion d'événements permettant aux utilisateurs de créer, consulter, modifier et supprimer des événements, ainsi que de s'inscrire à des événements existants.

## Technologies utilisées

### Backend
- Laravel 10
- MySQL
- Sanctum pour l'authentification JWT

### Frontend
- Angular 17
- Bootstrap 5
- FullCalendar pour l'affichage du calendrier

## Fonctionnalités

- Authentification des utilisateurs (inscription, connexion)
- Gestion des rôles (admin, utilisateur)
- Création, modification et suppression d'événements
- Affichage des événements sous forme de liste ou de calendrier
- Filtrage des événements par date, lieu ou catégorie
- Inscription et désinscription aux événements
- Tableau de bord utilisateur pour voir ses inscriptions

## Installation

### Prérequis
- PHP 8.4+
- Composer
- MySQL
- Node.js et npm
- Angular CLI

### Installation du Backend
1. Cloner le dépôt
2. Naviguer vers le dossier backend
3. Installer les dépendances : `composer install`
4. Copier le fichier `.env.example` vers `.env` et configurer la base de données
5. Générer la clé d'application : `php artisan key:generate`
6. Exécuter les migrations : `php artisan migrate`
7. Créer un utilisateur admin (via Tinker ou un seeder)
8. Lancer le serveur : `php artisan serve`

### Installation du Frontend
1. Naviguer vers le dossier frontend
2. Installer les dépendances : `npm install`
3. Lancer l'application : `ng serve`

## Utilisation

### Accès à l'application
- Backend API : http://localhost:8000
- Frontend : http://localhost:4200

### Comptes de test
- Admin : admin@example.com / password
- Utilisateur : user@example.com / password

## Documentation API

### Authentification
- `POST /api/register` : Inscription d'un nouvel utilisateur
- `POST /api/login` : Connexion d'un utilisateur
- `POST /api/logout` : Déconnexion (nécessite authentification)

### Événements
- `GET /api/events` : Liste des événements (filtres optionnels : date, location, category)
- `GET /api/events/{id}` : Détails d'un événement
- `POST /api/events` : Création d'un événement (admin uniquement)
- `PUT /api/events/{id}` : Modification d'un événement
- `DELETE /api/events/{id}` : Suppression d'un événement

### Inscriptions
- `POST /api/events/{id}/register` : Inscription à un événement
- `DELETE /api/events/{id}/register` : Annulation d'une inscription
- `GET /api/user/registrations` : Liste des inscriptions de l'utilisateur connecté
- `GET /api/events/{id}/participants` : Liste des participants à un événement

## Auteur
Kany Cisse
