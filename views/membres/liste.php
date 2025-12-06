<?php
// Controllers are instantiated in index.php
$members = $membreController->getTousMembres();
$page_title = 'Liste des Membres';
?>

<div class="page-header">
    <h1>Liste des Membres</h1>
    <a href="index.php?page=membres&action=ajouter" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter un Membre
    </a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Catégorie</th>
                <th>Niveau</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member): ?>
            <tr>
                <td><?php echo htmlspecialchars($member['nom']); ?></td>
                <td><?php echo htmlspecialchars($member['prenom']); ?></td>
                <td><?php echo htmlspecialchars($member['email']); ?></td>
                <td><?php echo htmlspecialchars($member['telephone']); ?></td>
                <td><?php echo htmlspecialchars($member['categorie']); ?></td>
                <td><?php echo htmlspecialchars($member['niveau']); ?></td>
                <td>
                    <span class="badge badge-<?php echo strtolower($member['type_membre']); ?>">
                        <?php echo ucfirst($member['type_membre']); ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?page=membres&action=profil&id=<?php echo $member['id_membre']; ?>" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="index.php?page=membres&action=editer&id=<?php echo $member['id_membre']; ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?page=membres&action=supprimer&id=<?php echo $member['id_membre']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
