<?php
// This file is included from index.php
$id_equipe = isset($_GET['id']) ? intval($_GET['id']) : null;
$equipe = null;
$athletes = [];

if ($id_equipe) {
    try {
        $result = $equipeController->getEquipeById($id_equipe);
        if (isset($result['data']) && !empty($result['data'])) {
            $equipe = $result['data'][0];
            
            // Get athletes for this team
            $database = new Database();
            $pdo = $database->getConnection();
            
            $stmt = $pdo->prepare("
                SELECT a.*, m.nom, m.prenom, m.email, m.date_inscription
                FROM athlete a
                JOIN membre m ON a.id_membre = m.id_membre
                JOIN membre_equipe me ON m.id_membre = me.id_membre
                WHERE me.id_equipe = ?
                ORDER BY m.nom, m.prenom
            ");
            $stmt->execute([$id_equipe]);
            $athletes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {
        $error = "Erreur lors du chargement de l'équipe.";
    }
} else {
    header("Location: index.php?page=equipes");
    exit;
}
?>
?>
<div class="container">
    <div class="mt-5">
        <a href="index.php?page=equipes" class="btn-back">← Retour aux équipes</a>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($equipe): ?>
            <div class="team-profile">
                <div class="team-header">
                    <div class="team-colors">
                        <div class="color-main" style="background-color: <?php echo htmlspecialchars($equipe['couleur_principale']); ?>"></div>
                        <div class="color-secondary" style="background-color: <?php echo htmlspecialchars($equipe['couleur_secondaire']); ?>"></div>
                    </div>
                    
                    <div class="team-title">
                        <h1><?php echo htmlspecialchars($equipe['nom']); ?></h1>
                        <p class="team-sport"><?php echo htmlspecialchars($equipe['sport']); ?></p>
                    </div>
                    
                    <div class="team-actions-header">
                        <a href="index.php?page=equipes&action=editer&id=<?php echo $equipe['id_equipe']; ?>" class="btn btn-primary">Éditer</a>
                        <button onclick="deleteTeam(<?php echo $equipe['id_equipe']; ?>, '<?php echo htmlspecialchars($equipe['nom']); ?>')" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
                
                <div class="team-details-grid">
                    <div class="detail-card">
                        <h3>Informations générales</h3>
                        <div class="detail-info">
                            <div class="info-row">
                                <span class="label">Sport:</span>
                                <span class="value"><?php echo htmlspecialchars($equipe['sport']); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="label">Discipline:</span>
                                <span class="value"><?php echo isset($equipe['discipline']) && $equipe['discipline'] ? htmlspecialchars($equipe['discipline']) : '<em style="color: #999;">Non spécifiée</em>'; ?></span>
                            </div>
                            <div class="info-row">
                                <span class="label">Nombre de joueurs:</span>
                                <span class="value"><?php echo $equipe['nombre_joueurs']; ?></span>
                            </div>
                            <div class="info-row">
                                <span class="label">Entraîneur principal:</span>
                                <span class="value">
                                    <?php 
                                    if (isset($equipe['nom_entraineur'])) {
                                        echo htmlspecialchars($equipe['nom_entraineur'] . ' ' . $equipe['prenom_entraineur']);
                                    } else {
                                        echo '<em style="color: #999;">Non assigné</em>';
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="label">Date de création:</span>
                                <span class="value"><?php echo date('d/m/Y', strtotime($equipe['date_creation'])); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-card">
                        <h3>Couleurs de l'équipe</h3>
                        <div class="colors-display">
                            <div class="color-item">
                                <div class="color-preview" style="background-color: <?php echo htmlspecialchars($equipe['couleur_principale']); ?>"></div>
                                <span>Couleur principale</span>
                                <code><?php echo htmlspecialchars($equipe['couleur_principale']); ?></code>
                            </div>
                            <div class="color-item">
                                <div class="color-preview" style="background-color: <?php echo htmlspecialchars($equipe['couleur_secondaire']); ?>"></div>
                                <span>Couleur secondaire</span>
                                <code><?php echo htmlspecialchars($equipe['couleur_secondaire']); ?></code>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="athletes-section">
                    <h2>Athlètes de l'équipe (<?php echo count($athletes); ?>)</h2>
                    
                    <?php if (empty($athletes)): ?>
                        <div class="empty-athletes">
                            <p>Aucun athlète assigné à cette équipe pour le moment.</p>
                        </div>
                    <?php else: ?>
                        <div class="athletes-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Email</th>
                                        <th>Date d'inscription</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($athletes as $athlete): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($athlete['nom']); ?></td>
                                            <td><?php echo htmlspecialchars($athlete['prenom']); ?></td>
                                            <td><?php echo htmlspecialchars($athlete['email']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($athlete['date_inscription'])); ?></td>
                                            <td>
                                                <a href="index.php?page=membres&action=profil&id=<?php echo $athlete['id_membre']; ?>" class="btn-link">Voir profil</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Équipe non trouvée.</div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../footer.php'; ?>

<script>
    function deleteTeam(id, nom) {
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
                    window.location.href = 'index.php?page=equipes';
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

    .btn-back {
        display: inline-block;
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 20px;
        transition: color 0.3s;
    }

    .btn-back:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    .team-profile {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .team-header {
        display: flex;
        align-items: center;
        gap: 30px;
        padding: 30px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .team-colors {
        display: flex;
        gap: 15px;
    }

    .color-main, .color-secondary {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .team-title h1 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 32px;
    }

    .team-sport {
        margin: 0;
        color: #666;
        font-size: 18px;
    }

    .team-actions-header {
        margin-left: auto;
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .team-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        padding: 30px;
    }

    .detail-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 6px;
    }

    .detail-card h3 {
        margin: 0 0 15px 0;
        color: #333;
    }

    .detail-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .label {
        font-weight: 600;
        color: #555;
    }

    .value {
        color: #333;
    }

    .colors-display {
        display: flex;
        gap: 20px;
    }

    .color-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .color-preview {
        width: 100%;
        height: 100px;
        border-radius: 6px;
        margin-bottom: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .color-item span {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }

    .color-item code {
        background: #e9ecef;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        color: #555;
    }

    .athletes-section {
        padding: 30px;
        border-top: 1px solid #eee;
    }

    .athletes-section h2 {
        margin: 0 0 20px 0;
        color: #333;
    }

    .empty-athletes {
        text-align: center;
        padding: 40px 20px;
        background: #f8f9fa;
        border-radius: 6px;
        color: #666;
    }

    .athletes-table {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead {
        background-color: #f8f9fa;
    }

    table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #dee2e6;
    }

    table td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
        color: #555;
    }

    table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .btn-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }

    .btn-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .team-header {
            flex-direction: column;
            text-align: center;
        }

        .team-title h1 {
            font-size: 24px;
        }

        .team-actions-header {
            margin-left: 0;
            width: 100%;
        }

        .team-details-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
