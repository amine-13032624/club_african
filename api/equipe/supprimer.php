<?php
header('Content-Type: application/json');

require_once '../../config/database.php';
require_once '../../controllers/EquipeController.php';

// Get JSON data
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['id'])) {
    try {
        $controller = new EquipeController();
        $result = $controller->supprimer($input['id']);
        
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
        'message' => 'Requête invalide'
    ]);
}
?>
