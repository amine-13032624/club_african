<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/controllers/MembreController.php';

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['type_membre'])) {
    try {
        $controller = new MembreController();
        $type = strtolower($input['type_membre']);
        $id = null;
        if ($type === 'athlete') {
            $id = $controller->ajouterAthlete($input);
        } elseif ($type === 'entraineur') {
            $id = $controller->ajouterEntraineur($input);
        } elseif ($type === 'staff') {
            $id = $controller->ajouterStaff($input);
        } else {
            echo json_encode(['success' => false, 'message' => 'Type membre invalide']);
            exit;
        }
        echo json_encode(['success' => (bool)$id, 'id_membre' => $id]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
}
?>
