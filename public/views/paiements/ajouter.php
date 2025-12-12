<?php
// Controllers are instantiated in index.php
$page_title = 'Ajouter un Paiement';

$database = new Database();
$db = $database->getConnection();
$query = "SELECT id_membre, CONCAT(prenom, ' ', nom) as nom FROM membre ORDER BY nom";
$stmt = $db->prepare($query);
$stmt->execute();
$membres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>





    <div class="page-header">
        <h1>Ajouter un Paiement</h1>
    </div>

    <div class="form-container">
        <form id="paiementForm" class="form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_membre">Membre *</label>
                        <select id="id_membre" name="id_membre" required>
                            <option value="">Sélectionner un membre</option>
                            <?php foreach ($membres as $membre): ?>
                            <option value="<?php echo $membre['id_membre']; ?>">
                                <?php echo htmlspecialchars($membre['nom']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="montant">Montant (TND) *</label>
                        <input type="number" id="montant" name="montant" min="0" step="0.01" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date_paiement">Date de Paiement *</label>
                        <input type="date" id="date_paiement" name="date_paiement" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="methode_paiement">Méthode de Paiement *</label>
                        <select id="methode_paiement" name="methode_paiement" required>
                            <option value="">Sélectionner une méthode</option>
                            <option value="Espèces">Espèces</option>
                            <option value="Chèque">Chèque</option>
                            <option value="Carte bancaire">Carte bancaire</option>
                            <option value="Virement">Virement</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="statut">Statut *</label>
                    <select id="statut" name="statut" required>
                        <option value="">Sélectionner un statut</option>
                        <option value="en attente">En attente</option>
                        <option value="confirmé">Confirmé</option>
                        <option value="annulé">Annulé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Ex: Cotisation mensuelle..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <a href="index.php?page=paiements" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
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
            const response = await fetch('api/paiement/ajouter.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Paiement ajouté avec succès!');
                window.location.href = 'index.php?page=paiements';
            } else {
                alert('Erreur: ' + result.message);
            }
        } catch (error) {
            alert('Erreur lors de la création: ' + error.message);
        }
    });
</script>
