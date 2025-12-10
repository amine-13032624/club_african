<?php
// This file is included from index.php, so controller is already instantiated
$controller = $equipeController;
$equipes = $controller->getTousEquipes();
?>

<div class="container">
    <div class="header-section">
        <h1>Équipes du Club</h1>
        <a href="index.php?page=equipes&action=ajouter" class="btn-add">+ Ajouter une équipe</a>
    </div>
    
    <?php if (empty($equipes)): ?>
        <div class="empty-state">
            <p>Aucune équipe trouvée.</p>
            <a href="index.php?page=equipes&action=ajouter" class="btn-add">Créer la première équipe</a>
        </div>
    <?php else: ?>
        <div class="equipes-grid">
            <?php foreach ($equipes as $equipe): ?>
                <div class="equipe-card">
                    <div class="equipe-header">
                        <div class="equipe-colors">
                            <div class="color-box" style="background-color: <?php echo htmlspecialchars($equipe['couleur_principale']); ?>"></div>
                            <div class="color-box" style="background-color: <?php echo htmlspecialchars($equipe['couleur_secondaire']); ?>"></div>
                        </div>
                        <div class="equipe-info">
                            <h2><?php echo htmlspecialchars($equipe['nom']); ?></h2>
                        </div>
                    </div>
                    
                    <div class="equipe-details">
                        <div class="detail-row">
                            <span class="detail-label">Sport:</span>
                            <span><?php echo htmlspecialchars($equipe['sport']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Discipline:</span>
                            <span><?php echo isset($equipe['discipline']) && $equipe['discipline'] ? htmlspecialchars($equipe['discipline']) : '-'; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Joueurs:</span>
                            <span><?php echo $equipe['nombre_joueurs']; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Entraîneur:</span>
                            <span><?php echo isset($equipe['nom_entraineur']) ? htmlspecialchars($equipe['nom_entraineur'] . ' ' . $equipe['prenom_entraineur']) : 'Non assigné'; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Créée:</span>
                            <span><?php echo date('d/m/Y', strtotime($equipe['date_creation'])); ?></span>
                        </div>
                    </div>
                    
                    <div class="equipe-actions">
                        <button class="btn-action btn-view" onclick="viewEquipe(<?php echo $equipe['id_equipe']; ?>)">Voir</button>
                        <button class="btn-action btn-edit" onclick="editEquipe(<?php echo $equipe['id_equipe']; ?>)">Éditer</button>
                        <button class="btn-action btn-delete" onclick="deleteEquipe(<?php echo $equipe['id_equipe']; ?>, '<?php echo htmlspecialchars($equipe['nom']); ?>')">Supprimer</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function viewEquipe(id) {
        window.location.href = 'index.php?page=equipes&action=profil&id=' + id;
    }
    
    function editEquipe(id) {
        window.location.href = 'index.php?page=equipes&action=editer&id=' + id;
    }
    
    function deleteEquipe(id, nom) {
        if (confirm('Êtes-vous sûr de vouloir supprimer l\'équipe "' + nom + '"?')) {
            fetch('api/equipe/supprimer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => alert('Erreur: ' + error.message));
        }
    }
</script>

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .header-section h1 {
        margin: 0;
        color: #333;
    }
    
    .btn-add {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s;
    }
    
    .btn-add:hover {
        background-color: #45a049;
    }
    
    .equipes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .equipe-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .equipe-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    
    .equipe-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .equipe-colors {
        display: flex;
        gap: 5px;
        margin-right: 15px;
    }
    
    .color-box {
        width: 30px;
        height: 30px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }
    
    .equipe-info h2 {
        margin: 0;
        color: #333;
        font-size: 18px;
    }
    
    .equipe-details {
        margin: 15px 0;
        font-size: 14px;
        color: #666;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
    }
    
    .detail-label {
        font-weight: bold;
    }
    
    .equipe-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    
    .btn-action {
        flex: 1;
        padding: 8px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        transition: background 0.3s;
    }
    
    .btn-view {
        background-color: #2196F3;
        color: white;
    }
    
    .btn-view:hover {
        background-color: #0b7dda;
    }
    
    .btn-edit {
        background-color: #ff9800;
        color: white;
    }
    
    .btn-edit:hover {
        background-color: #e68900;
    }
    
    .btn-delete {
        background-color: #f44336;
        color: white;
    }
    
    .btn-delete:hover {
        background-color: #da190b;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state p {
        color: #666;
        font-size: 16px;
        margin-bottom: 20px;
    }
</style>

