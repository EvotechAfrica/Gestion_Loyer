<?php
// Récupération des contrats (requêtes préparées)
try {
    $stmt = $pdo->prepare("SELECT * FROM contrats ORDER BY created_at DESC");
    $stmt->execute();
    $contrats = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Erreur de récupération des contrats: " . $e->getMessage());
    $contrats = [];
}

// Date automatique (aujourd'hui)
$date_automatique = date('Y-m-d');
// Date de paiement par défaut (dernier jour du mois en cours)
$date_paiement_par_defaut = date('Y-m-t');