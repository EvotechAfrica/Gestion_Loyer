<?php
// filepath: Gestion_Loyer/routes/web.php

require_once 'HomeController.php';

$router = new Router();

// Define routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/batiment', [HomeController::class, 'batiment']);
$router->get('/services', [HomeController::class, 'services']);
$router->get('/article', [HomeController::class, 'article']);
$router->get('/team', [HomeController::class, 'team']);
$router->get('/inscription', [HomeController::class, 'inscription']);
$router->get('/login', [HomeController::class, 'login']);

// Handle the request
$router->dispatch($_SERVER['REQUEST_URI']);
?>