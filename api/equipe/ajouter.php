<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/controllers/EquipeController.php';

// Get JSON data
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $controller = new EquipeController();
        $result = $controller->ajouter($input);
        
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur serveur: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ]);
}
?>
