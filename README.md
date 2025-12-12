# Club Sportif — Gestion de club

Application PHP pour gérer un club sportif: membres (athlètes, entraîneurs, staff), équipes, entraînements, paiements et statistiques.

## Prérequis

- `PHP 8.1+` (fonctionne aussi sur `PHP 8.2`)
- `MySQL/MariaDB` (XAMPP recommandé)
- `Apache` ou serveur PHP intégré

## Installation rapide

- Cloner le projet dans `c:\xampp\htdocs\club_african`
- Créer la base `club_sportif` et importer `database/club_sportif.sql`
- Démarrer `Apache` et `MySQL` via XAMPP
- Ouvrir `http://localhost/club_african/public/login.php`

Identifiants de démo:
- Email: `admin@clubsportif.com`
- Mot de passe: `admin123`

## Démarrage (2 options)

- Apache (XAMPP): placer le dossier dans `htdocs` et accéder à `http://localhost/club_african/`
- Serveur PHP intégré: `php -S localhost:8000 -t .` puis `http://localhost:8000/public/login.php`

## Structure

```
club_african/
├── api/                      API JSON (POST)
│   ├── membre/               ajouter|modifier|supprimer
│   ├── equipe/               ajouter|modifier|supprimer
│   ├── entrainement/         ajouter|modifier|supprimer
│   ├── paiement/             ajouter|modifier|supprimer
│   ├── competition/          ajouter|modifier|supprimer
│   └── ...                   autres ressources
├── database/
│   └── club_sportif.sql      schéma complet
├── public/                   interface utilisateur
│   ├── css/style.css         styles
│   ├── js/script.js          scripts
│   ├── images/               assets
│   ├── views/                pages incluses par `public/index.php`
│   │   ├── membres/          liste, ajouter, editer, supprimer, profil
│   │   ├── entrainements/    planning, ajouter, editer, supprimer
│   │   ├── paiements/        liste, ajouter, editer, supprimer
│   │   ├── equipes/          liste, ajouter, editer, profil, supprimer
│   │   ├── statistiques/     dashboard
│   │   ├── header.php        navigation
│   │   └── footer.php        pied de page
│   ├── index.php             routeur des vues
│   ├── login.php             authentification (démo)
│   ├── logout.php            déconnexion
│   └── .htaccess             réécriture URL (Apache)
├── src/
│   ├── config/database.php   connexion PDO
│   ├── controllers/          logique applicative
│   │   ├── DashboardController.php
│   │   ├── MembreController.php
│   │   ├── EntrainementController.php
│   │   ├── PaiementController.php
│   │   └── EquipeController.php
│   └── models/               modèles de données
│       ├── Membre.php (abstrait)
│       ├── Athlete.php | Entraineur.php | Staff.php
│       ├── Equipe.php | Entrainement.php | Paiement.php
│       ├── Competition.php | Performance.php
│       ├── Sponsor.php | Contrat.php | Abonnement.php | Club.php
├── .htaccess                 sécurité/cache (Apache)
├── index.php                 charge `public/index.php`
├── .gitignore
└── LICENSE
```

## Configuration base de données

`src/config/database.php` utilise `PDO`:

- Hôte: `127.0.0.1`
- Base: `club_sportif`
- Utilisateur: `root`
- Mot de passe: vide par défaut sous XAMPP

Adapter ces valeurs selon votre environnement.

## Utilisation de l’API

- Format: `POST` JSON vers `api/<ressource>/<action>.php`
- Exemple ajout équipe:
```
POST http://localhost/club_african/api/equipe/ajouter.php
{
  "nom": "Aigles",
  "sport": "Football",
  "discipline": "Seniors",
  "nombre_joueurs": 20
}
```

## Notes

- Les pages retournent des valeurs par défaut si la base est indisponible (pas de fatal error).
- Pour servir uniquement `public/` comme racine via PHP intégré, utiliser `php -S localhost:8000 -t public` et ajuster les URLs si nécessaire.
- `equipe` - Équipes/groupes
- `competition` - Compétitions/matchs
- `performance` - Statistiques de performance
- `abonnement` - Adhésions actives
- `club` - Informations du club
- `sponsor` - Partenaires/sponsors
- `contrat` - Contrats avec sponsors

## Sécurité

### Améliorations à apporter
- [ ] Hash des mots de passe avec `password_hash()`
- [ ] Protection CSRF sur les formulaires
- [ ] Validation et sanitization des entrées
- [ ] Logs d'audit pour les opérations sensibles
- [ ] Authentification à deux facteurs
- [ ] Rate limiting sur la connexion
- [ ] Chiffrement des données sensibles

### Bonnes pratiques implémentées
- ✅ Requêtes préparées (PDO)
- ✅ Sessions sécurisées
- ✅ Validation HTML (required, type, etc.)
- ✅ Messages d'erreur génériques

## Utilisation

### Ajouter un Membre
1. Aller à "Membres" > "Ajouter un Membre"
2. Sélectionner le type (Athlète/Entraîneur/Staff)
3. Remplir les informations
4. Cliquer "Ajouter"

### Planifier un Entraînement
1. Aller à "Entraînements" > "Planifier"
2. Cliquer "Ajouter un Entraînement"
3. Définir date, heure, lieu, équipe
4. Assigner un entraîneur
5. Cliquer "Enregistrer"

### Enregistrer un Paiement
1. Aller à "Paiements"
2. Cliquer "Ajouter un Paiement"
3. Sélectionner le membre
4. Entrer le montant et la méthode
5. Cliquer "Ajouter"

## Customisation

### Modifier les couleurs
Éditer `css/style.css` - section "CSS Variables":
```css
:root {
    --primary-color: #3498db;      /* Bleu */
    --secondary-color: #2c3e50;    /* Gris foncé */
    --success-color: #27ae60;      /* Vert */
    --danger-color: #e74c3c;       /* Rouge */
    --warning-color: #f39c12;      /* Orange */
}
```

### Ajouter des champs
1. Ajouter la colonne à la table MySQL
2. Mettre à jour le modèle correspondant
3. Ajouter le champ au formulaire de la vue
4. Mettre à jour le contrôleur

## Support et Maintenance

### Sauvegarde de la Base de Données
```bash
mysqldump -u root club_sportif > backup.sql
```

### Restauration
```bash
mysql -u root club_sportif < backup.sql
```

### Logs
Les erreurs sont enregistrées dans:
- PHP: `php_errors.log` (serveur)
- Navigateur: Console du navigateur (F12)

## Développement Futur

- [ ] Module de gestion de ressources
- [ ] Système de notation et évaluation
- [ ] Intégration avec calendrier externe
- [ ] App mobile
- [ ] Notifications par email/SMS
- [ ] Rapports avancés en PDF
- [ ] Graphiques analytiques
- [ ] Système de réservations

## Licence

Propriétaire - Club Sportif

## Auteur

Développé pour l'administration du Club Sportif

---

**Version**: 1.0.0  
**Date**: 2024  
**Support**: admin@clubsportif.com
=======
# club-sportif
c'est une application web en LARAVEL  de gestion de club sportif
>>>>>>> ddb5270dba721bae8e35aa4bdc2c9dff5ac31bb6
