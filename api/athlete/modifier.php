<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/models/Athlete.php';

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['id'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $athlete = new Athlete($db);
        $result = $athlete->modifierProfil($input['id'], $input);
        echo json_encode(['success' => (bool)$result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
}
?>
