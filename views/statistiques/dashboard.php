<?php
// Controllers are instantiated in index.php
$stats = $dashboardController->getDashboardStats();
$page_title = 'Statistiques';

$categories = $dashboardController->getStatistiquesCategories();
$niveaux = $dashboardController->getStatistiquesNiveaux();
?>

<div class="page-header">
            <h1>Statistiques du Club</h1>
        </div>

        <!-- Statistiques principales -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Membres</h3>
                <p class="stat-value"><?php echo $stats['total_membres']; ?></p>
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card">
                <h3>Entraînements (Semaine)</h3>
                <p class="stat-value"><?php echo $stats['entrainements_semaine']; ?></p>
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-card">
                <h3>Paiements en Attente</h3>
                <p class="stat-value text-warning"><?php echo $stats['paiements_attente']; ?></p>
                <i class="fas fa-hourglass"></i>
            </div>
            <div class="stat-card">
                <h3>Équipes</h3>
                <p class="stat-value"><?php echo $stats['total_equipes']; ?></p>
                <i class="fas fa-team-solid"></i>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="charts-container">
            <div class="chart">
                <h3>Membres par Catégorie</h3>
                <table class="simple-table">
                    <tr>
                        <th>Catégorie</th>
                        <th>Nombre</th>
                    </tr>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cat['categorie']); ?></td>
                        <td><?php echo $cat['count']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <div class="chart">
                <h3>Membres par Niveau</h3>
                <table class="simple-table">
                    <tr>
                        <th>Niveau</th>
                        <th>Nombre</th>
                    </tr>
                    <?php foreach ($niveaux as $niv): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($niv['niveau']); ?></td>
                        <td><?php echo $niv['count']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <!-- Derniers entraînements de la semaine -->
        <div class="recent-section">
            <h3>Entraînements de la Semaine</h3>
            <?php if (empty($stats['entrainements_semaine_list'])): ?>
                <p>Aucun entraînement cette semaine</p>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Lieu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['entrainements_semaine_list'] as $entrainement): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entrainement['titre']); ?></td>
                            <td><?php echo htmlspecialchars($entrainement['date_entrainement']); ?></td>
                            <td><?php echo htmlspecialchars($entrainement['heure_debut']); ?></td>
                            <td><?php echo htmlspecialchars($entrainement['lieu']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>


