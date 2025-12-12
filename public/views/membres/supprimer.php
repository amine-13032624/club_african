<?php
// Controllers are instantiated in index.php
$page_title = 'Supprimer un Membre';

if (!isset($_GET['id'])) {
    header('Location: index.php?page=membres');
    exit();
}

$id = intval($_GET['id']);
$member = $membreController->getMembreById($id);

if (!$member) {
    $_SESSION['error'] = 'Membre non trouvé';
    header('Location: index.php?page=membres');
    exit();
}
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Supprimer un Membre</h1>
        </div>

        <div class="form-container">
            <div style="text-align: center; padding: 2rem;">
                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #f39c12; margin-bottom: 1rem;"></i>
                <h2>Êtes-vous sûr?</h2>
                <p style="font-size: 1.1rem; color: #666; margin: 1rem 0;">
                    Vous êtes sur le point de supprimer le membre:<br>
                    <strong><?php echo htmlspecialchars($member['prenom']) . ' ' . htmlspecialchars($member['nom']); ?></strong>
                </p>
                <p style="color: #e74c3c; font-weight: 600;">Cette action ne peut pas être annulée!</p>

                <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                    <button id="deleteBtnConfirm" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                    <a href="index.php?page=membres" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
                <input type="hidden" id="id" value="<?php echo intval($_GET['id']); ?>">
            </div>
        </div>



<script>
    document.getElementById('deleteBtnConfirm').addEventListener('click', async () => {
        if (!confirm('Êtes-vous vraiment sûr? Cette action ne peut pas être annulée!')) {
            return;
        }
        
        const id = parseInt(document.getElementById('id').value);
        
        try {
            const response = await fetch('api/membre/supprimer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Membre supprimé avec succès!');
                window.location.href = 'index.php?page=membres';
            } else {
                alert('Erreur: ' + result.message);
            }
        } catch (error) {
            alert('Erreur: ' + error.message);
        }
    });
</script>
