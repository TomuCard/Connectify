<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';

// Création du controller users

class Member {
    
    function quitGroup($id_group) {

        $id = $_SESSION['id'];

        // J'appelle l'objet base de données
        $db = new Database();
    
        // Je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connection = $db->getConnection();
    
        // Je prépare la requête
        $sql = "
            DELETE FROM member 
            WHERE group_id = :group_id 
            AND user_id = :id
        ";
        $statement = $connection->prepare($sql);
        $statement->execute([
                ':group_id' => $id_group, 
                ':id' => $id
        ]);
        // Fermeture de la connexion
        $connection = null;
    
        // Réponse JSON indiquant le succès
        $response = array('success' => true, 'message' => 'User left the group successfully.');
        header('Content-Type: application/json');
        return json_encode($response);
    }
}