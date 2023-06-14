<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/rubricController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    case preg_match('@^/rubric/get/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Rubric();
        if ($method == 'GET') {
            $controller->getRubricsForOnePage($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/rubric/add/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Rubric();
        if ($method == 'POST') {
            $controller->addOneRubricForOnePage($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/rubric/delete/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Rubric();
        if ($method == 'POST') {
            $controller->deleteRubricsForOnePage($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/rubric/update/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Rubric();
        if ($method == 'POST') {
            $controller->updateRubricsForOnePage($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    } 