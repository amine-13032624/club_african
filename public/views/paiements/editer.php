<?php
// Controllers are instantiated in index.php
$page_title = 'Modifier un Paiement';

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

$query = "SELECT id_membre, CONCAT(prenom, ' ', nom) as nom FROM membre ORDER BY nom";
$stmt = $db->prepare($query);
$stmt->execute();
$membres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
        $id
    ])) {
        $_SESSION['success'] = 'Paiement modifié avec succès!';
        header('Location: liste.php');
        exit();
    } else {
        $error = 'Erreur lors de la modification';
    }
}
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Éditer un Paiement</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form id="paiementForm" class="form">
                <input type="hidden" id="id_paiement" value="<?php echo $paiement['id_paiement']; ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_membre">Membre *</label>
                        <select id="id_membre" name="id_membre" required>
                            <option value="">Sélectionner un membre</option>
                            <?php foreach ($membres as $membre): ?>
                            <option value="<?php echo $membre['id_membre']; ?>" <?php echo $paiement['id_membre'] == $membre['id_membre'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($membre['nom']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="montant">Montant (€) *</label>
                        <input type="number" id="montant" name="montant" min="0" step="0.01" value="<?php echo htmlspecialchars($paiement['montant']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date_paiement">Date de Paiement *</label>
                        <input type="date" id="date_paiement" name="date_paiement" value="<?php echo htmlspecialchars($paiement['date_paiement']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="methode_paiement">Méthode de Paiement *</label>
                        <select id="methode_paiement" name="methode_paiement" required>
                            <option value="">Sélectionner une méthode</option>
                            <option value="Espèces" <?php echo $paiement['methode_paiement'] === 'Espèces' ? 'selected' : ''; ?>>Espèces</option>
                            <option value="Chèque" <?php echo $paiement['methode_paiement'] === 'Chèque' ? 'selected' : ''; ?>>Chèque</option>
                            <option value="Carte bancaire" <?php echo $paiement['methode_paiement'] === 'Carte bancaire' ? 'selected' : ''; ?>>Carte bancaire</option>
                            <option value="Virement" <?php echo $paiement['methode_paiement'] === 'Virement' ? 'selected' : ''; ?>>Virement</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="statut">Statut *</label>
                    <select id="statut" name="statut" required>
                        <option value="">Sélectionner un statut</option>
                        <option value="en attente" <?php echo $paiement['statut'] === 'en attente' ? 'selected' : ''; ?>>En attente</option>
                        <option value="confirmé" <?php echo $paiement['statut'] === 'confirmé' ? 'selected' : ''; ?>>Confirmé</option>
                        <option value="annulé" <?php echo $paiement['statut'] === 'annulé' ? 'selected' : ''; ?>>Annulé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($paiement['description'] ?? ''); ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="index.php?page=paiements" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>

<script>
    document.getElementById('paiementForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = {
            id_membre: document.getElementById('id_membre').value,
            montant: parseFloat(document.getElementById('montant').value),
            date_paiement: document.getElementById('date_paiement').value,
            methode_paiement: document.getElementById('methode_paiement').value,
            statut: document.getElementById('statut').value,
            description: document.getElementById('description').value || null
        };

        try {
            const response = await fetch('api/paiement/modifier.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({...formData, id: <?php echo $paiement['id_paiement']; ?>})
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Paiement modifié avec succès!');
                window.location.href = 'index.php?page=paiements';
            } else {
                alert('Erreur: ' + result.message);
            }
        } catch (error) {
            alert('Erreur lors de la modification: ' + error.message);
        }
    });
</script>
