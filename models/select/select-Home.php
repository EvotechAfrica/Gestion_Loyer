<?php
// filepath: c:\xampp\htdocs\Gestion_Loyer\models\select\select-Home.php

function getArticles($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM articles ORDER BY date DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAboutInfo($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM about");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>