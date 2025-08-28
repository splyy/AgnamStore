# AgnamStore 🎌

## À propos du projet

AgnamStore est un projet de cours réalisé dans le cadre d'un exercice académique où il fallait développer un site web en PHP utilisant le framework Silex. Nous avons choisi de créer un site e-commerce sur la thèmatique de la Japanimation, proposant des mangas et animés à la vente.

Ce projet illustre une implémentation complète d'une boutique en ligne avec :
- Création d'un projet sous Silex
- Gestion des utilisateurs et authentification
- Catalogue de produits (mangas, animés, figurines, livres)
- Panier d'achat et processus de commande
- Intégration PayPal pour les paiements
- Interface d'administration

## Installation et lancement

### Démarrage rapide

1. **Cloner le projet**
   ```bash
   git clone <url-du-repo>
   cd AgnamStore
   ```

2. **Lancer l'application avec Docker**
   ```bash
   # Avec Make (recommandé)
   make up
   
   # Ou via docker-compose
   docker-compose up -d
   ```

3. **Installer les dépendances PHP**
   ```bash
   # Avec Make
   make install
   
   # Ou via docker-compose
   docker-compose exec web composer install
   ```

4. **Accéder à l'application**
   - Site web : http://localhost:8080
   - PhpMyAdmin : http://localhost:8081 (root/root)

### Commandes utiles

```bash
# Voir les logs
make logs

# Redémarrer les services
make restart

# Accéder au shell du conteneur web
make shell

# Encoder un mot de passe
make encode-password PWD=monMotDePasse

# Arrêter l'application
make down

# Reset complet
make reset
```

## Architecture technique

- **Framework** : Silex 1.2 (microframework PHP basé sur Symfony)
- **Base de données** : MySQL 5.6
- **Front-end** : Bootstrap, jQuery
- **Template** : Twig

## Structure du projet

- `app/` - Configuration de l'application et routes
- `src/AgnamStore/` - Code source principal (MVC)
  - `Controller/` - Contrôleurs
  - `DAO/` - Accès aux données
  - `Domain/` - Entités métier
  - `Form/` - Formulaires Symfony
  - `Payment/` - Intégration PayPal
- `db/` - Scripts SQL de création de la base
- `views/` - Templates Twig
- `web/` - Assets publics (CSS, JS, images)
- `tests/` - Tests unitaires PHPUnit

## Base de données

La base de données est automatiquement initialisée au premier lancement grâce aux scripts SQL dans le dossier `db/` :
- `01_crt_base.sql` - Création de la base
- `02_crt_tables.sql` - Structure des tables
- `03_crt_constraints.sql` - Contraintes
- `04_crt_insert.sql` - Données de test

