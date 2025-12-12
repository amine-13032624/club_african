<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../src/config/database.php';
require_once __DIR__ . '/../../src/models/Sponsor.php';

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $sponsor = new Sponsor($db);
        $sponsor->nom = $input['nom'] ?? '';
        $sponsor->secteur = $input['secteur'] ?? '';
        $sponsor->montant_contribution = $input['montant_contribution'] ?? 0;
        $sponsor->date_debut = $input['date_debut'] ?? null;
        $sponsor->date_fin = $input['date_fin'] ?? null;
        $sponsor->contact = $input['contact'] ?? '';
        $sponsor->telephone = $input['telephone'] ?? '';
        $sponsor->email = $input['email'] ?? '';
        $sponsor->statut = $input['statut'] ?? 'actif';
        $result = $sponsor->ajouter();
        echo json_encode(['success' => (bool)$result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>
