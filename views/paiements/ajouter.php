<?php
// Controllers are instantiated in index.php
$page_title = 'Ajouter un Paiement';

$controller = new PaiementController();
$membres = [];

$database = new Database();
$db = $database->getConnection();
$query = "SELECT id_membre, CONCAT(prenom, ' ', nom) as nom FROM membre";
$stmt = $db->prepare($query);
$stmt->execute();
$membres = $stmt->fetchAll(PDO::FETCH_ASSOC);

$error = '';

// Traiter l'ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_membre' => $_POST['id_membre'],
        'montant' => $_POST['montant'],
        'date_paiement' => $_POST['date_paiement'],
        'methode_paiement' => $_POST['methode_paiement'],
        'statut' => $_POST['statut'],
        'description' => $_POST['description'] ?? ''
    ];

    try {
        if ($controller->ajouter($data)) {
            $_SESSION['success'] = 'Paiement ajouté avec succès!';
            header('Location: liste.php');
            exit();
        } else {
            $error = 'Erreur lors de l\'ajout du paiement';
        }
    } catch (Exception $e) {
        $error = 'Erreur: ' . $e->getMessage();
    }
}
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Ajouter un Paiement</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" class="form">
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
                    <a href="liste.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>


