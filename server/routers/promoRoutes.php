<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/promoController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    case '/promo/get':
        $controller = new Promo();
        if ($method == 'GET') {
            $controller->getAllPromos();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
    case preg_match('@^/promo/get/post/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Promo();
        if ($method == 'GET') {
            $controller->getOnePromo($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
    case '/promo/add':
        $controller = new Promo();
        if ($method == 'POST') {
                $controller->addPromoIfAdmin();
                $matched = true;
        } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: POST');
        };
        break;
    case preg_match('@^/promo/delete/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Promo();
        if ($method == 'POST') {
            $controller->deletePromoIfAdmin($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    case preg_match('@^/promo/update/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Promo();
        if ($method == 'POST') {
            $controller->updatePromoIfAdmin($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
}