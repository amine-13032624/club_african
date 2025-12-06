

<div class="dashboard-container-with-logos">
    <div class="dashboard-logo-left">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 200">
            <!-- Drapeau Palestine -->
            <!-- Bande noire en haut -->
            <rect x="0" y="0" width="300" height="66.67" fill="#000000"/>
            <!-- Bande blanche au milieu -->
            <rect x="0" y="66.67" width="300" height="66.67" fill="#FFFFFF"/>
            <!-- Bande verte en bas -->
            <rect x="0" y="133.34" width="300" height="66.66" fill="#007A5E"/>
            <!-- Triangle rouge à gauche -->
            <polygon points="0,0 0,200 80,100" fill="#DC143C"/>
        </svg>
    </div>

    <div class="dashboard-content">
    <div class="dashboard-header">
            <h1><i class="fas fa-tachometer-alt"></i> Tableau de bord</h1>
            <div class="stats-cards">
                <div class="stat-card">
                    <h3>Total Membres</h3>
                    <p class="stat-number"><?php echo $totalMembres; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Entraînements cette semaine</h3>
                    <p class="stat-number"><?php echo $entrainementsSemaine; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Paiements en attente</h3>
                    <p class="stat-number"><?php echo $paiementsAttente; ?></p>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-section">
                <h2><i class="fas fa-users"></i> Gestion des Membres</h2>
                <div class="quick-actions">
                    <a href="index.php?page=membres&action=ajouter" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Ajouter un membre
                    </a>
                    <a href="index.php?page=membres" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Voir tous les membres
                    </a>
                </div>
            </div>

            <div class="dashboard-section">
                <h2><i class="fas fa-calendar-alt"></i> Planning des entraînements</h2>
                <div id="calendar"></div>
            </div>

            <div class="dashboard-section">
                <h2><i class="fas fa-chart-line"></i> Statistiques récentes</h2>
                <canvas id="statsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="dashboard-logo-right">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 200">
            <!-- Drapeau Palestine -->
            <!-- Bande noire en haut -->
            <rect x="0" y="0" width="300" height="66.67" fill="#000000"/>
            <!-- Bande blanche au milieu -->
            <rect x="0" y="66.67" width="300" height="66.67" fill="#FFFFFF"/>
            <!-- Bande verte en bas -->
            <rect x="0" y="133.34" width="300" height="66.66" fill="#007A5E"/>
            <!-- Triangle rouge à gauche -->
            <polygon points="0,0 0,200 80,100" fill="#DC143C"/>
        </svg>
    </div>
</div>

