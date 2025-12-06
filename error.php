<?php
session_start();

$code = $_GET['code'] ?? '500';
$title = 'Erreur';
$message = 'Une erreur est survenue.';
$icon = 'fas fa-exclamation-circle';

switch ($code) {
    case '400':
        $title = 'Mauvaise Requête (400)';
        $message = 'La requête envoyée est mal formée ou invalide.';
        break;
    case '401':
        $title = 'Non Authentifié (401)';
        $message = 'Vous devez être connecté pour accéder à cette ressource.';
        break;
    case '403':
        $title = 'Accès Interdit (403)';
        $message = 'Vous n\'avez pas les permissions nécessaires pour accéder à cette ressource.';
        break;
    case '404':
        $title = 'Page Non Trouvée (404)';
        $message = 'La page ou la ressource que vous recherchez n\'existe pas.';
        break;
    case '500':
        $title = 'Erreur Serveur (500)';
        $message = 'Une erreur interne s\'est produite. Veuillez réessayer plus tard.';
        break;
    case '502':
        $title = 'Mauvaise Passerelle (502)';
        $message = 'Le serveur a reçu une réponse invalide. Veuillez réessayer plus tard.';
        break;
    case '503':
        $title = 'Service Indisponible (503)';
        $message = 'Le serveur est actuellement indisponible. Veuillez réessayer plus tard.';
        break;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Club Sportif</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .error-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 500px;
            text-align: center;
        }
        
        .error-code {
            font-size: 5rem;
            font-weight: bold;
            color: #e74c3c;
            margin: 0 0 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .error-icon {
            font-size: 3rem;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        
        .error-title {
            font-size: 1.8rem;
            color: #2c3e50;
            margin: 20px 0;
        }
        
        .error-message {
            color: #7f8c8d;
            font-size: 1rem;
            margin: 20px 0 30px 0;
            line-height: 1.6;
        }
        
        .error-actions {
            display: flex;
            gap: 10px;
            flex-direction: column;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="<?php echo $icon; ?>"></i>
        </div>
        <div class="error-code"><?php echo $code; ?></div>
        <h1 class="error-title"><?php echo $title; ?></h1>
        <p class="error-message"><?php echo $message; ?></p>
        
        <div class="error-actions">
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</body>
</html>
