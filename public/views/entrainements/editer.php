<?php
// Controllers are instantiated in index.php
$page_title = 'Modifier un Entraînement';

if (!isset($_GET['id'])) {
    header('Location: index.php?page=entrainements&action=planning');
    exit();
}

$id = intval($_GET['id']);
$controller = new EntrainementController();
$entrainement = $controller->getById($id);
$equipes = $controller->getToutesEquipes();
$entraineurs = $controller->getTousEntraineurs();

if (!$entrainement) {
    $_SESSION['error'] = 'Entraînement non trouvé';
    header('Location: index.php?page=entrainements&action=planning');
    exit();
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
            <form id="entrainementForm" class="form">
                <input type="hidden" id="id" value="<?php echo intval($_GET['id']); ?>">
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


<script>
    document.getElementById('entrainementForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const id = parseInt(document.getElementById('id').value);
        const formData = {
            id: id,
            titre: document.getElementById('titre').value,
            description: document.getElementById('description').value,
            date_entrainement: document.getElementById('date_entrainement').value,
            heure_debut: document.getElementById('heure_debut').value,
            heure_fin: document.getElementById('heure_fin').value,
            lieu: document.getElementById('lieu').value,
            type: document.getElementById('type').value,
            niveau: document.getElementById('niveau').value,
            id_entraineur: parseInt(document.getElementById('id_entraineur').value),
            id_equipe: parseInt(document.getElementById('id_equipe').value)
        };

        try {
            const response = await fetch('api/entrainement/modifier.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Entraînement modifié avec succès!');
                window.location.href = 'index.php?page=entrainements&action=planning';
            } else {
                alert('Erreur: ' + result.message);
            }
        } catch (error) {
            alert('Erreur: ' + error.message);
        }
    });
</script>
