# TomTroc

Application PHP MVC de mise en relation entre lecteurs pour échanger des livres.

## Prérequis

- Docker
- Docker Compose

## Installation

1. Copier le fichier d'exemple d'environnement :

```bash
cp .env.example .env
```

2. Démarrer les conteneurs :

```bash
docker compose up -d --build
```

3. Ouvrir le site :

```text
http://localhost:8080
```

La base MariaDB est initialisée automatiquement avec `database/schema.sql` puis `database/seed.sql` au premier démarrage du volume Docker.