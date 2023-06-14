<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/memberController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    case preg_match('@^/group/quit/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Member();
        if ($method == 'POST') {
            $controller->quitGroup($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    } 