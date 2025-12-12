<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/models/Contrat.php';

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['id'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $contrat = new Contrat($db);
        $contrat->id_contrat = $input['id'];
        $contrat->id_athlete = $input['id_athlete'] ?? null;
        $contrat->id_sponsor = $input['id_sponsor'] ?? null;
        $contrat->description = $input['description'] ?? '';
        $contrat->date_debut = $input['date_debut'] ?? null;
        $contrat->date_fin = $input['date_fin'] ?? null;
        $contrat->montant = $input['montant'] ?? 0;
        $contrat->statut = $input['statut'] ?? 'actif';
        $contrat->conditions = $input['conditions'] ?? '';
        $result = $contrat->modifier();
        echo json_encode(['success' => (bool)$result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
}
?>
