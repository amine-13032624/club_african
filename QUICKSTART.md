# Guide de Démarrage Rapide - Club Sportif

## ⚡ Installation en 5 minutes

### 1. Prérequis
- XAMPP (avec Apache + MySQL + PHP)
- Navigateur web moderne

### 2. Installation

#### Étape 1: Télécharger le projet
```bash
# Le projet est déjà dans:
c:\xampp\htdocs\club-sportif
```

#### Étape 2: Démarrer XAMPP
1. Ouvrir XAMPP Control Panel
2. Cliquer sur "Start" pour Apache
3. Cliquer sur "Start" pour MySQL

#### Étape 3: Initialiser la base de données
1. Ouvrir votre navigateur
2. Aller à: `http://localhost/club-sportif/check.php`
3. Vérifier que tout est ✓ (vert)
4. Cliquer sur "Installer"

#### Étape 4: Se connecter
1. Aller à: `http://localhost/club-sportif/`
2. Vous serez redirigé vers la page de connexion
3. Utiliser les identifiants:
   - **Email**: admin@clubsportif.com
   - **Mot de passe**: admin123

### 3. Premiers pas

#### Ajouter des membres
1. Cliquer sur "Membres" dans le menu
2. Cliquer sur "Ajouter un Membre"
3. Choisir le type (Athlète/Entraîneur/Staff)
4. Remplir les informations
5. Cliquer "Ajouter"

#### Planifier un entraînement
1. Cliquer sur "Entraînements"
2. Cliquer sur "Ajouter un Entraînement"
3. Définir la date, l'heure et le lieu
4. Assigner un entraîneur et une équipe
5. Cliquer "Enregistrer"

#### Enregistrer un paiement
1. Cliquer sur "Paiements"
2. Cliquer sur "Ajouter un Paiement"
3. Sélectionner le membre
4. Entrer le montant
5. Cliquer "Ajouter"

### 4. Personnalisation

#### Changer le nom du club
Modifier `config/club.php`:
```php
'nom' => 'Mon Club Sportif',
```

#### Changer les couleurs
Modifier `css/style.css`:
```css
:root {
    --primary-color: #3498db;      /* Votre couleur */
    --secondary-color: #2c3e50;
}
```

#### Changer l'email administrateur
Modifier dans `login.php`:
```php
if ($email === 'mon-email@exemple.com' && $password === 'mon-mdp') {
```

### 5. Accès aux pages principales

| Page | URL |
|------|-----|
| Accueil | `http://localhost/club-sportif/` |
| Connexion | `http://localhost/club-sportif/login.php` |
| Membres | `http://localhost/club-sportif/views/membres/liste.php` |
| Entraînements | `http://localhost/club-sportif/views/entrainements/planning.php` |
| Paiements | `http://localhost/club-sportif/views/paiements/liste.php` |
| Statistiques | `http://localhost/club-sportif/views/statistiques/dashboard.php` |
| Vérification | `http://localhost/club-sportif/check.php` |

### 6. Troubleshooting

#### "Erreur de connexion à la base de données"
1. Vérifier que MySQL est démarré
2. Vérifier les identifiants dans `config/database.php`
3. Aller à `http://localhost/phpmyadmin` pour vérifier

#### "Erreur 404"
1. Vérifier que le fichier existe
2. Vérifier le chemin de l'URL
3. Recharger la page (F5)

#### "Problème de session"
1. Vider le cache du navigateur (Ctrl+Maj+Suppr)
2. Se déconnecter et reconnecter
3. Vérifier les cookies activés

### 7. Sauvegarde de la base de données

#### Via PHPMyAdmin
1. Aller à `http://localhost/phpmyadmin`
2. Cliquer sur la base `club_sportif`
3. Cliquer sur "Exporter"
4. Cliquer "Exécuter"

#### Via ligne de commande
```bash
mysqldump -u root club_sportif > backup.sql
```

### 8. Restauration de la base de données

#### Via PHPMyAdmin
1. Aller à `http://localhost/phpmyadmin`
2. Cliquer sur la base `club_sportif`
3. Cliquer sur "Importer"
4. Sélectionner le fichier SQL
5. Cliquer "Exécuter"

#### Via ligne de commande
```bash
mysql -u root club_sportif < backup.sql
```

### 9. Structure des fichiers importants

```
📁 club-sportif/
├─ 📄 index.php              ← Page d'accueil
├─ 📄 login.php              ← Connexion
├─ 📄 check.php              ← Vérification d'environnement
├─ 📄 install.php            ← Installation de la BDD
├─ 📄 helpers.php            ← Fonctions utilitaires
├─ 📄 README.md              ← Documentation complète
├─ 📄 QUICKSTART.md          ← Ce fichier
├─ 📁 config/                ← Configuration
│  ├─ database.php
│  ├─ constants.php
│  └─ club.php
├─ 📁 models/                ← Logique métier
├─ 📁 controllers/           ← Contrôleurs
├─ 📁 views/                 ← Affichage
├─ 📁 css/                   ← Styles
├─ 📁 js/                    ← JavaScript
└─ 📁 database/              ← Schéma SQL
```

### 10. Besoin d'aide?

- 📖 Consulter `README.md` pour la documentation complète
- 🔧 Vérifier `check.php` pour l'état du système
- 💻 Ouvrir la console du navigateur (F12) pour les erreurs JS
- 📝 Vérifier les fichiers de log PHP

---

**Bon développement! 🚀**

Contacter: admin@clubsportif.com
