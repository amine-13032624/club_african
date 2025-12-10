<?php
require_once 'config/database.php';

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    // Get trainers with JOIN
    $result = $pdo->query("SELECT e.id_entraineur, m.nom, m.prenom FROM entraineur e JOIN membre m ON e.id_membre = m.id_membre ORDER BY m.nom");
    $trainers = $result->fetchAll(PDO::FETCH_ASSOC);
    echo "Trainers found: " . count($trainers) . "\n";
    echo json_encode($trainers, JSON_PRETTY_PRINT) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
