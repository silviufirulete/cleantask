<?php
class Env {
    /**
     * Incarca variabilele de mediu din fisierul .env
     * @param string $path Calea catre fisierul .env
     */
    public static function load($path) {
        if (!file_exists($path)) {
            // Daca fisierul nu exista, nu facem nimic (sau putem arunca o eroare)
            return;
        }

        // Citim fisierul linie cu linie, ignorand liniile goale noi
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            $line = trim($line);

            // Ignoram comentariile (linii care incep cu #) si liniile goale
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            // Cautam separatorul '='
            if (strpos($line, '=') !== false) {
                // Spargem linia in Key si Value, maxim 2 elemente
                list($name, $value) = explode('=', $line, 2);
                
                $name = trim($name);
                $value = trim($value);

                // Daca variabila nu exista deja in server/env, o setam
                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    putenv(sprintf('%s=%s', $name, $value));
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }
}