<?php
// Controllers are instantiated in index.php
$page_title = 'Modifier un Membre';

if (!isset($_GET['id'])) {
    header('Location: liste.php');
    exit();
}

$id = intval($_GET['id']);
$membreController = new MembreController();
$member = $membreController->getMembreById($id);

if (!$member) {
    $_SESSION['error'] = 'Membre non trouvé';
    header('Location: liste.php');
    exit();
}

$error = '';

// Traiter la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'email' => $_POST['email'],
        'telephone' => $_POST['telephone'],
        'dateNaissance' => $_POST['dateNaissance'],
        'categorie' => $_POST['categorie'],
        'niveau' => $_POST['niveau']
    ];

    if ($membreController->modifierMembre($id, $data)) {
        $_SESSION['success'] = 'Membre modifié avec succès!';
        header('Location: profil.php?id=' . $id);
        exit();
    } else {
        $error = 'Erreur lors de la modification';
    }
}
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Éditer un Membre</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" class="form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($member['nom']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($member['prenom']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone *</label>
                        <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($member['telephone']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="dateNaissance">Date de Naissance *</label>
                        <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo htmlspecialchars($member['dateNaissance']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="categorie">Catégorie *</label>
                        <input type="text" id="categorie" name="categorie" value="<?php echo htmlspecialchars($member['categorie']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="niveau">Niveau *</label>
                        <select id="niveau" name="niveau" required>
                            <option value="">Sélectionner un niveau</option>
                            <option value="Débutant" <?php echo $member['niveau'] === 'Débutant' ? 'selected' : ''; ?>>Débutant</option>
                            <option value="Intermédiaire" <?php echo $member['niveau'] === 'Intermédiaire' ? 'selected' : ''; ?>>Intermédiaire</option>
                            <option value="Avancé" <?php echo $member['niveau'] === 'Avancé' ? 'selected' : ''; ?>>Avancé</option>
                            <option value="Expert" <?php echo $member['niveau'] === 'Expert' ? 'selected' : ''; ?>>Expert</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="index.php?page=membres&action=profil&id=<?php echo $id; ?>" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>


