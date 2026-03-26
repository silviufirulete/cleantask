<?php
class DashboardController {
    public function index() {
        $pageTitle = "Dashboard - CleanTask";
        // Vom verifica auth in JS, aici doar servim structura
        require_once __DIR__ . '/../Views/user/dashboard.php';
    }

    public function adminIndex() {
        $pageTitle = "Dashboard - CleanTask";
        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }
}