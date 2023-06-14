<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/groupController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {

    // Route utilisateur de l'API
    case preg_match('@^/group/user/get/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Group();
        if ($method == 'GET') {
            $controller->getAllgroupForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
    
    case preg_match('@^/group/info/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Group();
        if ($method == 'GET') {
            $controller->getOnegroupInfo($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case '/group/create':
        $controller = new Group();
        if ($method == 'POST') {
            $controller->addGroupPublicOrPrivateForOneUser();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
        
    case preg_match('@^/group/join/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Group();
        if ($method == 'POST') {
            $controller->joinGroupPublicOrPrivateForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/group/relation/invite/(\d+)/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Group();
        if ($method == 'POST') {
            $controller->addRelationOnGroup($matches[1], $matches[2]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/group/member/accept/(\d+)/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Group();
        if ($method == 'GET') {
            $controller->acceptOrDeniedCandidateInGroup($matches[1], $matches[2]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/group/member/update/rights/(\d+)/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Group();
        if ($method == 'GET') {
            $controller->ifAdminSetOtherAdminInGroup($matches[1], $matches[2]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/group/member/banish/(\d+)/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Group();
        if ($method == 'GET') {
            $controller->ifAdminBanishMember($matches[1], $matches[2]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/group/update/info/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Group();
        if ($method == 'GET') {
            $controller->ifAdminUpdateGroupInfo($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

}