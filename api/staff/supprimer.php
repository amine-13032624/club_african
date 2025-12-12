<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/controllers/MembreController.php';

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['id'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $stmt = $db->prepare("SELECT id_membre FROM staff WHERE id_staff = ?");
        $stmt->execute([$input['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo json_encode(['success' => false, 'message' => 'Staff introuvable']);
            exit;
        }
        $controller = new MembreController();
        $result = $controller->supprimerMembre($row['id_membre']);
        echo json_encode(['success' => (bool)$result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
}
?>
