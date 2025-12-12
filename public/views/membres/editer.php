<?php
// Controllers are instantiated in index.php
$page_title = 'Modifier un Membre';

if (!isset($_GET['id'])) {
    header('Location: index.php?page=membres&action=liste');
    exit();
}

$id = intval($_GET['id']);
$membreController = new MembreController();
$member = $membreController->getMembreById($id);

if (!$member) {
    $_SESSION['error'] = 'Membre non trouvé';
    header('Location: index.php?page=membres&action=liste');
    exit();
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
            <form id="membreForm" class="form">
                <input type="hidden" id="id" value="<?php echo intval($_GET['id']); ?>">
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



<script>
    document.getElementById('membreForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const id = parseInt(document.getElementById('id').value);
        const formData = {
            id: id,
            nom: document.getElementById('nom').value,
            prenom: document.getElementById('prenom').value,
            email: document.getElementById('email').value,
            telephone: document.getElementById('telephone').value,
            dateNaissance: document.getElementById('dateNaissance').value,
            categorie: document.getElementById('categorie').value,
            niveau: document.getElementById('niveau').value
        };

        try {
            const response = await fetch('api/membre/modifier.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Membre modifié avec succès!');
                window.location.href = 'index.php?page=membres&action=profil&id=' + id;
            } else {
                alert('Erreur: ' + result.message);
            }
        } catch (error) {
            alert('Erreur: ' + error.message);
        }
    });
</script>
