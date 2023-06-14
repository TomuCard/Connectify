<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';


// Création du controller users

class Feed {

    function getAllFeedsForOneUser ($id_user) {

        
        // j'appelle l'objet base de donnée
        $db = new Database();

        // je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connexion = $db->getConnection();
        
        // je prépare la requête
        $request = $connexion->prepare("
            SELECT post.title, post.content, post.picture, user.firstname, user.lastname, user.picture AS picture_user 
            FROM post
            JOIN user
            ON post.user_id = user.id 
            WHERE post.user_id = :id_user
        ");
        // j'exécute la requête
        $request->execute([':id_user' => $id_user]);
        // je récupère tous les résultats dans users
        $feeds = $request->fetchAll(PDO::FETCH_ASSOC);
        // je ferme la connection
        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($feeds);

    }


    function addFeedOfUser ($id) {

        $title = $_POST['title'];
        $content = $_POST['content'];
        $picture = $_FILES['picture'];

        $db = new Database();

        $connection = $db->getConnection();

        $targetDir = './images/feeds/';
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

            $sql = "INSERT INTO post (user_id, title, content, picture) VALUES (:user_id, :title, :content, :picture)";
            $statement = $connection->prepare($sql);
    
            $picturePath = 'http://localhost:4000/images/feeds/' . $fileName;

            $statement->execute([
                ':user_id' => $id,
                ':title' => $title,
                ':content' => $content,
                ':picture' => $picturePath
            ]);
    
            $connection = null;
    
            $message = "Le post a été créer";
            header('Location: http://localhost:3000/Page/publications.php?message=' . urlencode($message));
            exit;
        }

    }


    function updateFeedOfUser ($id_feed) {
        // $_SESSION['id']; 
        $feed_id= 4;
           

        $db = new Database();

        $connection = $db->getConnection();

        $sql = "UPDATE post SET title = 'trop cool !' WHERE id = :feed_id";
        $statement = $connection->prepare($sql);

        $statement->bindValue(':feed_id', $feed_id, PDO::PARAM_INT);

        if ($statement->execute()) {
            $response = array('success' => true, 'message' => 'Post modifié !');
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Échec modification du post.');
            header('Content-Type: application/json');
            echo json_encode($response);
        }

        $connection = null;
    }


    function deleteFeedOfUser ($id_feed) {
        // $_SESSION['id']; 
        $feed_id = 1;

        $db = new Database();
        
        $connection = $db->getConnection();
        
        $sql = "DELETE FROM post WHERE id = :feed_id";
        $statement = $connection->prepare($sql);
        
        $statement->bindValue(':feed_id', $feed_id, PDO::PARAM_INT);
        
        if ($statement->execute()) {
            $response = array('success' => true, 'message' => 'Post supprimé !');
            header('Content-Type: application/json');
            echo json_encode($response);
        } 
        else {
            $response = array('success' => false, 'message' => 'Échec de la suppression du post.');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        
        $connection = null;
    }

}