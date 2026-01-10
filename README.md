# TD1 : Utilisation de Doctrine ORM

> Projet réalisé dans le cadre du TD1 - Nouveaux Paradigmes de Base de Données  
> IUT Charlemagne - Université de Lorraine

- Réalisé par : **[HERRMANN Vivien](https://github.com/Vivienhrm)**

![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white)
![Doctrine](https://img.shields.io/badge/Doctrine-3.3-FF6A56?style=flat-square&logo=doctrine&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-4169E1?style=flat-square&logo=postgresql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white)

## Présentation
Ce projet est une implémentation pratique de la gestion de données avec l'ORM **Doctrine 3**. Il illustre le mapping objet-relationnel, la gestion de relations complexes et l'utilisation de requêtes DQL dans un environnement Dockerisé avec PostgreSQL.

## Configuration et exécution

### Prérequis
- Docker et Docker Compose installés
- PHP 8.3+ (si exécution hors Docker)

### Étape 1 : Configuration de l'environnement
1. Copiez le fichier d'environnement :
   ```bash
   cp prat.env.dist prat.env
   ```

2. Éditez `prat.env` et définissez le mot de passe PostgreSQL :
   ```
   POSTGRES_PASSWORD=votre_mot_de_passe
   ```

### Étape 2 : Lancement des services
```bash
# Démarrer PostgreSQL et PHP
docker-compose up -d praticien.db prati.app

# Ou démarrer tous les services (incluant Adminer pour l'administration DB)
docker-compose up -d
```

### Étape 3 : Initialisation de la base de données
```bash
# Importation du schéma et des données (si non automatique par volume)
docker-compose exec -T praticien.db psql -U prati -d prati -f /var/sql/prati.schema.sql
docker-compose exec -T praticien.db psql -U prati -d prati -f /var/sql/prati.data.sql
```

### Étape 4 : Exécution des exercices
```bash
# Exécuter le script de démonstration TD1
docker-compose exec prati.app php public/td1.php
```


### Services disponibles
- **Interface Web** : [http://localhost:3080](http://localhost:3080)
- **Base de données (PostgreSQL)** : `localhost:5432`
- **Adminer (Gestion DB)** : [http://localhost:8085](http://localhost:8085)


### Structure du projet
- `src/Entity/` : Classes d'entités Doctrine
- `src/Repository/` : Classes de repository avec requêtes DQL
- `public/td1.php` : Script d'exécution des exercices
- `sql/` : Scripts SQL de schéma et données
- `bootstrap.php` : Configuration Doctrine

### Exercices implémentés
1. **Exercice 1** : Utilisation élémentaire (CRUD)
2. **Exercice 2** : Requêtes avec conditions
3. **Exercice 3** : Repository et DQL

Le script `public/td1.php` exécute automatiquement tous les exercices et affiche les résultats.

---
Pour un compte-rendu détaillé de l'implémentation et des choix techniques, consultez le fichier [COMPTE_RENDU.md](COMPTE_RENDU.md).
