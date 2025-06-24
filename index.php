<?php
# DB connection
include 'connexion/connexion.php';
# Routing
require_once 'routes/web.php';
class Router {
    public function __construct() {
        // Initialisation du routeur
    }

    public function get($route, $callback) {
        // Logique pour gérer les routes GET
    }

    public function post($route, $callback) {
        // Logique pour gérer les routes POST
    }
    public function dispatch() {
        // // Logique pour traiter la requête et appeler la bonne route
        // echo "Dispatch appelé";
    }

}
// Start the session
session_start();

// Tableau des pages disponibles (nom => fichier)
$pages = [
    'home'      => 'views/home.php',
    'batiment'  => 'views/Batiment.php',
    'chambre'   => 'views/Chambre.php',
    'locataire' => 'views/Locataire.php',
    'paiement'  => 'views/Paiement.php',
    // Ajoute d'autres pages ici
];

// Récupérer la page demandée
$page = $_GET['page'] ?? 'home';

// Charger la page si elle existe, sinon charger home
if (array_key_exists($page, $pages)) {
    include $pages[$page];
} else {
    include $pages['home'];
}
?>