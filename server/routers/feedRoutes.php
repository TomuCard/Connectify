<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/feedController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    case preg_match('@^/profile/feed/get/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Feed();
        if ($method == 'GET') {
            $controller->getAllFeedsForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/profile/feed/delete/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Feed();
        if ($method == 'POST') {
            $controller->deleteFeedOfUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/profile/feed/update/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Feed();
        if ($method == 'POST') {
            $controller->updateFeedOfUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    
    case preg_match('@^/profile/feed/add/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Feed();
        if ($method == 'POST') {
            $controller->addFeedOfUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
         
    }