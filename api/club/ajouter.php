<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/models/Club.php';

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $club = new Club($db);
        $club->nom = $input['nom'] ?? '';
        $club->adresse = $input['adresse'] ?? '';
        $club->telephone = $input['telephone'] ?? '';
        $club->email = $input['email'] ?? '';
        $result = $club->ajouter();
        echo json_encode(['success' => (bool)$result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>
