<?php
class AuthController {
    public function login() {
        // Preluam numele aplicatiei din .env sau folosim un default
        $appName = getenv('APP_NAME') ?: 'SonderApp';
        $pageTitle = "Login - " . $appName;
        
        // Verificam daca view-ul exista inainte sa il incarcam
        $viewPath = __DIR__ . '/../Views/auth/login.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Eroare: Nu gasesc fisierul de view: " . $viewPath . "<br>Verifica daca ai creat folderul <b>app/Views/auth</b> si fisierul <b>login.php</b>.");
        }
    }

    public function logout() {
        // Logout se va face in principal din JS (Firebase), 
        // dar aici putem distruge sesiunea PHP daca e cazul.
        session_destroy();
        header("Location: /login");
        exit;
    }
}