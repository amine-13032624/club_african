<?php
// Controllers are instantiated in index.php
$page_title = 'Profil du Membre';

$membreController = new MembreController();
$page_title = 'Profil du Membre';

if (!isset($_GET['id'])) {
    header('Location: liste.php');
    exit();
}

$id = intval($_GET['id']);
$member = $membreController->getMembreById($id);

if (!$member) {
    $_SESSION['error'] = 'Membre non trouvé';
    header('Location: liste.php');
    exit();
}
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Profil du Membre</h1>
            <a href="liste.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle fa-5x"></i>
                </div>
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($member['prenom']) . ' ' . htmlspecialchars($member['nom']); ?></h2>
                    <p class="badge badge-<?php echo strtolower($member['type_membre']); ?>">
                        <?php echo ucfirst($member['type_membre']); ?>
                    </p>
                </div>
            </div>

            <div class="profile-content">
                <div class="info-section">
                    <h3>Informations Personnelles</h3>
                    <table class="info-table">
                        <tr>
                            <td class="label">Email</td>
                            <td><?php echo htmlspecialchars($member['email']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Téléphone</td>
                            <td><?php echo htmlspecialchars($member['telephone']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Date de Naissance</td>
                            <td><?php echo htmlspecialchars($member['dateNaissance']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Date d'Inscription</td>
                            <td><?php echo htmlspecialchars($member['dateInscription']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Catégorie</td>
                            <td><?php echo htmlspecialchars($member['categorie']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Niveau</td>
                            <td><?php echo htmlspecialchars($member['niveau']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="profile-actions">
                <a href="index.php?page=membres&action=editer&id=<?php echo $member['id_membre']; ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="index.php?page=membres&action=supprimer&id=<?php echo $member['id_membre']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                    <i class="fas fa-trash"></i> Supprimer
                </a>
            </div>
        </div>


