<?php
// Controllers are instantiated in index.php
$page_title = 'Ajouter un Entraînement';

$controller = new EntrainementController();
$equipes = $controller->getToutesEquipes();
$entraineurs = $controller->getTousEntraineurs();
$page_title = 'Ajouter un Entraînement';

$error = '';

// Traiter l'ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'titre' => $_POST['titre'],
        'description' => $_POST['description'] ?? '',
        'date_entrainement' => $_POST['date_entrainement'],
        'heure_debut' => $_POST['heure_debut'],
        'heure_fin' => $_POST['heure_fin'],
        'lieu' => $_POST['lieu'],
        'type' => $_POST['type'],
        'niveau' => $_POST['niveau'],
        'id_entraineur' => $_POST['id_entraineur'],
        'id_equipe' => $_POST['id_equipe']
    ];

    try {
        if ($controller->ajouter($data)) {
            $_SESSION['success'] = 'Entraînement ajouté avec succès!';
            header('Location: index.php?page=entrainements&action=planning');
            exit();
        } else {
            $error = 'Erreur lors de l\'ajout de l\'entraînement';
        }
    } catch (Exception $e) {
        $error = 'Erreur: ' . $e->getMessage();
    }
}
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1><?php echo $page_title; ?></h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" class="form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="titre">Titre *</label>
                        <input type="text" id="titre" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Type *</label>
                        <select id="type" name="type" required>
                            <option value="">Sélectionner un type</option>
                            <option value="Collectif">Collectif</option>
                            <option value="Individuel">Individuel</option>
                            <option value="Groupe">Groupe</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date_entrainement">Date *</label>
                        <input type="date" id="date_entrainement" name="date_entrainement" required>
                    </div>
                    <div class="form-group">
                        <label for="niveau">Niveau *</label>
                        <select id="niveau" name="niveau" required>
                            <option value="">Sélectionner un niveau</option>
                            <option value="Débutant">Débutant</option>
                            <option value="Intermédiaire">Intermédiaire</option>
                            <option value="Avancé">Avancé</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="heure_debut">Heure de début *</label>
                        <input type="time" id="heure_debut" name="heure_debut" required>
                    </div>
                    <div class="form-group">
                        <label for="heure_fin">Heure de fin *</label>
                        <input type="time" id="heure_fin" name="heure_fin" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="lieu">Lieu *</label>
                        <input type="text" id="lieu" name="lieu" placeholder="Ex: Salle A, Terrain 1..." required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="id_entraineur">Entraîneur *</label>
                        <select id="id_entraineur" name="id_entraineur" required>
                            <option value="">Sélectionner un entraîneur</option>
                            <?php foreach ($entraineurs as $entraineur): ?>
                            <option value="<?php echo $entraineur['id_entraineur']; ?>">
                                <?php echo htmlspecialchars($entraineur['prenom']) . ' ' . htmlspecialchars($entraineur['nom']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_equipe">Équipe *</label>
                        <select id="id_equipe" name="id_equipe" required>
                            <option value="">Sélectionner une équipe</option>
                            <?php foreach ($equipes as $equipe): ?>
                            <option value="<?php echo $equipe['id_equipe']; ?>">
                                <?php echo htmlspecialchars($equipe['nom']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <a href="index.php?page=entrainements&action=planning" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>


