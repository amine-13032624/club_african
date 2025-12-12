<?php
// Controllers are instantiated in index.php
$page_title = 'Supprimer un Paiement';

if (!isset($_GET['id'])) {
    header('Location: index.php?page=paiements');
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
    header('Location: index.php?page=paiements');
    exit();
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
                <strong><?php echo htmlspecialchars(number_format($paiement['montant'], 2) . ' TND'); ?></strong>
            </p>
            <p style="font-size: 0.95rem; color: #999;">
                Date: <?php echo htmlspecialchars($paiement['date_paiement']); ?><br>
                Statut: <?php echo htmlspecialchars($paiement['statut']); ?>
            </p>
            <p style="color: #e74c3c; font-weight: 600;">Cette action ne peut pas être annulée!</p>

            <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                <button id="deleteBtnConfirm" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
                <a href="index.php?page=paiements" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </div>
    </div>

<script>
    document.getElementById('deleteBtnConfirm').addEventListener('click', async () => {
        try {
            const response = await fetch('api/paiement/supprimer.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id: <?php echo $paiement['id_paiement']; ?> })
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Paiement supprimé avec succès!');
                window.location.href = 'index.php?page=paiements';
            } else {
                alert('Erreur: ' + result.message);
            }
        } catch (error) {
            alert('Erreur lors de la suppression: ' + error.message);
        }
    });
</script>
