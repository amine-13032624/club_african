<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/models/Performance.php';

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['id'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $performance = new Performance($db);
        $performance->id_performance = $input['id'];
        $performance->id_athlete = $input['id_athlete'] ?? null;
        $performance->id_competition = $input['id_competition'] ?? null;
        $performance->type_performance = $input['type_performance'] ?? null;
        $performance->valeur = $input['valeur'] ?? null;
        $performance->unite = $input['unite'] ?? null;
        $performance->date_performance = $input['date_performance'] ?? null;
        $performance->commentaire = $input['commentaire'] ?? null;
        $result = $performance->modifier();
        echo json_encode(['success' => (bool)$result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
}
?>
