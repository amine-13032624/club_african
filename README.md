<<<<<<< HEAD
# Club Sportif - Système de Gestion

Une plateforme web complète pour la gestion d'un club sportif, permettant de gérer les membres, les entraînements, les paiements et les statistiques.

## Fonctionnalités

### Gestion des Membres
- ✅ Ajouter/modifier/supprimer des membres
- ✅ Gérer les athlètes, entraîneurs et staff
- ✅ Visualiser les profils détaillés
- ✅ Catégories et niveaux de compétence

### Gestion des Entraînements
- ✅ Planifier les entraînements
- ✅ Assigner les entraîneurs et équipes
- ✅ Gérer le calendrier des séances
- ✅ Types d'entraînement (collectif, individuel, groupe)

### Gestion des Paiements
- ✅ Enregistrer les paiements des membres
- ✅ Suivre l'état des cotisations
- ✅ Gérer les méthodes de paiement
- ✅ Statistiques des paiements

### Tableau de Bord
- ✅ Vue d'ensemble des statistiques
- ✅ Graphiques et métriques
- ✅ Alertes et notifications
- ✅ Prévisions et tendances

## Installation

### Prérequis
- PHP 7.4+
- MySQL 5.7+
- Apache (XAMPP)

### Étapes d'installation

1. **Cloner/télécharger le projet**
```bash
cd c:\xampp\htdocs\club-sportif
```

2. **Configurer la base de données**
   - Modifier `config/database.php` si nécessaire
   - Importer le schéma: `database/club_sportif.sql`

3. **Démarrer XAMPP**
   - Apache
   - MySQL

4. **Accéder l'application**
   - URL: `http://localhost/club-sportif/`

## Configuration

### Fichier config/database.php
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'club_sportif');
```

### Identifiants par défaut
- **Email**: admin@clubsportif.com
- **Mot de passe**: admin123

> ⚠️ À modifier en production!

## Structure du Projet

```
club-sportif/
├── config/
│   └── database.php          # Configuration de la base de données
├── controllers/
│   ├── DashboardController.php
│   ├── MembreController.php
│   ├── EntrainementController.php
│   └── PaiementController.php
├── models/
│   ├── Membre.php            # Classe abstraite
│   ├── Athelete.php
│   ├── Entraineur.php
│   ├── Staff.php
│   ├── Entrainement.php
│   ├── Paiement.php
│   ├── Equipe.php
│   ├── Competition.php
│   ├── Performance.php
│   ├── Club.php
│   ├── Abonnement.php
│   ├── Sponsor.php
│   └── Contrat.php
├── views/
│   ├── header.php
│   ├── footer.php
│   ├── membres/
│   │   ├── liste.php
│   │   ├── ajouter.php
│   │   ├── editer.php
│   │   ├── supprimer.php
│   │   └── profil.php
│   ├── entrainements/
│   │   ├── planning.php
│   │   ├── ajouter.php
│   │   ├── editer.php
│   │   └── supprimer.php
│   ├── paiements/
│   │   ├── liste.php
│   │   ├── ajouter.php
│   │   ├── editer.php
│   │   └── supprimer.php
│   └── statistiques/
│       └── dashboard.php
├── css/
│   └── style.css            # Feuille de style responsive
├── js/
│   └── script.js            # JavaScript utilitaire
├── database/
│   └── club_sportif.sql     # Schéma de la base de données
├── index.php                # Page d'accueil
└── login.php                # Page de connexion
```

## Pages et Fonctionnalités

### Authentification
- `login.php` - Formulaire de connexion
- `logout.php` - Déconnexion

### Accueil
- `index.php` - Tableau de bord principal

### Gestion des Membres
- `views/membres/liste.php` - Liste complète des membres
- `views/membres/ajouter.php` - Créer un nouveau membre (athlète/entraîneur/staff)
- `views/membres/editer.php` - Modifier un membre
- `views/membres/supprimer.php` - Supprimer un membre
- `views/membres/profil.php` - Voir le profil complet

### Gestion des Entraînements
- `views/entrainements/planning.php` - Vue du planning
- `views/entrainements/ajouter.php` - Créer un entraînement
- `views/entrainements/editer.php` - Modifier un entraînement
- `views/entrainements/supprimer.php` - Supprimer un entraînement

### Gestion des Paiements
- `views/paiements/liste.php` - Liste des paiements avec statistiques
- `views/paiements/ajouter.php` - Enregistrer un paiement
- `views/paiements/editer.php` - Modifier un paiement
- `views/paiements/supprimer.php` - Supprimer un paiement

### Statistiques
- `views/statistiques/dashboard.php` - Analyses et rapports

## Modèles de Données

### Classe Membre (abstraite)
- Propriétés de base: nom, prénom, email, téléphone, date de naissance
- Catégories: Athlète, Entraîneur, Staff
- Héritées: Athelete, Entraineur, Staff

### Athlète
- Numéro de licence
- Équipe assignée
- Taille, poids, position
- Historique de performances

### Entraîneur
- Spécialité
- Diplôme
- Années d'expérience
- Équipe assignée

### Staff
- Fonction (directeur, médecin, kinésithérapeute, etc.)
- Département
- Date d'embauche

### Entraînement
- Date et heure
- Type (collectif, individuel, groupe)
- Niveau (débutant, intermédiaire, avancé)
- Lieu
- Entraîneur assigné
- Équipe(s) concernées

### Paiement
- Membre
- Montant
- Méthode (espèces, chèque, carte, virement)
- Statut (en attente, confirmé, annulé)
- Date

## API et Contrôleurs

### DashboardController
```php
getDashboardStats()              // Récupère les statistiques clés
getStatistiquesCategories()      // Stats par catégorie
getStatistiquesNiveaux()         // Stats par niveau
getComingCompetitions()          // Compétitions à venir
```

### MembreController
```php
ajouterAthlete($data)            // Ajouter un athlète
ajouterEntraineur($data)         // Ajouter un entraîneur
ajouterStaff($data)              // Ajouter un staff
getTousMembres()                 // Liste complète
getMembreById($id)               // Détail d'un membre
getTousAthletes()                // Tous les athlètes
getTousEntraineurs()             // Tous les entraîneurs
getTousStaff()                   // Tout le staff
modifierMembre($id, $data)       // Mettre à jour
supprimerMembre($id)             // Supprimer
getProfilAthlete($id)            // Profil détaillé
```

### EntrainementController
```php
ajouter($data)                   // Créer un entraînement
modifier($id, $data)             // Mettre à jour
supprimer($id)                   // Supprimer
getAll()                         // Tous les entraînements
getById($id)                     // Détail
getEntrainementsSemaine()        // De la semaine
getByEntraineur($id)             // Par entraîneur
getByEquipe($id)                 // Par équipe
getByDate($date)                 // Par date
getPlanning($mois, $annee)       // Calendrier mensuel
getToutesEquipes()               // Toutes les équipes
getTousEntraineurs()             // Tous les entraîneurs
ajouterEquipe($data)             // Créer équipe
```

### PaiementController
```php
ajouter($data)                   // Enregistrer un paiement
getAll()                         // Tous les paiements
getByMembre($id)                 // Par membre
getPaiementsAttente()            // En attente
getTotalPaiements()              // Montant total
getTotalParMethode()             // Par méthode
getStatistiquessPaiements()      // Statistiques complètes
```

## Base de Données

### Tables principales
- `membre` - Base de tous les membres
- `athlete` - Données spécifiques aux athlètes
- `entraineur` - Données spécifiques aux entraîneurs
- `staff` - Données du personnel administratif
- `entrainement` - Sessions d'entraînement
- `paiement` - Transactions de paiement
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
