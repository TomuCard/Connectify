<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/commentController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    case preg_match('@^/comment/get/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Comment();
        if ($method == 'GET') {
            $controller->getAllCommentsForOnePublication($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
        
    case preg_match('@^/comment/add/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Comment();
        if ($method == 'POST') {
            $controller->addCommentInOnePublication($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/comment/update/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Comment();
        if ($method == 'POST') {
            $controller->ifAuthorUpdateComment($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    
    case preg_match('@^/comment/delete/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Comment();
        if ($method == 'POST') {
            $controller->ifAuthorDeleteComment($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
}