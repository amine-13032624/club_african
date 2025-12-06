<?php
/**
 * Vérificateur d'environnement pour Club Sportif
 */

$checks = [
    'PHP Version' => [
        'status' => version_compare(PHP_VERSION, '7.4', '>='),
        'current' => PHP_VERSION,
        'required' => '7.4+'
    ],
    'PDO' => [
        'status' => extension_loaded('pdo'),
        'current' => extension_loaded('pdo') ? 'Installé' : 'Non installé'
    ],
    'PDO MySQL' => [
        'status' => extension_loaded('pdo_mysql'),
        'current' => extension_loaded('pdo_mysql') ? 'Installé' : 'Non installé'
    ],
    'Sessions' => [
        'status' => ini_get('session.use_cookies'),
        'current' => ini_get('session.use_cookies') ? 'Activé' : 'Désactivé'
    ],
    'Upload' => [
        'status' => ini_get('file_uploads'),
        'current' => ini_get('file_uploads') ? 'Activé' : 'Désactivé'
    ],
    'Permissions dossier uploads' => [
        'status' => is_writable(__DIR__),
        'current' => is_writable(__DIR__) ? 'Accessible' : 'Non accessible'
    ]
];

// Tester la connexion à la base de données
$db_status = 'Non vérifiée';
$db_color = '#f39c12';
try {
    require_once 'config/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $db_status = 'Connectée';
    $db_color = '#27ae60';
} catch (Exception $e) {
    $db_status = 'Erreur: ' . $e->getMessage();
    $db_color = '#e74c3c';
}

$all_ok = true;
foreach ($checks as $check) {
    if (!$check['status']) {
        $all_ok = false;
        break;
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérificateur d'Environnement - Club Sportif</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            padding: 30px;
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .subtitle {
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-ok .status-indicator {
            background: #27ae60;
        }
        
        .status-error .status-indicator {
            background: #e74c3c;
        }
        
        .status-warning .status-indicator {
            background: #f39c12;
        }
        
        .check-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ecf0f1;
            transition: background 0.3s;
        }
        
        .check-item:hover {
            background: #f8f9fa;
        }
        
        .check-item:last-child {
            border-bottom: none;
        }
        
        .check-name {
            font-weight: 500;
            color: #2c3e50;
        }
        
        .check-value {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .db-status {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            text-align: center;
        }
        
        .db-status h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .db-status-value {
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d5f4e6;
            color: #27ae60;
            border-left: 4px solid #27ae60;
        }
        
        .alert-error {
            background: #fadbd8;
            color: #e74c3c;
            border-left: 4px solid #e74c3c;
        }
        
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            <span style="font-size: 1.5rem;">⚙️</span>
            Vérificateur d'Environnement
        </h1>
        <p class="subtitle">Club Sportif - Vérification de la configuration</p>
        
        <?php if ($all_ok): ?>
            <div class="alert alert-success">
                ✓ Tous les contrôles sont passés! L'environnement est prêt.
            </div>
        <?php else: ?>
            <div class="alert alert-error">
                ✗ Certains contrôles ont échoué. Veuillez corriger les problèmes.
            </div>
        <?php endif; ?>
        
        <!-- Vérifications -->
        <?php foreach ($checks as $name => $check): ?>
        <div class="check-item <?php echo $check['status'] ? 'status-ok' : 'status-error'; ?>">
            <div>
                <span class="status-indicator"></span>
                <span class="check-name"><?php echo $name; ?></span>
            </div>
            <span class="check-value">
                <?php echo isset($check['current']) ? $check['current'] : ''; ?>
                <?php if (isset($check['required'])): ?>
                    <small>(requis: <?php echo $check['required']; ?>)</small>
                <?php endif; ?>
            </span>
        </div>
        <?php endforeach; ?>
        
        <!-- Base de données -->
        <div class="db-status">
            <h3>Base de Données</h3>
            <div class="db-status-value" style="background: <?php echo $db_color; ?>; color: white;">
                <?php echo $db_status; ?>
            </div>
        </div>
        
        <!-- Informations du serveur -->
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; font-size: 0.9rem; color: #7f8c8d;">
            <strong>Informations du serveur:</strong><br>
            OS: <?php echo php_uname('s'); ?><br>
            Serveur: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Inconnu'; ?><br>
            Espace disque: <?php echo format_bytes(disk_free_space(__DIR__)); ?>
        </div>
        
        <!-- Actions -->
        <div class="actions">
            <a href="index.php" class="btn btn-primary">Accueil</a>
            <a href="install.php" class="btn btn-secondary">Installer</a>
        </div>
    </div>
    
    <script>
        function format_bytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }
        
        // Afficher l'espace disque en format lisible (version PHP)
        <?php
        function format_bytes($bytes) {
            if ($bytes === 0) return '0 Bytes';
            $k = 1024;
            $sizes = ['Bytes', 'KB', 'MB', 'GB'];
            $i = floor(log($bytes) / log($k));
            return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
        }
        ?>
    </script>
</body>
</html>
