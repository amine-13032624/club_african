<?php
// Controllers are instantiated in index.php
$entrainements = $entrainementController->getAll();
$page_title = 'Planning des Entraînements';

$controller = new EntrainementController();
$entrainements = $controller->getAll();
$page_title = 'Planning des Entraînements';
?>





    <?php // header included in index.php; ?>
    
    <div class="page-header">
            <h1>Planning des Entraînements</h1>
            <a href="index.php?page=entrainements&action=ajouter" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un Entraînement
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="calendar-container">
            <div class="training-list">
                <?php if (empty($entrainements)): ?>
                    <p class="empty-state">Aucun entraînement programmé</p>
                <?php else: ?>
                    <?php 
                    // Grouper par date
                    $entrainementsByDate = [];
                    foreach ($entrainements as $entrainement) {
                        $date = $entrainement['date_entrainement'];
                        if (!isset($entrainementsByDate[$date])) {
                            $entrainementsByDate[$date] = [];
                        }
                        $entrainementsByDate[$date][] = $entrainement;
                    }
                    
                    ksort($entrainementsByDate);
                    foreach ($entrainementsByDate as $date => $items): ?>
                        <div class="date-group">
                            <h3><i class="fas fa-calendar"></i> <?php echo date('d/m/Y l', strtotime($date)); ?></h3>
                            <div class="entrainements-list">
                                <?php foreach ($items as $entrainement): ?>
                                <div class="entrainement-card">
                                    <div class="card-header">
                                        <h4><?php echo htmlspecialchars($entrainement['titre']); ?></h4>
                                        <span class="badge"><?php echo htmlspecialchars($entrainement['type']); ?></span>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Heure:</strong> <?php echo htmlspecialchars($entrainement['heure_debut']); ?> - <?php echo htmlspecialchars($entrainement['heure_fin']); ?></p>
                                        <p><strong>Lieu:</strong> <?php echo htmlspecialchars($entrainement['lieu']); ?></p>
                                        <p><strong>Niveau:</strong> <?php echo htmlspecialchars($entrainement['niveau']); ?></p>
                                        <p><strong>Description:</strong> <?php echo htmlspecialchars($entrainement['description']); ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="index.php?page=entrainements&action=editer&id=<?php echo $entrainement['id_entrainement']; ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?page=entrainements&action=supprimer&id=<?php echo $entrainement['id_entrainement']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>


