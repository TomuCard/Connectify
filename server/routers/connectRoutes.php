<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/connectController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    case preg_match('@^/relation/search/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Connect();
        if ($method == 'GET') {
            $controller->getRelationForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/relation/add/(\d+)$@', $url, $matches) ? $url : '':
        session_start();
        $controller = new Connect();
        if ($method == 'GET') {
            $controller->addRelationForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/relation/delete/(\d+)$@', $url, $matches) ? $url : '':
        session_start();
        $controller = new Connect();
        if ($method == 'POST') {
            $controller->deleteRelationForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    } 