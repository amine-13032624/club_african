<?php
// Controllers are instantiated in index.php
$page_title = 'Modifier un Entraînement';

if (!isset($_GET['id'])) {
    header('Location: planning.php');
    exit();
}

$id = intval($_GET['id']);
$controller = new EntrainementController();
$entrainement = $controller->getById($id);
$equipes = $controller->getToutesEquipes();
$entraineurs = $controller->getTousEntraineurs();

if (!$entrainement) {
    $_SESSION['error'] = 'Entraînement non trouvé';
    header('Location: planning.php');
    exit();
}

$error = '';

// Traiter la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'titre' => $_POST['titre'],
        'description' => $_POST['description'],
        'date_entrainement' => $_POST['date_entrainement'],
        'heure_debut' => $_POST['heure_debut'],
        'heure_fin' => $_POST['heure_fin'],
        'lieu' => $_POST['lieu'],
        'type' => $_POST['type'],
        'niveau' => $_POST['niveau'],
        'id_entraineur' => $_POST['id_entraineur'],
        'id_equipe' => $_POST['id_equipe']
    ];

    if ($controller->modifier($id, $data)) {
        $_SESSION['success'] = 'Entraînement modifié avec succès!';
        header('Location: planning.php');
        exit();
    } else {
        $error = 'Erreur lors de la modification';
    }
}
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Éditer un Entraînement</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" class="form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="titre">Titre *</label>
                        <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($entrainement['titre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Type *</label>
                        <select id="type" name="type" required>
                            <option value="Collectif" <?php echo $entrainement['type'] === 'Collectif' ? 'selected' : ''; ?>>Collectif</option>
                            <option value="Individuel" <?php echo $entrainement['type'] === 'Individuel' ? 'selected' : ''; ?>>Individuel</option>
                            <option value="Groupe" <?php echo $entrainement['type'] === 'Groupe' ? 'selected' : ''; ?>>Groupe</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date_entrainement">Date *</label>
                        <input type="date" id="date_entrainement" name="date_entrainement" value="<?php echo htmlspecialchars($entrainement['date_entrainement']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="niveau">Niveau *</label>
                        <select id="niveau" name="niveau" required>
                            <option value="Débutant" <?php echo $entrainement['niveau'] === 'Débutant' ? 'selected' : ''; ?>>Débutant</option>
                            <option value="Intermédiaire" <?php echo $entrainement['niveau'] === 'Intermédiaire' ? 'selected' : ''; ?>>Intermédiaire</option>
                            <option value="Avancé" <?php echo $entrainement['niveau'] === 'Avancé' ? 'selected' : ''; ?>>Avancé</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="heure_debut">Heure de début *</label>
                        <input type="time" id="heure_debut" name="heure_debut" value="<?php echo htmlspecialchars($entrainement['heure_debut']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="heure_fin">Heure de fin *</label>
                        <input type="time" id="heure_fin" name="heure_fin" value="<?php echo htmlspecialchars($entrainement['heure_fin']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lieu">Lieu *</label>
                    <input type="text" id="lieu" name="lieu" value="<?php echo htmlspecialchars($entrainement['lieu']); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="id_entraineur">Entraîneur *</label>
                        <select id="id_entraineur" name="id_entraineur" required>
                            <?php foreach ($entraineurs as $entraineur): ?>
                            <option value="<?php echo $entraineur['id_entraineur']; ?>" <?php echo $entrainement['id_entraineur'] == $entraineur['id_entraineur'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($entraineur['prenom']) . ' ' . htmlspecialchars($entraineur['nom']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_equipe">Équipe *</label>
                        <select id="id_equipe" name="id_equipe" required>
                            <?php foreach ($equipes as $equipe): ?>
                            <option value="<?php echo $equipe['id_equipe']; ?>" <?php echo $entrainement['id_equipe'] == $equipe['id_equipe'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($equipe['nom']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($entrainement['description']); ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="index.php?page=entrainements&action=planning" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>


