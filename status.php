<?php
/**
 * Page d'état et de santé de l'application
 */

session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>État de l'Application - Club Sportif</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .status-page {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .status-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .status-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #95a5a6;
        }
        
        .status-card.ok {
            border-left-color: #27ae60;
        }
        
        .status-card.error {
            border-left-color: #e74c3c;
        }
        
        .status-card.warning {
            border-left-color: #f39c12;
        }
        
        .status-card h3 {
            color: #2c3e50;
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .status-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #3498db;
            margin: 10px 0;
        }
        
        .status-info {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        
        .icon-circle {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            color: white;
            font-size: 0.8rem;
        }
        
        .icon-circle.ok {
            background: #27ae60;
        }
        
        .icon-circle.error {
            background: #e74c3c;
        }
        
        .icon-circle.warning {
            background: #f39c12;
        }
        
        .section {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .section h2 {
            color: #2c3e50;
            margin-top: 0;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }
        
        .info-list {
            list-style: none;
            padding: 0;
        }
        
        .info-list li {
            padding: 10px 0;
            border-bottom: 1px solid #ecf0f1;
            display: flex;
            justify-content: space-between;
        }
        
        .info-list li:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .info-value {
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <?php include 'views/header.php'; ?>
    
    <div class="container status-page">
        <div class="status-header">
            <h1>État de l'Application</h1>
            <p>Vérification du statut et des performances</p>
        </div>
        
        <!-- Cartes de statut principales -->
        <div class="status-grid">
            <div class="status-card ok">
                <h3>
                    <span class="icon-circle ok">✓</span>
                    Application
                </h3>
                <div class="status-value">En ligne</div>
                <div class="status-info">Version 1.0.0</div>
            </div>
            
            <?php
            $db_status = 'Erreur';
            $db_class = 'error';
            try {
                require_once 'config/database.php';
                $db = new Database();
                $conn = $db->getConnection();
                $db_status = 'Connectée';
                $db_class = 'ok';
            } catch (Exception $e) {
                $db_class = 'error';
            }
            ?>
            
            <div class="status-card <?php echo $db_class; ?>">
                <h3>
                    <span class="icon-circle <?php echo $db_class; ?>">
                        <?php echo $db_class === 'ok' ? '✓' : '✕'; ?>
                    </span>
                    Base de Données
                </h3>
                <div class="status-value"><?php echo $db_status; ?></div>
                <div class="status-info">MySQL 5.7+</div>
            </div>
            
            <div class="status-card ok">
                <h3>
                    <span class="icon-circle ok">✓</span>
                    Sessions
                </h3>
                <div class="status-value">
                    <?php echo isset($_SESSION['user_id']) ? 'Connecté' : 'Anonyme'; ?>
                </div>
                <div class="status-info">Session active</div>
            </div>
            
            <div class="status-card ok">
                <h3>
                    <span class="icon-circle ok">✓</span>
                    Serveur
                </h3>
                <div class="status-value">Apache</div>
                <div class="status-info">PHP <?php echo PHP_VERSION; ?></div>
            </div>
        </div>
        
        <!-- Système -->
        <div class="section">
            <h2>Informations Système</h2>
            <ul class="info-list">
                <li>
                    <span class="info-label">Serveur Web</span>
                    <span class="info-value"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Inconnu'; ?></span>
                </li>
                <li>
                    <span class="info-label">PHP Version</span>
                    <span class="info-value"><?php echo PHP_VERSION; ?></span>
                </li>
                <li>
                    <span class="info-label">Système d'exploitation</span>
                    <span class="info-value"><?php echo php_uname('s'); ?></span>
                </li>
                <li>
                    <span class="info-label">Architecture</span>
                    <span class="info-value"><?php echo php_uname('m'); ?></span>
                </li>
                <li>
                    <span class="info-label">Répertoire actuel</span>
                    <span class="info-value"><?php echo __DIR__; ?></span>
                </li>
                <li>
                    <span class="info-label">Espace disque libre</span>
                    <span class="info-value"><?php 
                        $free = disk_free_space(__DIR__);
                        $total = disk_total_space(__DIR__);
                        echo $free ? number_format($free / 1024 / 1024 / 1024, 2) . ' GB' : 'Inconnu';
                    ?></span>
                </li>
            </ul>
        </div>
        
        <!-- Extensions PHP -->
        <div class="section">
            <h2>Extensions PHP</h2>
            <ul class="info-list">
                <li>
                    <span class="info-label">PDO</span>
                    <span class="info-value">
                        <?php echo extension_loaded('pdo') ? '✓ Activé' : '✕ Désactivé'; ?>
                    </span>
                </li>
                <li>
                    <span class="info-label">PDO MySQL</span>
                    <span class="info-value">
                        <?php echo extension_loaded('pdo_mysql') ? '✓ Activé' : '✕ Désactivé'; ?>
                    </span>
                </li>
                <li>
                    <span class="info-label">Gzip (Compression)</span>
                    <span class="info-value">
                        <?php echo extension_loaded('zlib') ? '✓ Activé' : '✕ Désactivé'; ?>
                    </span>
                </li>
                <li>
                    <span class="info-label">OpenSSL</span>
                    <span class="info-value">
                        <?php echo extension_loaded('openssl') ? '✓ Activé' : '✕ Désactivé'; ?>
                    </span>
                </li>
                <li>
                    <span class="info-label">JSON</span>
                    <span class="info-value">
                        <?php echo extension_loaded('json') ? '✓ Activé' : '✕ Désactivé'; ?>
                    </span>
                </li>
            </ul>
        </div>
        
        <!-- Configuration -->
        <div class="section">
            <h2>Configuration Importante</h2>
            <ul class="info-list">
                <li>
                    <span class="info-label">Upload de fichiers</span>
                    <span class="info-value"><?php echo ini_get('file_uploads') ? '✓ Activé' : '✕ Désactivé'; ?></span>
                </li>
                <li>
                    <span class="info-label">Max Upload Size</span>
                    <span class="info-value"><?php echo ini_get('upload_max_filesize'); ?></span>
                </li>
                <li>
                    <span class="info-label">Max POST Size</span>
                    <span class="info-value"><?php echo ini_get('post_max_size'); ?></span>
                </li>
                <li>
                    <span class="info-label">Max Execution Time</span>
                    <span class="info-value"><?php echo ini_get('max_execution_time'); ?> sec</span>
                </li>
                <li>
                    <span class="info-label">Memory Limit</span>
                    <span class="info-value"><?php echo ini_get('memory_limit'); ?></span>
                </li>
                <li>
                    <span class="info-label">Session Timeout</span>
                    <span class="info-value"><?php echo ini_get('session.gc_maxlifetime'); ?> sec</span>
                </li>
            </ul>
        </div>
        
        <!-- Actions -->
        <div class="section" style="text-align: center;">
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
            <a href="check.php" class="btn btn-secondary">
                <i class="fas fa-cog"></i> Vérification détaillée
            </a>
        </div>
    </div>
    
    <?php include 'views/footer.php'; ?>
</body>
</html>
