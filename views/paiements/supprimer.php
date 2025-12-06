<?php
// Controllers are instantiated in index.php
$page_title = 'Supprimer un Paiement';

if (!isset($_GET['id'])) {
    header('Location: liste.php');
    exit();
}

$id = intval($_GET['id']);
$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM paiement WHERE id_paiement = ?";
$stmt = $db->prepare($query);
$stmt->execute([$id]);
$paiement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paiement) {
    $_SESSION['error'] = 'Paiement non trouvé';
    header('Location: liste.php');
    exit();
}

// Traiter la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    $query = "DELETE FROM paiement WHERE id_paiement = ?";
    $stmt = $db->prepare($query);
    
    if ($stmt->execute([$id])) {
        $_SESSION['success'] = 'Paiement supprimé avec succès!';
        header('Location: liste.php');
        exit();
    } else {
        $_SESSION['error'] = 'Erreur lors de la suppression';
    }
}
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Supprimer un Paiement</h1>
        </div>

        <div class="form-container">
            <div style="text-align: center; padding: 2rem;">
                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #f39c12; margin-bottom: 1rem;"></i>
                <h2>Êtes-vous sûr?</h2>
                <p style="font-size: 1.1rem; color: #666; margin: 1rem 0;">
                    Vous êtes sur le point de supprimer le paiement:<br>
                    <strong><?php echo htmlspecialchars(number_format($paiement['montant'], 2) . '€'); ?></strong>
                </p>
                <p style="font-size: 0.95rem; color: #999;">
                    Date: <?php echo htmlspecialchars($paiement['date_paiement']); ?><br>
                    Statut: <?php echo htmlspecialchars($paiement['statut']); ?>
                </p>
                <p style="color: #e74c3c; font-weight: 600;">Cette action ne peut pas être annulée!</p>

                <form method="POST" style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                    <button type="submit" name="confirm" value="1" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                    <a href="liste.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </form>
            </div>
        </div>


