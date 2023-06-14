<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';

// Création du controller users

class User {

    function getOneUsers($id){

        // j'appelle l'objet base de donnée
        $db = new Database();

        // je me connecte à la BDD avec la fonction getconnexion de l'objet Database
        $connexion = $db->getconnection();

        // je prépare la requête
        $request = $connexion->prepare("
        SELECT * 
        FROM user
        JOIN promo
        ON user.promo_id = promo.id 
        WHERE user.id = :id
        ");
        // j'exécute la requête
        $request->execute([':id' => $id]);
        // je récupère tous les résultats dans users
        $user = $request->fetch(PDO::FETCH_ASSOC);
        // je ferme la connexion
        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($user);
    }
    
    function updateInformationsForOneUser($id){
        // connexion la BDD
        $db = new Database();

        // Ouverture de la connexion
        $connexion = $db->getconnection();
        // je récupère les champs du formulaire signin
        $username = $_POST['username'];
        $picture = $_FILES['picture'];
        $banner = $_FILES['banner'];
        $description = $_POST['description'];

        $pictureDir = './images/pictures/';
        $bannerDir = './images/banners/';

        // Vérification pour la picture
        if (isset($picture['name'])) {
            $picturePath = $pictureDir . basename($picture['name']);

            // Vérification pour le banner
            if (isset($banner['name'])) {
                $bannerPath = $bannerDir . basename($banner['name']);

                if (file_exists($picturePath) && file_exists($bannerPath)) {
                    // Les deux fichiers existent déjà
                    // je récupère le banner et la picture
                    $request = $connexion->prepare("SELECT user.picture, user.banner FROM user WHERE user.id = :id");
                    $request->execute([':id' => $id]);
                    $user = $request->fetch(PDO::FETCH_ASSOC);

                    $request = $connexion->prepare("
                        UPDATE user SET
                            username = :username,
                            picture = :picture,
                            banner = :banner,
                            description = :description
                        WHERE
                            id = :id;
                    ");

                    $request->execute(
                        [
                            ":username" => $username,
                            ":picture" => $user['picture'],
                            ":banner" => $user['banner'],
                            ":description" => $description,
                            ":id" => $id
                        ]
                    );
                    // Fermeture de la connexion
                    $connexion = null;

                    $message = "les modifications ont bien été prit en compte";
                    header('Location: http://localhost:3000/Page/profile.php?message=' . urlencode($message));
                    exit;

                } elseif (file_exists($picturePath)) {
                    // Seule la picture existe déjà

                    // je récupère la picture
                    $request = $connexion->prepare("SELECT user.picture FROM user WHERE user.id = :id");
                    $request->execute([':id' => $id]);
                    $user = $request->fetch(PDO::FETCH_ASSOC);

                    $targetDir = './images/banners/';
                    $fileName = basename($banner['name']);
                    $targetPath = $targetDir . $fileName;

                    $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

                    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                        header('HTTP/1.1 400 Bad Request');
                        return json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                        return;
                    }

                    // Déplacer l'image du chemin temporaire vers le chemin final
                    if(move_uploaded_file($banner['tmp_name'], $targetPath)) {
                        // je prépare ma requète
                        $request = $connexion->prepare("
                            UPDATE user SET
                                username = :username,
                                picture = :picture,
                                banner = :banner,
                                description = :description
                            WHERE
                                id = :id;
                        ");

                        $bannerPath = 'http://localhost:4000/images/banners/' . $fileName;

                        $request->execute(
                            [
                                ":username" => $username,
                                ":picture" => $user['picture'],
                                ":banner" => $bannerPath,
                                ":description" => $description,
                                ":id" => $id
                            ]
                        );
                        // Fermeture de la connexion
                        $connexion = null;

                        $message = "les modifications ont bien été prit en compte";
                        header('Location: http://localhost:3000/Page/profile.php?message=' . urlencode($message));
                        exit;

                    }else{
                        $uploadMaxFileSize = ini_get('upload_max_filesize');
                        echo $uploadMaxFileSize; // 2Mo
                        return "la taille maximal de l'image ne dois pas etre supérieur a " . ' ' . $uploadMaxFileSize;
                    }
                    
                } elseif (file_exists($bannerPath)) {
                    // Seul le banner existe déjà
                    $request = $connexion->prepare("SELECT user.banner FROM user WHERE user.id = :id");
                    $request->execute([':id' => $id]);
                    $user = $request->fetch(PDO::FETCH_ASSOC);

                    $targetDir = './images/pictures/';
                    $fileName = basename($picture['name']);
                    $targetPath = $targetDir . $fileName;

                    $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

                    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                        header('HTTP/1.1 400 Bad Request');
                        echo json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                        return;
                    }

                    // Déplacer l'image du chemin temporaire vers le chemin final
                    if(move_uploaded_file($picture['tmp_name'], $targetPath)) {
                        // je prépare ma requète
                        $request = $connexion->prepare("
                            UPDATE user SET
                                username = :username,
                                picture = :picture,
                                banner = :banner,
                                description = :description
                            WHERE
                                id = :id;
                        ");

                        $picturePath = 'http://localhost:4000/images/pictures/' . $fileName;

                        $request->execute(
                            [
                                ":username" => $username,
                                ":picture" => $picturePath,
                                ":banner" => $user['banner'],
                                ":description" => $description,
                                ":id" => $id
                            ]
                        );
                        // Fermeture de la connexion
                        $connexion = null;

                        $message = "les modifications ont bien été prit en compte";
                        header('Location: http://localhost:3000/Page/profile.php?message=' . urlencode($message));
                        exit;
                    }else{
                        $uploadMaxFileSize = ini_get('upload_max_filesize');
                        echo $uploadMaxFileSize; // 2Mo
                        return "la taille maximal de l'image ne dois pas etre supérieur a " . ' ' . $uploadMaxFileSize;
                    }
                } else {
                    // Aucun des deux fichiers n'existe
                    $bannerDir = './images/banners/';
                    $bannerName = basename($banner['name']);
                    $bannerPath = $targetDir . $fileName;

                    $pictureDir = './images/pictures/';
                    $pictureName = basename($picture['name']);
                    $picturePath = $targetDir . $fileName;

                    $bannerFileType = strtolower(pathinfo($bannerPath, PATHINFO_EXTENSION));
                    $pictureFileType = strtolower(pathinfo($picturePath, PATHINFO_EXTENSION));

                    if (!in_array($bannerFileType, ['jpg', 'jpeg', 'png']) && !in_array($pictureFileType, ['jpg', 'jpeg', 'png'])) {
                        header('HTTP/1.1 400 Bad Request');
                        echo json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                        return;
                    }

                    if(move_uploaded_file($banner['tmp_name'], $bannerPath) && move_uploaded_file($picture['tmp_name'], $picturePath)) {
                         // je prépare ma requète
                        $request = $connexion->prepare("
                            UPDATE user SET
                                username = :username,
                                picture = :picture,
                                banner = :banner,
                                description = :description
                            WHERE
                                id = :id;
                        ");

                        $pictPath = 'http://localhost:4000/images/pictures/' . $fileName;
                        $banPath = 'http://localhost:4000/images/banners/' . $fileName;

                        $request->execute(
                            [
                                ":username" => $username,
                                ":picture" => $pictPath,
                                ":banner" => $banPath,
                                ":description" => $description,
                                ":id" => $id
                            ]
                        );
                        // Fermeture de la connexion
                        $connexion = null;

                        $message = "les modifications ont bien été prit en compte";
                        header('Location: http://localhost:3000/Page/profile.php?message=' . urlencode($message));
                        exit;
                    }else{
                        $uploadMaxFileSize = ini_get('upload_max_filesize');
                        echo $uploadMaxFileSize; // 2Mo
                        return "la taille maximal de l'image ne dois pas etre supérieur a " . ' ' . $uploadMaxFileSize;
                    }
                }
            } else {
                // Seule la picture est présente
                $targetDir = './images/pictures/';
                $fileName = basename($picture['name']);
                $targetPath = $targetDir . $fileName;
    
                $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                    header('HTTP/1.1 400 Bad Request');
                    echo json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                    return;
                }
                
                // Déplacer l'image du chemin temporaire vers le chemin final
                if(move_uploaded_file($picture['tmp_name'], $targetPath)) {
                    // je prépare ma requète
                    $request = $connexion->prepare("
                        UPDATE user SET
                            username = :username,
                            picture = :picture,
                            description = :description
                        WHERE
                            id = :id;
                    ");

                    $picturePath = 'http://localhost:4000/images/pictures/' . $fileName;

                    $request->execute(
                        [
                            ":username" => $username,
                            ":picture" => $picturePath,
                            ":description" => $description,
                            ":id" => $id
                        ]
                    );
                    // Fermeture de la connexion
                    $connexion = null;

                    $message = "les modifications ont bien été prit en compte";
                    header('Location: http://localhost:3000/Page/profile.php?message=' . urlencode($message));
                    exit;
                }
    
            }
        } elseif (isset($banner['name'])) {
            // Seul le banner est présent
            $targetDir = './images/banners/';
            $fileName = basename($banner['name']);
            $targetPath = $targetDir . $fileName;

            $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                return;
            }

            // Déplacer l'image du chemin temporaire vers le chemin final
            if(move_uploaded_file($banner['tmp_name'], $targetPath)) {
                // je prépare ma requète
                $request = $connexion->prepare("
                    UPDATE user SET
                        username = :username,
                        banner = :banner,
                        description = :description
                    WHERE
                        id = :id;
                ");

                $bannerPath = 'http://localhost:4000/images/banners/' . $fileName;

                $request->execute(
                    [
                        ":username" => $username,
                        ":banner" => $bannerPath,
                        ":description" => $description,
                        ":id" => $id
                    ]
                );
                // Fermeture de la connexion
                $connexion = null;

                $message = "les modifications ont bien été prit en compte";
                header('Location: http://localhost:3000/Page/profile.php?message=' . urlencode($message));
                exit;
            }else{
                $uploadMaxFileSize = ini_get('upload_max_filesize');
                echo $uploadMaxFileSize; // 2Mo
                return "la taille maximal de l'image ne dois pas etre supérieur a " . ' ' . $uploadMaxFileSize;
            }
        } else {
            // Aucun des deux fichiers n'est présent
             // je prépare ma requète
             $request = $connexion->prepare("
                UPDATE user SET
                    username = :username,
                    description = :description
                WHERE
                    id = :id;
            ");

            $request->execute(
                [
                    ":username" => $username,
                    ":description" => $description,
                    ":id" => $id
                ]
            );
            // Fermeture de la connexion
            $connexion = null;

            $message = "les modifications ont bien été prit en compte";
            header('Location: http://localhost:3000/Page/profile.php?message=' . urlencode($message));
            exit;
        }
    }
    function deactivateAccountForOneUser($id){

        // connexion la BDD
        $db = new Database();

        // Ouverture de la connexion
        $connexion = $db->getconnection();
        // je prépare ma requète
        $request = $connexion->prepare("UPDATE user SET active = FALSE WHERE user.id = :id");

        $request->execute([":id" => $id]);

        // Fermeture de la connexion
        $connexion = null;

        $message = "Le compte a été désactivé avec succès";
        header('Location: http://localhost:3000?message=' . urlencode($message));
        exit;

    }
    function reactivateAccountforOneUser($id){
        // connexion la BDD
        $db = new Database();

        // Ouverture de la connexion
        $connexion = $db->getconnection();
        // je prépare ma requète
        $request = $connexion->prepare("UPDATE user SET active = TRUE WHERE user.id = :id");

        $request->execute([":id" => $id]);

        // Fermeture de la connexion
        $connexion = null;

        $message = "Le compte a été réactiver";
        header('Location: http://localhost:3000/Page/login.php?message=' . urlencode($message));
        exit;
    }
    function delectAccountForOneUser($id){
        // j'appelle l'objet base de donnée
        $db = new Database();

        // je me connecte à la BDD avec la fonction getconnexion de l'objet Database
        $connexion = $db->getconnection();

        // je prépare la requête
        $request = $connexion->prepare("DELETE FROM user WHERE user.id = :id");
        // j'exécute la requête
        $request->execute([':id' => $id]);

        $message = "Le compte a bien été suprimé";
        header('Location: http://localhost:3000?message=' . urlencode($message));
        exit;

        // je requête la BDD

    }
    function loginAccount() {

        //Connecter la BDD
        $db = new Database();

        // Ouverture de la connexion
        $connexion = $db->getconnection();

        // récupérer les champs du formulaire login
        $username = $_POST['username'];
        $password = $_POST['password'];

        // si les champs son renseigner
        if($username && $password) {
            // Requêtes SQL
            $request = $connexion->prepare("
                SELECT user.id, user.password, user.active, role.name
                FROM user 
                JOIN role
                ON user.role_id = role.id
                WHERE username = :username
            ");
            $request->execute([":username" => $username]);

            $userInfos = $request->fetch(PDO::FETCH_ASSOC);

            if ($userInfos && password_verify($password, $userInfos['password'])) {
                if ($userInfos['active']){
                    session_start();
                    $_SESSION['id'] = $userInfos['id'];
                    $_SESSION['role'] = $userInfos['role'];
                    header('HTTP/1.1 200 OK');
                    $message = "Connexion réussie";
                    header('Location: http://localhost:3000/Page/publications.php?message=' . urlencode($message));
                    exit;

                }else {

                    header('Location: http://localhost:3000/Page/login.php?id=' . urlencode($userInfos['id']));
                    exit;
                }
                
            } else {
                header("HTTP/1.1 402");
                $message = "le nom d'utilisateur ou le mot de passe est incorrect";
                header('Location: http://localhost:3000/Page/login.php?message=' . urlencode($message));
                exit;
            }
        } else {
            $message = "Tout les champs sont requis";
            header('Location: http://localhost:3000/Page/login.php?message=' . urlencode($message));
            exit;
        }
        
        // Fermeture de la connexion
        $connexion = null;


    }
    function addStudent(){
        // je vérifie que l'id du user est relier a un role admin 

        //Connecter la BDD
        $db = new Database();

        // Ouverture de la connexion
        $connexion = $db->getconnection();

        // je récupère les champs du formulaire signin
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $role_id = $_POST['role_id'];
        $promo_id = $_POST['promo_id'];
        $picture = $_FILES['picture'];

        // Vérifier si une image a été envoyée
        if(isset($picture)) {

            $targetDir = './images/pictures/';
            $fileName = basename($picture['name']);
            $targetPath = $targetDir . $fileName;

            $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                return;
            }
            
            // Déplacer l'image du chemin temporaire vers le chemin final
            if(move_uploaded_file($picture['tmp_name'], $targetPath)) {

                // jsi tous les champs sont remplies
                if($firstname && $lastname && $mail && $password && $username && $role_id && $promo_id){

                    // Je hash le mot de passe
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    // je prépare ma requète
                    $request = $connexion->prepare("
                    INSERT INTO user (
                        firstname,
                        lastname,
                        mail,
                        password,
                        username,
                        picture,
                        role_id,
                        promo_id
                    ) VALUES (
                        :firstname,
                        :lastname,
                        :mail,
                        :password,
                        :username,
                        :picture,
                        :role_id,
                        :promo_id
                    )");

                    $picturePath = 'http://localhost:4000/images/pictures/' . $fileName;

                    $request->execute(
                        [
                            ":firstname" => $firstname,
                            ":lastname" => $lastname,
                            ":mail" => $mail,
                            ":password" => $hashed_password,
                            ":username" => $username,
                            ":picture" => $picturePath,
                            ":role_id" => $role_id,
                            ":promo_id" => $promo_id
                        ]
                    );
                    // Fermeture de la connexion
                    $connexion = null;

                    $message = "l'étudiant a bien été créé";
                    header('Location: http://localhost:3000/Page/login.php?message=' . urlencode($message));
                    exit;

                }else {
                    $message = "Tout les champs sont requis";
                    header('Location: http://localhost:3000/Page/signin.php?message=' . urlencode($message));
                    exit;
                }
            } else {
                $uploadMaxFileSize = ini_get('upload_max_filesize');
                echo $uploadMaxFileSize; // 2Mo
                return "la taille maximal de l'image ne dois pas etre supérieur a " . ' ' . $uploadMaxFileSize;
            }
    
        };
        
        if (!isset($picture)) {
            
            // jsi tous les champs sont remplies
            if($firstname && $lastname && $mail && $password && $username && $role_id && $promo_id){
    
                // Je hash le mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                // je prépare ma requète
                $request = $connexion->prepare("
                INSERT INTO user (
                    firstname,
                    lastname,
                    mail,
                    password,
                    username,
                    role_id,
                    promo_id
                ) VALUES (
                    :firstname,
                    :lastname,
                    :mail,
                    :password,
                    :username,
                    :role_id,
                    :promo_id);");
    
                $request->execute(
                    [
                        ":firstname" => $firstname,
                        ":lastname" => $lastname,
                        ":mail" => $mail,
                        ":password" => $hashed_password,
                        ":username" => $username,
                        ":role_id" => $role_id,
                        ":promo_id" => $promo_id
                    ]
                );
                // Fermeture de la connexion
                $connexion = null;
    
                $message = "l'étudiant a bien été créé";
                header('Location: http://localhost:3000/Page/profile.php?message=' . urlencode($message));
                exit;
    
            }else {
                $message = "Tout les champs sont requis";
                header('Location: http://localhost:3000/Page/signin.php?message=' . urlencode($message));
                exit;
            }
        }
    
    }
    function logoutAccount(){

        session_unset();
        session_destroy();

        header('Location: http://localhost:3000');

    }
    function searchRelation($searchBarre, $query){
        
        //Connecter la BDD
        $db = new Database();
    
        // Ouverture de la connexion
        $connexion = $db->getconnection();

        switch($query){

            case 'user':

                $request = $connexion->prepare("SELECT * FROM user WHERE firstname = :searchBarre OR lastname = :searchBarre");
                $request->execute([
                    ':searchBarre' => $searchBarre
                ]);
                $results = $request->fetchAll(PDO::FETCH_ASSOC);
            
                if($results){
                    header('Content-Type: application/json');
                    echo json_encode($results);
                   
                }else{
                    $message = "Aucun résultats";
                    header('Location: http://localhost:3000/Page/recherche.php?message=' . urlencode($message));
                    exit;
                }
                break;
            
            case 'group':

                $request = $connexion->prepare("SELECT * FROM `group` WHERE group.name LIKE :searchBarre");
                $request->execute([
                    ':searchBarre' => '%' . $searchBarre . '%'
                ]);
                $results = $request->fetchAll(PDO::FETCH_ASSOC);
            
                if($results){
                    header('Content-Type: application/json');
                    echo json_encode($results); 
                }else{ 
                    
                    $message = "Aucun résultats";
                    header('Location: http://localhost:3000/Page/recherche.php?message=' . urlencode($message));
                    exit;
                }
                break;
            
            case 'promo':

                $request = $connexion->prepare("SELECT * FROM promo WHERE promo.promo_name LIKE :searchBarre");
                $request->execute([
                    ':searchBarre' => '%' . $searchBarre . '%'
                ]);
                $results = $request->fetchAll(PDO::FETCH_ASSOC);
            
                if($results){
                    header('Content-Type: application/json');
                    return json_encode($results);
                }else{
                    $message = "Aucun résultats";
                    header('Location: http://localhost:3000/Page/recherche.php?message=' . urlencode($message));
                    exit;
                }
                break;
            
            case 'publication':

                $request = $connexion->prepare("SELECT * FROM publication WHERE publication.title = :searchBarre");
                $request->execute([
                    ':searchBarre' => $searchBarre
                ]);
                $results = $request->fetchAll(PDO::FETCH_ASSOC);
            
                if($results){
                    header('Content-Type: application/json');
                    return json_encode($results);
                }else{
                    $message = "Aucun résultats";
                    header('Location: http://localhost:3000/Page/recherche.php?message=' . urlencode($message));
                    exit;
                }
                break;
                
            default: 

                if(!$query){
                    $message = "Merci de choisir un filtre";
                    header('Location: http://localhost:3000/Page/recherche.php?message=' . urlencode($message));
                    exit; 
                }
            break;   
        }  

    
        
    }  
}