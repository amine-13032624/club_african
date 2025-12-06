<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation - Club Sportif</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .docs-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .docs-header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 30px;
        }
        
        .docs-header h1 {
            color: #2c3e50;
            margin: 0 0 10px 0;
        }
        
        .docs-header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }
        
        .docs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .doc-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            border-left: 4px solid #3498db;
        }
        
        .doc-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .doc-card.getting-started {
            border-left-color: #27ae60;
        }
        
        .doc-card.api {
            border-left-color: #3498db;
        }
        
        .doc-card.development {
            border-left-color: #f39c12;
        }
        
        .doc-card.legal {
            border-left-color: #e74c3c;
        }
        
        .doc-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .doc-icon.getting-started { color: #27ae60; }
        .doc-icon.api { color: #3498db; }
        .doc-icon.development { color: #f39c12; }
        .doc-icon.legal { color: #e74c3c; }
        
        .doc-card h3 {
            color: #2c3e50;
            margin: 10px 0;
        }
        
        .doc-card p {
            color: #7f8c8d;
            font-size: 0.95rem;
            margin: 10px 0;
            line-height: 1.6;
        }
        
        .doc-link {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        .doc-link:hover {
            background: #2980b9;
        }
        
        .section-title {
            color: #2c3e50;
            margin: 30px 0 20px 0;
            font-size: 1.3rem;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }
        
        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .quick-link {
            padding: 15px;
            background: white;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            color: #3498db;
            border: 1px solid #ecf0f1;
            transition: all 0.3s;
        }
        
        .quick-link:hover {
            color: #2980b9;
            border-color: #3498db;
        }
        
        .status-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .status-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 15px;
            border-radius: 20px;
            margin: 5px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <?php include 'views/header.php'; ?>
    
    <div class="container docs-container">
        <div class="docs-header">
            <h1><i class="fas fa-book"></i> Documentation Club Sportif</h1>
            <p>Ressources et guides complets pour l'utilisation et le développement</p>
        </div>
        
        <!-- Status Banner -->
        <div class="status-banner">
            <h3>✓ Application en Production</h3>
            <div>
                <span class="status-badge">v1.0.0</span>
                <span class="status-badge">PHP 7.4+</span>
                <span class="status-badge">MySQL 5.7+</span>
                <span class="status-badge">Documentation Complète</span>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="section-title">Accès Rapide</div>
        <div class="quick-links">
            <a href="<?php echo isset($_SESSION['user_id']) ? 'index.php' : 'login.php'; ?>" class="quick-link">
                <i class="fas fa-home"></i><br>Accueil
            </a>
            <a href="check.php" class="quick-link">
                <i class="fas fa-cog"></i><br>Vérification
            </a>
            <a href="status.php" class="quick-link">
                <i class="fas fa-heartbeat"></i><br>État du Système
            </a>
            <a href="install.php" class="quick-link">
                <i class="fas fa-download"></i><br>Installation
            </a>
        </div>
        
        <!-- Documentation Grid -->
        <div class="section-title">Documentation</div>
        <div class="docs-grid">
            <!-- Getting Started -->
            <div class="doc-card getting-started">
                <div class="doc-icon getting-started">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3>Guide de Démarrage</h3>
                <p>Tout ce qu'il faut savoir pour commencer à utiliser l'application.</p>
                <a href="QUICKSTART.md" class="doc-link">Consulter</a>
            </div>
            
            <!-- Full Documentation -->
            <div class="doc-card api">
                <div class="doc-icon api">
                    <i class="fas fa-book"></i>
                </div>
                <h3>Documentation Complète</h3>
                <p>Guide exhaustif avec toutes les fonctionnalités, API et configurations.</p>
                <a href="README.md" class="doc-link">Consulter</a>
            </div>
            
            <!-- Development -->
            <div class="doc-card development">
                <div class="doc-icon development">
                    <i class="fas fa-code"></i>
                </div>
                <h3>Guide de Contribution</h3>
                <p>Comment contribuer au projet, standards de code et processus.</p>
                <a href="CONTRIBUTING.md" class="doc-link">Consulter</a>
            </div>
            
            <!-- Changelog -->
            <div class="doc-card development">
                <div class="doc-icon development">
                    <i class="fas fa-history"></i>
                </div>
                <h3>Historique des Versions</h3>
                <p>Suivi des changements et améliorations dans chaque version.</p>
                <a href="CHANGELOG.md" class="doc-link">Consulter</a>
            </div>
            
            <!-- Project Info -->
            <div class="doc-card api">
                <div class="doc-icon api">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h3>Informations du Projet</h3>
                <p>Vue d'ensemble du projet, architecture et statistiques.</p>
                <a href="PROJECT_INFO.md" class="doc-link">Consulter</a>
            </div>
            
            <!-- License -->
            <div class="doc-card legal">
                <div class="doc-icon legal">
                    <i class="fas fa-gavel"></i>
                </div>
                <h3>Conditions d'Utilisation</h3>
                <p>Licence propriétaire et conditions d'utilisation du logiciel.</p>
                <a href="LICENSE" class="doc-link">Consulter</a>
            </div>
        </div>
        
        <!-- Detailed Sections -->
        <div class="section-title">Guides Détaillés</div>
        
        <div class="doc-card" style="border-left-color: #3498db; margin-bottom: 20px;">
            <h3><i class="fas fa-users"></i> Gestion des Membres</h3>
            <p><strong>Ajouter un membre:</strong> Membres → Ajouter un Membre → Remplir le formulaire → Valider</p>
            <p><strong>Types de membres:</strong> Athlètes, Entraîneurs, Staff avec champs spécifiques</p>
            <p><strong>Édition/Suppression:</strong> Cliquer sur l'action dans la liste des membres</p>
        </div>
        
        <div class="doc-card" style="border-left-color: #27ae60; margin-bottom: 20px;">
            <h3><i class="fas fa-calendar"></i> Planification des Entraînements</h3>
            <p><strong>Créer un entraînement:</strong> Entraînements → Ajouter → Définir date/heure/équipe</p>
            <p><strong>Types:</strong> Collectif, Individuel, Groupe</p>
            <p><strong>Vue planning:</strong> Calendrier visuel groupé par date</p>
        </div>
        
        <div class="doc-card" style="border-left-color: #f39c12; margin-bottom: 20px;">
            <h3><i class="fas fa-money-bill"></i> Gestion des Paiements</h3>
            <p><strong>Enregistrer:</strong> Paiements → Ajouter → Membre/Montant/Méthode</p>
            <p><strong>Méthodes:</strong> Espèces, Chèque, Carte bancaire, Virement</p>
            <p><strong>Suivi:</strong> Statistiques et alertes sur les paiements en attente</p>
        </div>
        
        <!-- FAQ -->
        <div class="section-title">Questions Fréquentes</div>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h4><i class="fas fa-question-circle"></i> Identifiants par défaut?</h4>
            <p>Email: <code>admin@clubsportif.com</code> | Mot de passe: <code>admin123</code></p>
        </div>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h4><i class="fas fa-question-circle"></i> Où customiser le club?</h4>
            <p>Modifiez <code>config/club.php</code> pour le nom, logo, couleurs, etc.</p>
        </div>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <h4><i class="fas fa-question-circle"></i> Comment créer une sauvegarde?</h4>
            <p>Via PHPMyAdmin: Sélectionner la base → Exporter → Télécharger le SQL</p>
        </div>
        
        <!-- Support -->
        <div class="section-title">Support et Contact</div>
        
        <div style="background: #f0f7ff; padding: 20px; border-radius: 8px; text-align: center;">
            <h4>Besoin d'aide?</h4>
            <p>
                <i class="fas fa-envelope"></i> Email: 
                <strong>admin@clubsportif.com</strong>
            </p>
            <p>
                <i class="fas fa-phone"></i> Téléphone: 
                <strong>01 23 45 67 89</strong>
            </p>
            <p>
                <i class="fas fa-map-marker"></i> Adresse: 
                <strong>123 Rue du Sport, 75000 Paris</strong>
            </p>
        </div>
        
    </div>
    
    <?php include 'views/footer.php'; ?>
</body>
</html>
