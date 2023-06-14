<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';


// Création du controller users

class Publication {

    function getAllPublicationsInGroup ($group_id) {
        
        // récupérer l'id de la session
        $id = $_SESSION['id'];

        // j'appelle l'objet base de donnée
        $db = new Database();

        // je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connexion = $db->getConnection();

        // vérifie que l'utilisateur est membre du goupe (table membre)
        $sql= "SELECT member.status
               FROM member
               WHERE member.user_id = :id
               AND member.group_id = :group_id
                ";

        $request = $connexion->prepare($sql);

        $request->execute([
            ':id' => $id,
            ':group_id' => $group_id
        ]);

        $member = $request->fetch(PDO::FETCH_ASSOC);

        if($member['status'] == 1){

            // je prépare la requête
            $request = $connexion->prepare("SELECT * FROM publication WHERE group_id = :group_id");

            // j'exécute la requête
            $request->execute([':group_id' => $group_id]);
            // je récupère tous les résultats dans publications
            $publications = $request->fetchAll(PDO::FETCH_ASSOC);
            // je ferme la connexion
            $connexion = null;
    
            // je renvoie au front les données au format json
            header('Content-Type: application/json');
            echo json_encode($publications);

        }
        else if ($member['status'] == 2){
            $message = "vous avez été bannis !";
                header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
                exit;

        }
        else if ($member['status'] == 0){
            $message = "vous n'avez pas encore intégré le group";
            header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
            exit;
        }
        else if (!$member['status']) {
            //rediriger l'utilisateur sur la page pour candidater a un group
            header('Location: http://localhost:3000/Page/#.php?message=' );
            exit;
        }


    }

    
    function getOnePublication ($id_publication) {

        // j'appelle l'objet base de donnée
        $db = new Database();

        // je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connexion = $db->getConnection();

        // je prépare la requête
        $request = $connexion->prepare("SELECT * FROM publication WHERE id = :publication_id");
        // j'attribue la valeur de $group_id au paramètre :group_id de la requête
        $request->bindParam(':publication_id', $publication_id);
        // j'exécute la requête
        $request->execute();
        // je récupère tous les résultats dans publications
        $publication = $request->fetch(PDO::FETCH_ASSOC);
        // je ferme la connexion
        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($publication);

    }

    


    function addPublicationInGroup($group_id , $author_id) {
         // l'id de l'utilisateur
        $id = $_SESSION['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $picture = $_POST['picture'];
        
        


        // Create a new instance of the Database class
        $db = new Database();
        
        // Establish a connection to the database
        $connection = $db->getConnection();
        
        $sql= "SELECT member.status
                FROM member
                WHERE member.user_id = :id
                AND member.group_id = :group_id
                ";

        $request = $connection->prepare($sql);

        $request->execute([
            ':id' => $id,
            ':group_id' => $group_id
        ]);

        $member = $request->fetch(PDO::FETCH_ASSOC);

        if($member['status'] == 1){

            // je prépare la requête
            $sql = "INSERT INTO publication (publication.title, publication.content, publication.picture, publication.author_id, publication.group_id) 
                    VALUES (:title, :content, :picture, :author_id , :group_id)
                    ";

            $request = $connection->prepare($sql);        
            
            // j'exécute la requête
            $request->execute([
                ':title' => $title,
                ':content' => $content,
                ':picture' => $picture,
                ':author_id' => $author_id,
                ':group_id' => $group_id
            ]);
            // je récupère tous les résultats dans publications
            $publications = $request->fetchAll(PDO::FETCH_ASSOC);
            // je ferme la connexion
            $connexion = null;
    
            // je renvoie au front les données au format json
            $message = "La publication a été crée !";
            header('Location: http://localhost:3000/Page/group.php/' . $group_id . '?message=' . urlencode($message));
            exit;

        }
        else if ($member['status'] == 2){
            $message = "vous avez été bannis !";
                header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
                exit;

        }
        else if ($member['status'] == 0){
            $message = "vous n'avez pas encore intégré le group";
            header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
            exit;
        }
        else if (!$member['status']) {
            //rediriger l'utilisateur sur la page pour candidater a un group
            header('Location: http://localhost:3000/Page/#.php?message=' );
            exit;
        }


    }


    function updatePublication ($publication_id) {
        // l'id de l'utilisateur
        $id = $_SESSION['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $picture = $_POST['picture'];
        
         // Create a new instance of the Database class
         $db = new Database();

         // Establish a connection to the database
         $connection = $db->getConnection();

        $sql = "SELECT publication.user_id
                FROM publication
                WHERE publication.user_id = :id
                AND publication.id = :publication_id 
                ";
 
     
     $statement = $connection->prepare($sql);
     
     $statement->execute([':id' => $id]);
     
     $user = $statement->fetch(PDO::FETCH_ASSOC);
     
     if($user){
         // Prepare the SQL statement to delete the comment
        $sql = "UPDATE publication SET title = 'Photo de chien' 
                WHERE id = :publication_id
                ";
 
         $statement = $connection->prepare($sql);
 
         $statement->execute([':publication_id' => $publication_id]);
 
         // Close the database connection
         $connection = null;
 
         $message = "la publication ont bien été supprimer";
         header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
         exit;
 
     }
     else{
         $message = "Vous n'avez pas l'autorisation";
         header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
         exit;
     }
 
 }

    
    function deletePublication ($publication_id) {
         // l'id de l'utilisateur
         $id = $_SESSION['id']; 

         // Create a new instance of the Database class
         $db = new Database();

         // Establish a connection to the database
         $connection = $db->getConnection();

        // véfifier que l'utilisateur est l'auteur du commentaire
        $sql = "
        SELECT publication.user_id
        FROM publication
        WHERE publication.user_id = :id
        AND publication.id = :publication_id 
    ";

    
    $statement = $connection->prepare($sql);
    
    $statement->execute([':id' => $id]);
    
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    
    if($user){
        // Prepare the SQL statement to delete the comment
        $sql = "DELETE FROM publication WHERE publication.id = :publication_id";

        $statement = $connection->prepare($sql);

        $statement->execute([':publication_id' => $publication_id]);

        // Close the database connection
        $connection = null;

        $message = "la publication ont bien été supprimer";
        header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
        exit;

    }
    else{
        $message = "Vous n'avez pas l'autorisation";
        header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
        exit;
    }

}

   
    
}