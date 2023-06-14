<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';


// Création du controller users

class Comment {

        function getAllCommentsForOnePublication ($publication_id) {
            
            // j'appelle l'objet base de donnée
            $db = new Database();

            // je me connecte à la BDD avec la fonction getConnection de l'objet Database
            $connexion = $db->getConnection();

            // je prépare la requête
            $request = $connexion->prepare("SELECT comment.comment_content , user.firstname , user.lastname 
                                            FROM comment 
                                            JOIN user 
                                            ON comment.user_id = user.id 
                                            WHERE comment.publication_id = :publication_id

                                            "); 
            // j'exécute la requête
            $request->execute([
                'publication_id' => $publication_id
            ]);
            // je récupère tous les résultats dans users
            $comments = $request->fetchAll(PDO::FETCH_ASSOC);
            // je ferme la connection
            $connection = null;

            // je renvoie au front les données au format json
            header('Content-Type: application/json');
            echo json_encode($comments);

        }

        function addCommentInOnePublication ($publication_id) {
            
            $user_id = $_SESSION['user']['id'];
            $comment_content = $_POST['comment_content'];
            
            // Create a new instance of the Database class
            $db = new Database();

            // Establish a connection to the database
            $connection = $db->getConnection();

            // Prepare the SQL statement to insert the relation
            $sql = "INSERT INTO comment (comment.comment_content, comment.user_id, comment.publication_id) VALUES (:comment_content, :user_id, :publication_id)";
            $statement = $connection->prepare($sql);
            
            $statement->execute([
                ':comment_content' => $comment_content ,
                ':user_id' => $user_id ,
                ':publication_id' => $publication_id
            ]);

            // Close the database connection
            $connection = null;

        }

        function ifAuthorUpdateComment ($id_comment) {
            // id du user
            $id = $_SESSION['id'];
            $comment_content = $_POST['comment_content'];
        

            // Create a new instance of the Database class
            $db = new Database();

            // Establish a connection to the database
            $connection = $db->getConnection();

            // véfifier que l'utilisateur est l'auteur du commentaire
            $sql = "SELECT comment.user_id
                    FROM comment
                    WHERE comment.user_id = :id
                    AND comment.id = :id_comment 
                    ";

            $statement = $connection->prepare($sql);

            $statement->execute([':id' => $id]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if($user){

                // Prepare the SQL statement to update the comment
                $sql = "
                    UPDATE comment 
                    SET comment.comment_content = :comment_content 
                    WHERE comment.id = :id_comment
                ";
                $statement = $connection->prepare($sql);
    
                $statement->execute([
                    ':comment_content' => $comment_content,
                    ':id_comment' => $id_comment
                ]);
    
                // Close the database connection
                $connection = null;

                $message = "les modifications ont bien été prit en compte";
                header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
                exit;

            }else{
                $message = "vous ne pouvez pas modifier le message";
                header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
                exit;
            }

            

        }

        function ifAuthorDeleteComment ($comment_id) {

            // l'id de l'utilisateur
            $id = $_SESSION['id']; 
            

            // Create a new instance of the Database class
            $db = new Database();

            // Establish a connection to the database
            $connection = $db->getConnection();

             // véfifier que l'utilisateur est l'auteur du commentaire
             $sql = "
                SELECT comment.user_id
                FROM comment
                WHERE comment.user_id = :id
                AND comment.id = :comment_id 
            ";

            
            $statement = $connection->prepare($sql);
            
            $statement->execute([':id' => $id]);
            
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            
            if($user){
                // Prepare the SQL statement to delete the comment
                $sql = "DELETE FROM comment WHERE comment.id = :comment_id";

                $statement = $connection->prepare($sql);
    
                $statement->execute([':comment_id' => $comment_id]);
    
                // Close the database connection
                $connection = null;

                $message = "le commentaire ont bien été supprimer";
                header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
                exit;

            }else{
                $message = "Vous n'avez pas l'authorisation";
                header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
                exit;
            }

        }
    
}