<?php
// Controllers are instantiated in index.php
$page_title = 'Supprimer un Entraînement';

if (!isset($_GET['id'])) {
    header('Location: planning.php');
    exit();
}

$id = intval($_GET['id']);
$controller = new EntrainementController();
$entrainement = $controller->getById($id);

if (!$entrainement) {
    $_SESSION['error'] = 'Entraînement non trouvé';
    header('Location: planning.php');
    exit();
}

// Traiter la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    if ($controller->supprimer($id)) {
        $_SESSION['success'] = 'Entraînement supprimé avec succès!';
        header('Location: planning.php');
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de la suppression';
    }
}
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Supprimer un Entraînement</h1>
        </div>

        <div class="form-container">
            <div style="text-align: center; padding: 2rem;">
                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #f39c12; margin-bottom: 1rem;"></i>
                <h2>Êtes-vous sûr?</h2>
                <p style="font-size: 1.1rem; color: #666; margin: 1rem 0;">
                    Vous êtes sur le point de supprimer l'entraînement:<br>
                    <strong><?php echo htmlspecialchars($entrainement['titre']); ?></strong>
                </p>
                <p style="font-size: 0.95rem; color: #999;">
                    Date: <?php echo htmlspecialchars($entrainement['date_entrainement']); ?><br>
                    Heure: <?php echo htmlspecialchars($entrainement['heure_debut']); ?>
                </p>
                <p style="color: #e74c3c; font-weight: 600;">Cette action ne peut pas être annulée!</p>

                <form method="POST" style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                    <button type="submit" name="confirm" value="1" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                    <a href="index.php?page=entrainements&action=planning" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </form>
            </div>
        </div>


