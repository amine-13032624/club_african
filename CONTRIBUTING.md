# Contribution Guide - Club Sportif

## Bienvenue! 👋

Merci de votre intérêt pour contribuer au projet Club Sportif. Ce guide vous aidera à démarrer.

## Code of Conduct

Veuillez respecter les autres contributeurs et suivre notre code de conduite:
- Soyez respectueux
- Acceptez les critiques constructives
- Focalisez-vous sur ce qui est bon pour la communauté

## Comment Contribuer

### Signaler un Bug

1. Vérifiez que le bug n'a pas déjà été signalé
2. Décrivez le bug clairement
3. Fournissez des étapes pour reproduire
4. Incluez des détails du système

### Proposer une Amélioration

1. Vérifiez que l'idée n'existe pas déjà
2. Décrivez l'amélioration en détail
3. Expliquez pourquoi c'est utile
4. Fournissez des exemples si possible

### Soumettre du Code

1. **Fork** le projet
2. **Branch** pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. **Commit** vos changements (`git commit -m 'Add some AmazingFeature'`)
4. **Push** vers la branche (`git push origin feature/AmazingFeature`)
5. **Pull Request** avec une description claire

## Standards de Code

### PHP
```php
<?php
// Utiliser des espaces de 4 pour l'indentation
class MaClasse {
    private $propriete;
    
    public function maMethode() {
        // Code ici
    }
}
?>
```

### HTML/CSS
```html
<!-- Utiliser 2 espaces pour l'indentation -->
<div class="container">
  <p>Contenu</p>
</div>
```

```css
/* Utiliser des variables CSS */
.element {
    color: var(--primary-color);
    padding: var(--spacing-unit);
}
```

### JavaScript
```javascript
// Utiliser camelCase pour les variables
let maVariable = 'valeur';

// Ajouter des commentaires
function maFonction() {
    // Faire quelque chose
}
```

## Structure du Projet

```
club-sportif/
├── config/          ← Configuration
├── models/          ← Classes métier
├── controllers/     ← Logique applicative
├── views/           ← Templates HTML
├── css/             ← Feuilles de style
├── js/              ← JavaScript
├── database/        ← Schéma SQL
└── helpers.php      ← Fonctions utilitaires
```

## Processus de Développement

### 1. Préparation
```bash
# Cloner le repo
git clone https://github.com/club-sportif/repo.git
cd club-sportif

# Créer une branche
git checkout -b feature/ma-feature
```

### 2. Développement
- Suivre les standards de code
- Ajouter des commentaires où nécessaire
- Tester votre code régulièrement

### 3. Testing
```bash
# Vérifier la syntaxe
php -l file.php

# Vérifier la configuration
http://localhost/club-sportif/check.php
```

### 4. Documentation
- Mettre à jour README.md si nécessaire
- Ajouter des commentaires de code
- Documenter les changements importants

### 5. Commit
```bash
# Messages de commit clairs
git commit -m 'Ajouter feature X'

# Atomiques et logiques
git commit -m 'Fix bug Y'
```

## Bonnes Pratiques

### Nommage
- **Variables**: `$maVariable` (camelCase)
- **Constantes**: `CONSTANTE` (UPPERCASE)
- **Classes**: `MaClasse` (PascalCase)
- **Fonctions**: `maFonction()` (camelCase)

### Sécurité
- Valider toutes les entrées
- Utiliser des requêtes préparées
- Échapper les sorties HTML
- Vérifier les authentifications

### Performance
- Éviter les boucles inutiles
- Cacher les données statiques
- Optimiser les requêtes SQL
- Minifier CSS/JS en production

### Documentation
```php
/**
 * Description courte
 * 
 * Description longue si nécessaire
 * 
 * @param string $param Description du paramètre
 * @return type Description du retour
 */
public function maMethode($param) {
    // Code
}
```

## Types de Contributions

### 🐛 Bug Fixes
Corrigez les bugs existants
- Branche: `fix/description`
- Référencez l'issue
- Incluez un test si possible

### ✨ Features
Ajoutez des nouvelles fonctionnalités
- Branche: `feature/description`
- Documentez bien
- Testez complètement

### 📚 Documentation
Améliorez la documentation
- Branche: `docs/description`
- Soyez clair et complet
- Incluez des exemples

### 🔧 Refactoring
Nettoyez et améliorez le code
- Branche: `refactor/description`
- Gardez la fonctionnalité
- Testez après

### 📊 Tests
Ajoutez des tests
- Branche: `test/description`
- Couvrez les cas importants
- Documentez les tests

## Pull Request Process

1. **Description claire** du changement
2. **Références** aux issues liées
3. **Screenshots** si applicable
4. **Test** complètement votre code
5. **Mise à jour** de la documentation
6. **Respecter** les standards de code

### Template PR
```markdown
## Description
Description brève du changement

## Type de Changement
- [ ] Bug fix
- [ ] Nouvelle feature
- [ ] Breaking change
- [ ] Documentation

## Comment tester
1. Étape 1
2. Étape 2

## Screenshots (si applicable)
[Ajouter screenshots]

## Checklist
- [ ] Mon code suit les standards du projet
- [ ] J'ai documenté les changements
- [ ] J'ai testé la fonctionnalité
- [ ] Aucune erreur PHP/JS
```

## Environnement de Développement

### Configuration
```php
// config/database.php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'club_sportif_dev');
```

### Tools
- PHP 7.4+
- MySQL 5.7+
- XAMPP
- Git
- Un éditeur (VS Code, PHPStorm, etc.)

## Aide et Support

### Questions?
- 📖 Consultez la documentation
- 💬 Ouvert les issues pour les questions
- 🤝 Demandez à la communauté

### Ressources
- [Documentation PHP](https://www.php.net/manual/fr/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Git Guide](https://git-scm.com/)

## Reconnaissance

Tout contributeur sera reconnu:
- Listé dans le fichier CONTRIBUTORS.md
- Mentionné dans le CHANGELOG.md
- Crédité dans le footer du site

## License

En contribuant, vous acceptez que votre code soit sous la même licence que le projet (Propriétaire - Club Sportif).

## Questions Fréquentes

**Q: Comment commencer?**
A: Lisez ce guide et consultez le QUICKSTART.md

**Q: Puis-je ajouter ma propre feature?**
A: Oui! Suivez le processus de contribution.

**Q: Comment rapporter un bug?**
A: Créez une issue avec les détails.

**Q: Combien de temps avant que ma PR soit revue?**
A: Généralement dans les 48-72 heures.

---

**Merci d'avoir contribué! 🙏**

Pour plus d'informations: admin@clubsportif.com
