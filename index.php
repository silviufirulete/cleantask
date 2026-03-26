<?php
// --- DEBUG MODE (Poti sterge liniile astea cand esti live) ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// -----------------------------------------------------------

session_start();

// Base path (supports subdirectory installs e.g. /~cleantas/)
define('BASE_PATH', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));

// Cai fisiere
$envConfigPath = __DIR__ . '/app/Config/Env.php';
$envFilePath = __DIR__ . '/.env';

// Incarcare configuratie
if (file_exists($envConfigPath)) require_once $envConfigPath;
if (file_exists($envFilePath)) Env::load($envFilePath);

// Router
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
// Handle subdirectory installs (e.g. temp URL /~cleantas/)
$base = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($base && str_starts_with($uri, $base)) {
    $uri = trim(substr($uri, strlen($base)), '/');
}

// Incarcare Controllere
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';

switch ($uri) {
    case '':
    case 'login':
    case 'index.php':
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'dashboard':
        // Dashboard pentru Muncitori (User)
        $controller = new DashboardController();
        $controller->index();
        break;

    case 'admin':
        // Dashboard pentru Sefi (Admin)
        $controller = new DashboardController();
        $controller->adminIndex();
        break;

    default:
        http_response_code(404);
        echo "<h3>404 - Pagina nu a fost găsită</h3>";
        break;
}