<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/models/Competition.php';

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $competition = new Competition($db);
        $competition->nom = $input['nom'] ?? '';
        $competition->date_competition = $input['date_competition'] ?? null;
        $competition->lieu = $input['lieu'] ?? '';
        $competition->type = $input['type'] ?? '';
        $competition->niveau = $input['niveau'] ?? '';
        $competition->id_equipe = $input['id_equipe'] ?? null;
        $competition->nombre_participants = $input['nombre_participants'] ?? 0;
        $result = $competition->ajouter();
        echo json_encode(['success' => (bool)$result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>
