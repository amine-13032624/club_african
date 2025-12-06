<?php
// Controllers are instantiated in index.php
$equipes = $entrainementController->getToutesEquipes();
$page_title = 'Ajouter un Membre';

$error = '';
$type_membre = isset($_GET['type']) ? $_GET['type'] : 'athlete';

// Traiter l'ajout
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

    try {
        if ($type_membre === 'athlete') {
            $data['numeroLicence'] = $_POST['numeroLicence'];
            $data['id_equipe'] = $_POST['id_equipe'] ?? null;
            $data['taille'] = $_POST['taille'] ?? null;
            $data['poids'] = $_POST['poids'] ?? null;
            $data['position'] = $_POST['position'] ?? null;
            $membreController->ajouterAthlete($data);
        } elseif ($type_membre === 'entraineur') {
            $data['specialite'] = $_POST['specialite'];
            $data['diplome'] = $_POST['diplome'];
            $data['annees_experience'] = $_POST['annees_experience'];
            $data['id_equipe'] = $_POST['id_equipe'] ?? null;
            $membreController->ajouterEntraineur($data);
        } elseif ($type_membre === 'staff') {
            $data['fonction'] = $_POST['fonction'];
            $data['departement'] = $_POST['departement'];
            $membreController->ajouterStaff($data);
        }

        $_SESSION['success'] = 'Membre ajouté avec succès!';
        header('Location: index.php?page=membres');
        exit();
    } catch (Exception $e) {
        $error = 'Erreur: ' . $e->getMessage();
    }
}
?>

<div class="container">
        <div class="page-header">
            <h1>Ajouter un Membre</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-container">
            <!-- Sélection du type de membre -->
            <div class="member-type-selector">
                <a href="index.php?page=membres&action=ajouter&type=athlete" class="type-btn <?php echo $type_membre === 'athlete' ? 'active' : ''; ?>">
                    <i class="fas fa-running"></i> Athlète
                </a>
                <a href="index.php?page=membres&action=ajouter&type=entraineur" class="type-btn <?php echo $type_membre === 'entraineur' ? 'active' : ''; ?>">
                    <i class="fas fa-dumbbell"></i> Entraîneur
                </a>
                <a href="index.php?page=membres&action=ajouter&type=staff" class="type-btn <?php echo $type_membre === 'staff' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Staff
                </a>
            </div>

            <form method="POST" class="form">
                <!-- Champs communs -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone *</label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="dateNaissance">Date de Naissance *</label>
                        <input type="date" id="dateNaissance" name="dateNaissance" required>
                    </div>
                    <div class="form-group">
                        <label for="categorie">Catégorie *</label>
                        <input type="text" id="categorie" name="categorie" placeholder="Ex: Jeunes, Adultes..." required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="niveau">Niveau *</label>
                        <select id="niveau" name="niveau" required>
                            <option value="">Sélectionner un niveau</option>
                            <option value="Débutant">Débutant</option>
                            <option value="Intermédiaire">Intermédiaire</option>
                            <option value="Avancé">Avancé</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                </div>

                <!-- Champs spécifiques Athlète -->
                <?php if ($type_membre === 'athlete'): ?>
                <fieldset>
                    <legend>Informations Athlète</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="numeroLicence">Numéro de Licence *</label>
                            <input type="text" id="numeroLicence" name="numeroLicence" required>
                        </div>
                        <div class="form-group">
                            <label for="id_equipe">Équipe</label>
                            <select id="id_equipe" name="id_equipe">
                                <option value="">Aucune équipe</option>
                                <?php foreach ($equipes as $equipe): ?>
                                <option value="<?php echo $equipe['id_equipe']; ?>">
                                    <?php echo htmlspecialchars($equipe['nom']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="taille">Taille (cm)</label>
                            <input type="number" id="taille" name="taille" min="100" max="250">
                        </div>
                        <div class="form-group">
                            <label for="poids">Poids (kg)</label>
                            <input type="number" id="poids" name="poids" min="20" max="200" step="0.1">
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="text" id="position" name="position" placeholder="Ex: Gardien, Attaquant...">
                        </div>
                    </div>
                </fieldset>
                <?php endif; ?>

                <!-- Champs spécifiques Entraîneur -->
                <?php if ($type_membre === 'entraineur'): ?>
                <fieldset>
                    <legend>Informations Entraîneur</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="specialite">Spécialité *</label>
                            <input type="text" id="specialite" name="specialite" placeholder="Ex: Cardio, Musculation..." required>
                        </div>
                        <div class="form-group">
                            <label for="diplome">Diplôme *</label>
                            <input type="text" id="diplome" name="diplome" placeholder="Ex: Brevet d'État..." required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="annees_experience">Années d'Expérience *</label>
                            <input type="number" id="annees_experience" name="annees_experience" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="id_equipe">Équipe</label>
                            <select id="id_equipe" name="id_equipe">
                                <option value="">Aucune équipe</option>
                                <?php foreach ($equipes as $equipe): ?>
                                <option value="<?php echo $equipe['id_equipe']; ?>">
                                    <?php echo htmlspecialchars($equipe['nom']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <?php endif; ?>

                <!-- Champs spécifiques Staff -->
                <?php if ($type_membre === 'staff'): ?>
                <fieldset>
                    <legend>Informations Staff</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fonction">Fonction *</label>
                            <input type="text" id="fonction" name="fonction" placeholder="Ex: Directeur, Secrétaire..." required>
                        </div>
                        <div class="form-group">
                            <label for="departement">Département *</label>
                            <input type="text" id="departement" name="departement" placeholder="Ex: Administration, Médical..." required>
                        </div>
                    </div>
                </fieldset>
                <?php endif; ?>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <a href="index.php?page=membres" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
