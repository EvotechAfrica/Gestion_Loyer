<?php
class HomeController {
    public function index() {
        // Load the home view
        include_once '../views/home.php';
    }

    public function about() {
        // Load the about view
        include_once '../views/about.php';
    }

    public function services() {
        // Load the services view
        include_once '../views/services.php';
    }

    public function article() {
        // Load the article view
        include_once '../views/article.php';
    }

    public function team() {
        // Load the team view
        include_once '../views/team.php';
    }

    public function inscription() {
        // Load the inscription view
        include_once '../views/inscription.php';
    }

    public function login() {
        // Load the login view
        include_once '../views/login.php';
    }
}
?>