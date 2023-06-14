<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/publicationController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    case preg_match('@^/publications/get/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Publication();
        if ($method == 'GET') {
            $controller->getAllPublicationsInGroup($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
        
    case preg_match('@^/publication/get/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Publication();
        if ($method == 'GET') {
            $controller->getOnePublication($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/publication/add/(\d+)/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Publication();
        if ($method == 'POST') {
            $controller->addPublicationInGroup($matches[1] , $matches[2]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    
    case preg_match('@^/publication/update/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Publication();
        if ($method == 'POST') {
            $controller->updatePublication($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    case preg_match('@^/publication/delete/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Publication();
        if ($method == 'POST') {
            $controller->deletePublication($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
}