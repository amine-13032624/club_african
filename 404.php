<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            flex-direction: column;
            text-align: center;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #e74c3c;
            margin: 0;
        }
        
        .error-message {
            font-size: 2rem;
            color: #2c3e50;
            margin: 1rem 0;
        }
        
        .error-description {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin: 1rem 0 2rem 0;
            max-width: 500px;
        }
        
        .error-icon {
            font-size: 5rem;
            color: #e74c3c;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include 'views/header.php'; ?>
    
    <div class="container">
        <div class="error-container">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <h1 class="error-code">404</h1>
            <h2 class="error-message">Page non trouvée</h2>
            <p class="error-description">
                Désolé, la page que vous recherchez n'existe pas ou a été supprimée.
            </p>
            
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
        </div>
    </div>
    
    <?php include 'views/footer.php'; ?>
</body>
</html>
