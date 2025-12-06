<?php
session_start();
require_once 'config/database.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/MembreController.php';
require_once 'controllers/EntrainementController.php';
require_once 'controllers/PaiementController.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Instantiate controllers so they're available to included views
$dashboardController = new DashboardController();
$membreController = new MembreController();
$entrainementController = new EntrainementController();
$paiementController = new PaiementController();

// Déterminer la page à afficher
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Set page title
$page_title = 'Club Sportif';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Club Sportif'; ?></title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'views/header.php'; ?>
    
    <div class="container">
        <?php
        // Inclusion du contenu approprié
        switch ($page) {
            case 'membres':
                switch ($action) {
                    case 'ajouter':
                        require_once 'views/membres/ajouter.php';
                        break;
                    case 'editer':
                        require_once 'views/membres/editer.php';
                        break;
                    case 'profil':
                        require_once 'views/membres/profil.php';
                        break;
                    case 'supprimer':
                        require_once 'views/membres/supprimer.php';
                        break;
                    default:
                        require_once 'views/membres/liste.php';
                }
                break;
            
            case 'entrainements':
                switch ($action) {
                    case 'ajouter':
                        require_once 'views/entrainements/ajouter.php';
                        break;
                    case 'editer':
                        require_once 'views/entrainements/editer.php';
                        break;
                    case 'planning':
                        require_once 'views/entrainements/planning.php';
                        break;
                    case 'supprimer':
                        require_once 'views/entrainements/supprimer.php';
                        break;
                    default:
                        require_once 'views/entrainements/planning.php';
                }
                break;
            
            case 'paiements':
                switch ($action) {
                    case 'ajouter':
                        require_once 'views/paiements/ajouter.php';
                        break;
                    case 'editer':
                        require_once 'views/paiements/editer.php';
                        break;
                    case 'supprimer':
                        require_once 'views/paiements/supprimer.php';
                        break;
                    default:
                        require_once 'views/paiements/liste.php';
                }
                break;
            
            case 'statistiques':
                require_once 'views/statistiques/dashboard.php';
                break;
            
            case 'accueil':
                require_once 'views/accueil.php';
                break;
            
            default:
                // Dashboard par défaut
                $stats = $dashboardController->getDashboardStats();
                $totalMembres = $stats['total_membres'] ?? 0;
                $entrainementsSemaine = $stats['entrainements_semaine'] ?? 0;
                $paiementsAttente = $stats['paiements_attente'] ?? 0;
                require_once 'views/dashboard.php';
        }
        ?>
    </div>
    
    <?php include 'views/footer.php'; ?>
    
    <script src="js/script.js"></script>
</body>
</html>