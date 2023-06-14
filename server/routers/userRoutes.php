<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/userController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    case preg_match('@^/user/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User();
        if ($method == 'GET') {
            $controller->getOneUsers($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
    case preg_match('@^/profile/update/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User();
        if ($method == 'POST') {
            $controller->updateInformationsForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/profile/deactivate/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User();
        if ($method == 'GET') {
            $controller->deactivateAccountForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
        
    case preg_match('@^/profile/reactivate/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User();
        if ($method == 'GET') {
            $controller->reactivateAccountForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/profile/delete/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User();
        if ($method == 'GET') {
            $controller->delectAccountForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case '/profile/signup':
        $controller = new User();
        if ($method == 'POST') {
            $controller->addStudent();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/profile/login':
        $controller = new User();
        if ($method == 'POST') {
            $controller->loginAccount();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/profile/logout':
        $controller = new User();
        if ($method == 'POST') {
            $controller->logoutAccount();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/user/profile/relation/search/([\w-]+)/([\w-]+)$@', $url, $matches) ? $url : '':
        $controller = new User();
        if ($method == 'GET') {
            $controller->searchRelation($matches[1], $matches[2]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    default:
    // si aucune route ne correspond j'envoie une erreur
    if($matched == false){

        http_response_code(200);
    }
    break;
}