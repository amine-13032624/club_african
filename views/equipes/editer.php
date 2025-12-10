<?php
// This file is included from index.php
$id_equipe = isset($_GET['id']) ? intval($_GET['id']) : null;
$equipe = null;
$entraineursOptions = [];

if ($id_equipe) {
    try {
        $result = $equipeController->getEquipeById($id_equipe);
        if (isset($result['data'])) {
            $equipe = $result['data'][0];
        }
    } catch (Exception $e) {
        $error = "Erreur lors du chargement de l'équipe.";
    }
} else {
    header("Location: index.php?page=equipes");
    exit;
}

// Get trainers for dropdown
try {
    $database = new Database();
    $pdo = $database->getConnection();
    $stmt = $pdo->query("SELECT e.id_entraineur, m.nom, m.prenom FROM entraineur e JOIN membre m ON e.id_membre = m.id_membre ORDER BY m.nom");
    $entraineursOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $entraineursOptions = [];
}
?>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2">
            <h2>Éditer l'équipe</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($equipe): ?>
            <form id="equipeForm" class="form-container">
                <input type="hidden" id="id" value="<?php echo htmlspecialchars($equipe['id_equipe']); ?>">
                
                <div class="form-group">
                    <label for="nom">Nom de l'équipe *</label>
                    <input 
                        type="text" 
                        id="nom" 
                        name="nom" 
                        class="form-control" 
                        value="<?php echo htmlspecialchars($equipe['nom']); ?>" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="sport">Sport *</label>
                    <input 
                        type="text" 
                        id="sport" 
                        name="sport" 
                        class="form-control" 
                        value="<?php echo htmlspecialchars($equipe['sport']); ?>" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="discipline">Discipline</label>
                    <input 
                        type="text" 
                        id="discipline" 
                        name="discipline" 
                        class="form-control" 
                        value="<?php echo htmlspecialchars($equipe['discipline'] ?? ''); ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="nombre_joueurs">Nombre de joueurs</label>
                    <input 
                        type="number" 
                        id="nombre_joueurs" 
                        name="nombre_joueurs" 
                        class="form-control" 
                        min="0"
                        value="<?php echo htmlspecialchars($equipe['nombre_joueurs'] ?? 0); ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="id_entraineur_principal">Entraîneur principal</label>
                    <select id="id_entraineur_principal" name="id_entraineur_principal" class="form-control">
                        <option value="">-- Aucun --</option>
                        <?php foreach ($entraineursOptions as $entraineur): ?>
                            <option 
                                value="<?php echo htmlspecialchars($entraineur['id_entraineur']); ?>"
                                <?php echo ($equipe['id_entraineur_principal'] == $entraineur['id_entraineur']) ? 'selected' : ''; ?>
                            >
                                <?php echo htmlspecialchars($entraineur['prenom'] . ' ' . $entraineur['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="couleur_principale">Couleur principale</label>
                        <input 
                            type="color" 
                            id="couleur_principale" 
                            name="couleur_principale" 
                            class="form-control" 
                            value="<?php echo htmlspecialchars($equipe['couleur_principale'] ?? '#000000'); ?>"
                        >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="couleur_secondaire">Couleur secondaire</label>
                        <input 
                            type="color" 
                            id="couleur_secondaire" 
                            name="couleur_secondaire" 
                            class="form-control" 
                            value="<?php echo htmlspecialchars($equipe['couleur_secondaire'] ?? '#ffffff'); ?>"
                        >
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    <a href="index.php?page=equipes" class="btn btn-secondary">Annuler</a>
                </div>
            </form>

            <script>
                document.getElementById('equipeForm').addEventListener('submit', async (e) => {
                    e.preventDefault();
                    
                    const formData = {
                        id: document.getElementById('id').value,
                        nom: document.getElementById('nom').value,
                        sport: document.getElementById('sport').value,
                        discipline: document.getElementById('discipline').value || null,
                        id_entraineur_principal: document.getElementById('id_entraineur_principal').value || null,
                        nombre_joueurs: parseInt(document.getElementById('nombre_joueurs').value) || 0,
                        couleur_principale: document.getElementById('couleur_principale').value,
                        couleur_secondaire: document.getElementById('couleur_secondaire').value
                    };
                    
                    try {
                        const response = await fetch('api/equipe/modifier.php', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify(formData)
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            alert('Équipe modifiée avec succès!');
                            window.location.href = 'index.php?page=equipes';
                        } else {
                            alert('Erreur: ' + result.message);
                        }
                    } catch (error) {
                        alert('Erreur lors de la modification: ' + error.message);
                    }
                });
            </script>
            <?php else: ?>
                <div class="alert alert-warning">Équipe non trouvée.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>

<style>
    .form-container {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
    }

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
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

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #545b62;
    }
</style>
