<?php
// Controllers are instantiated in index.php
$page_title = 'Modifier un Paiement';

if (!isset($_GET['id'])) {
    header('Location: liste.php');
    exit();
}

$id = intval($_GET['id']);
$controller = new PaiementController();

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

$query = "SELECT id_membre, CONCAT(prenom, ' ', nom) as nom FROM membre";
$stmt = $db->prepare($query);
$stmt->execute();
$membres = $stmt->fetchAll(PDO::FETCH_ASSOC);

$error = '';

// Traiter la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_membre' => $_POST['id_membre'],
        'montant' => $_POST['montant'],
        'date_paiement' => $_POST['date_paiement'],
        'methode_paiement' => $_POST['methode_paiement'],
        'statut' => $_POST['statut'],
        'description' => $_POST['description'] ?? ''
    ];

    $query = "UPDATE paiement SET 
              id_membre = ?,
              montant = ?,
              date_paiement = ?,
              methode_paiement = ?,
              statut = ?,
              description = ?
              WHERE id_paiement = ?";
    
    $stmt = $db->prepare($query);
    if ($stmt->execute([
        $data['id_membre'],
        $data['montant'],
        $data['date_paiement'],
        $data['methode_paiement'],
        $data['statut'],
        $data['description'],
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
            <form method="POST" class="form">
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
                    <a href="liste.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>


