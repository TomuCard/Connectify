<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';

//Création de la calsse Promo

class Promo {
    function getAllpromos (){

        // j'appelle la base de donnée
        $db = new Database();

        // je me connecte à la BDD 
        $connexion = $db->getConnection();

        // Je prépare la requête
        $request = $connexion->prepare("SELECT * FROM promo");

        // j'exécute la requête
        $request->execute();

        // je récupère le resultat de la requête
        $promos = $request->fetchAll(PDO::FETCH_ASSOC);

        // je ferme la connection
        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($promos);
    }
    
    function addPromo (){

        // je récupère l'id de l'utilisateur
        $id = $_SESSION['id'];

        // récupérer les champs du formulaire
        $name = $_POST['promo_name'];
        $page_id = $_POST['page_id'];
        $group_id = $_POST['group_id'];
        $description = $_POST['description'];

        // j'appelle la base de donnée
        $db = new Database();

        // je me connecte à la BDD 
        $connexion = $db->getConnection();

        // Je prépare la requête
        $requestPage = $connexion->prepare("
            INSERT INTO promo(promo.promo_name, promo.page_id, promo.group_id, promo.description)
            VALUES (:name, :page_id, :group_id, :description);
        ");

        // j'exécute la raquête
        $requestPage->execute([
            ':promo_name' => $name,
            ':page_id' => $page_id,
            ':group_id' => $group_id,
            ':description' => $description
        ]);

        // Fermer la connexion
        $connexion = null;
    }
    
    function showPromo ($promo_id){
         // je récupère l'id de l'utilisateur
         $id = $_SESSION['id'];

         // Je me connecte à la BDD
        $connexion = $db->getConnection();

        // Je prépare la requête pour récupérer les détails de la promo
        $requestPromo = $connexion->prepare("
            SELECT *
            FROM promo
            WHERE id = :id_promo
        ");

        // J'exécute la requête en fournissant l'ID de la promo
        $requestPromo->execute([':id_promo' => $id_promo]);

         // Je récupère les détails de la promo
        $promo = $requestPromo->fetch(PDO::FETCH_ASSOC);

        // Je prépare la requête pour récupérer la liste des élèves de la promo
        $requestStudents = $connexion->prepare("
            SELECT *
            FROM user
            WHERE promo_id = :id_promo
        ");

        // J'exécute la requête en fournissant l'ID de la promo
        $requestStudents->execute([':id_promo' => $id_promo]);

        // Je récupère la liste des élèves de la promo
        $students = $requestStudents->fetchAll(PDO::FETCH_ASSOC);

        // Fermer la connexion à la base de données
        $connexion = null;

        // Afficher les détails de la promo et la liste des élèves au format JSON
        $response = [
            'promo' => $promo,
            'students' => $students
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }


    function updatePromo ($promo_id){

        // je récupère l'id de l'utilisateur
        $id = $_SESSION['id'];

        // récupérer les champs du formulaire
        $name = $_POST['promo_name'];
        $page_id = $_POST['page_id'];
        $group_id = $_POST['group_id'];
        $description = $_POST['description'];

         // j'appelle la base de donnée
         $db = new Database();

         // je me connecte à la BDD 
         $connexion = $db->getConnection();

        // je vérifie que l'utilisateur est admin

        // Je prépare la requête pour vérifier le rôle de l'utilisateur
        $request = $connexion->prepare("
            SELECT user.role_id
            FROM user
            WHERE user.role_id = :user_id
        ");

       // j'exécute la raquête
       $request->execute([':id' => $id]);

       $role = $request->fetch(PDO::FETCH_ASSOC);

       if($role['role_id'] == 3){

            // je prépare ma requète
            $request = $connexion->prepare("
                UPDATE promo SET(
                    promo.promo_name, 
                    promo.page_id, 
                    promo.group_id, 
                    promo.description
                WHERE
                    promo.id = :promo_id;
            )");

            $request->execute(
                [
                    ':promo_name' => $name,
                    ':page_id' => $page_id,
                    ':group_id' => $group_id,
                    ':description' => $description
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


    function deletePromo ($promoId){
        // je récupère l'id de l'utilisateur
        $id = $_SESSION['id'];

        // j'appelle la base de donnée
        $db = new Database();

        // je me connecte à la BDD 
        $connexion = $db->getConnection();

        // je vérifie que l'utilisateur est admin

        // Je prépare la requête pour vérifier le rôle de l'utilisateur
        $request = $connexion->prepare("
            SELECT user.role_id
            FROM user
            WHERE user.role_id = :user_id
        ");

        // J'exécute la requête
        $request->execute([
            ':user_id' => $_SESSION['user']['id']
        ]);

        $role = $request->fetch(PDO::FETCH_ASSOC);

        if ($role['role_id'] == 3) {
            // Je prépare ma requête pour supprimer la promo
            $request = $connexion->prepare("DELETE FROM promo WHERE promo.id = :promo_id");

            $request->execute([':promo_id' => $promoId]);

            // Fermeture de la connexion
            $connexion = null;

            $message = "La promo a été supprimée";
            header('Location: http://localhost:3000/Promo/#.php?message=' . urlencode($message));
            exit;
        } else {
            $message = "Vous ne pouvez pas effectuer cette action";
            header('Location: http://localhost:3000/Promo/#.php?message=' . urlencode($message));
            exit;
        }

   }

}
