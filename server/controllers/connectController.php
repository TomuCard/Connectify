<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';

// Création du controller users

class connect {
    function getRelationForOneUser($id) {
    
        // J'appelle l'objet base de données
        $db = new Database();
    
        // Je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connection = $db->getConnection();
    
        // Je prépare la requête pour récupérer les relations de l'utilisateur
        // Utilisez un alias pour distinguer le user_id et le friend_id
        // Utilisez friend_id pour faire la jointure
        $sql = "
            SELECT connect.friend_id, friend.firstname, friend.lastname, friend.id
            FROM connect
            JOIN user AS friend 
            ON connect.friend_id = friend.id 
            WHERE connect.user_id = :user_id  
        ";
        $statement = $connection->prepare($sql);

        $statement->execute([':user_id' => $id]);
    
        $relations = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;

        if($relations){
            header('Content-Type: application/json');
            echo json_encode($relations);
        }else{
            $message ='aucune relation touvé !';
            header('Content-Type: application/json');
            echo json_encode($message);
        }
    }
    
    function addRelationForOneUser($id_user) {

        $id = $_SESSION['id'];

        $db = new Database();
    
        $connection = $db->getConnection();
    
        $sql = "
                INSERT INTO connect (connect.user_id, connect.friend_id) 
                VALUES (:user_id, :friend_id)
            ";
        $statement = $connection->prepare($sql);
    
        $statement->execute([
            ':user_id' => $id, 
            ':friend_id' => $id_user
        ]);
    
        $connection = null;
        $message = "l'utilisateur a bien été ajouté en ami";
        header('Location: http://localhost:3000/Page/profile.php?message=' . urlencode($message));
        exit;
    }
    
    
    function deleteRelationForOneUser($id_user) {

        $id = $_SESSION['id'];
    
        // J'appelle l'objet base de données
        $db = new Database();
    
        // Je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connection = $db->getConnection();
    
        // Je prépare la requête
        $sql = "
            DELETE FROM connect 
            WHERE connect.friend_id = :id_user 
            AND connect.user_id = :id
        ";
        $statement = $connection->prepare($sql);
        $statement->execute([
            ':id_user' => $id_user, 
            ':id' => $id
        ]);
            
        $message = "l'utilisateur a bien été supprimé";
        header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
        exit;
    }
}