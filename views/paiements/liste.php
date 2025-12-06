<?php
// Controllers are instantiated in index.php
$paiements = $paiementController->getAll();
$page_title = 'Gestion des Paiements';
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Gestion des Paiements</h1>
            <a href="index.php?page=paiements&action=ajouter" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un Paiement
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total des Paiements</h3>
                <p class="stat-value"><?php echo number_format($stats['total_paiements'] ?? 0); ?></p>
            </div>
            <div class="stat-card">
                <h3>Confirmés</h3>
                <p class="stat-value text-success"><?php echo $stats['paiements_confirmes'] ?? 0; ?></p>
            </div>
            <div class="stat-card">
                <h3>En Attente</h3>
                <p class="stat-value text-warning"><?php echo $stats['paiements_attente'] ?? 0; ?></p>
            </div>
            <div class="stat-card">
                <h3>Montant Total</h3>
                <p class="stat-value"><?php echo number_format($stats['total_montant'] ?? 0, 2); ?> TND</p>
            </div>
        </div>

        <!-- Tableau des paiements -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Membre</th>
                        <th>Montant</th>
                        <th>Méthode</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paiements as $paiement): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($paiement['id_membre']); ?></td>
                        <td><?php echo number_format($paiement['montant'], 2); ?> €</td>
                        <td><?php echo htmlspecialchars($paiement['methode_paiement']); ?></td>
                        <td><?php echo htmlspecialchars($paiement['date_paiement']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo strtolower($paiement['statut']); ?>">
                                <?php echo ucfirst($paiement['statut']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?page=paiements&action=editer&id=<?php echo $paiement['id_paiement']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="index.php?page=paiements&action=supprimer&id=<?php echo $paiement['id_paiement']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


