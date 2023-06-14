<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';


// Création du controller users

class Page {

    function getAllPages (){

        // j'appelle la base de donnée
        $db = new Database();

        // je me connecte à la BDD 
        $connexion = $db->getConnection();

        // Je prépare la requête
        $request = $connexion->prepare("SELECT * FROM page");

        // j'exécute la requête
        $request->execute();

        // je récupère le resultat de la requête
        $pages = $request->fetchAll(PDO::FETCH_ASSOC);

        // je ferme la connection
        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($pages);
    }

    function getOnePage ($page_id){

        // j'appelle la base de donnée
        $db = new Database();

        // je me connecte à la BDD 
        $connexion = $db->getConnection();

        // Je prépare la requête
        $request = $connexion->prepare("
            SELECT * 
            FROM page
            WHERE page.id = :page_id
        
        ");

        // j'exécute la requête
        $request->execute([':page_id' => $page_id]);

        // je récupère le resultat de la requête
        $page = $request->fetch(PDO::FETCH_ASSOC);

        // je ferme la connection
        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($page);
    }

    function createPage (){

        $id = $_SESSION['id'];
        // récupérer les champs du formulaire
        $name = $_POST['name'];
        $banner = $_POST['banner'];
        $picture = $_POST['picture'];

         // j'appelle la base de donnée
         $db = new Database();

         // je me connecte à la BDD 
         $connexion = $db->getConnection();

           // Je prépare la requête
        $requestPage = $connexion->prepare("
            INSERT INTO page(page.name, page.banner, page.picture)
            VALUES (:name, :banner, :picture);
        ");

        // j'exécute la raquête
        $requestPage->execute([
            ':name' => $name,
            ':banner' => $banner,
            ':picture' => $picture
        ]);

        $page_id = $connexion->lastInsertId();
        
        // Je met l'utilisateur qui a créer la page en admin
        $requestMember = $connexion->prepare("
            INSERT INTO page_role (page_id, user_id, role_id)
            VALUES (:page_id, :user_id, 3);
        ");

        $requestMember->execute([
            'page_id' => $page_id,
            'user_id' => $id
        ]);


        $message = "La page a été créer";
        header('Location: http://localhost:3000/Page/#.php/' . $page_id . '?message=' . urlencode($message));
        exit;

         
    }

    function updatePageForOneUserIfAdmin ($page_id){
        // je récupère l'id de l'utilisateur
        $id = $_SESSION['id'];

        // récupérer les champs du formulaire
        $name = $_POST['name'];
        $banner = $_POST['banner'];
        $picture = $_POST['picture'];

         // j'appelle la base de donnée
         $db = new Database();

         // je me connecte à la BDD 
         $connexion = $db->getConnection();

        // je vérifie que l'utilisateur est admin

        // Je prépare la requête
        $request = $connexion->prepare("
           SELECT page_role.role_id
           FROM page_role
           WHERE page_role.user_id = :id
       ");

       // j'exécute la raquête
       $request->execute([':id' => $id]);

       $role = $request->fetch(PDO::FETCH_ASSOC);

       if($role['role_id'] == 3){

            // je prépare ma requète
            $request = $connexion->prepare("
                UPDATE page SET(
                    page.name = :name,
                    page.banner = :banner,
                    page.picture = :picture
                WHERE
                    page.id = :page_id;
            )");

            $request->execute(
                [
                    ":name" => $name,
                    ":banner" => $banner,
                    ":picture" => $picture,
                    ":page_id" => $page_id
                ]
            );
        // Fermeture de la connection
        $connection = null;

        $message = "les modifications ont bien été prit en compte";
        header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
        exit;
       }else{
            $message = "vous ne pouvez pas faire cela";
            header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
       }

    }
    
    function deletePageForOneUserIfAdmin ($page_id){
         // je récupère l'id de l'utilisateur
         $id = $_SESSION['id'];
 
          // j'appelle la base de donnée
          $db = new Database();
 
          // je me connecte à la BDD 
          $connexion = $db->getConnection();
 
         // je vérifie que l'utilisateur est admin
 
         // Je prépare la requête
         $request = $connexion->prepare("
            SELECT page_role.role_id
            FROM page_role
            WHERE page_role.user_id = :id
        ");
 
        // j'exécute la raquête
        $request->execute([':id' => $id]);
 
        $role = $request->fetch(PDO::FETCH_ASSOC);
 
        if($role['role_id'] == 3){
 
             // je prépare ma requète
             $request = $connexion->prepare("DELETE FROM page WHERE page.id = :page_id");
 
             $request->execute([':page_id' => $page_id]);
         // Fermeture de la connection
         $connection = null;
 
         $message = "la page a été supprimer";
         header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
         exit;
        }else{
            $message = "vous ne pouvez pas faire cela";
            header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
        }
 
    }
    
}