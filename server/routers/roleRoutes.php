<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/roleController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    case preg_match('@^/role/update/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Role();
        if ($method == 'POST') {
            $controller->ifAdminUpdateRole($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/role/delete/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Role();
        if ($method == 'POST') {
            $controller->ifAdminDeleteRole($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/role/add/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Role();
        if ($method == 'POST') {
            $controller->ifAdminAddRole($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    } 