<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';


// Création du controller users

class Message {

    function sendPrivateMessage($receiver_id) {
        
        // Connexion à la base de données
        $db = new Database();
        $connection = $db->getConnection();

        // Récupère le contenu du message privé depuis la requête POST
        $message_content = $_POST['message_content'];

        // Récupère l'identité de l'utilisateur émetteur depuis la session
        $id = $_SESSION['id'];

        // Insertion du message dans la table private_message
        $sql = "INSERT INTO private_message (message_content, transmitter_id, receiver_id) VALUES (:message_content, :transmitter_id, :receiver_id)";
        $statement = $connection->prepare($sql);
        $statement->execute([
            ':message_content' => $message_content,
            ':transmitter_id' => $id,
            ':receiver_id' => $receiver_id
        ]);
        
        $message_id = $connection->lastInsertId(); // lastInsertId prend le dernier id du message créé.

        if ($message_id) {
            // Récupération du message inséré
            $sql = "SELECT * FROM private_message WHERE id = :message_id";
            $statement = $connection->prepare($sql);
            $statement->execute([
                ':message_id' => $message_id
            ]);
            
            $message = $statement->fetch(PDO::FETCH_ASSOC);
            $connection = null;

            return json_encode($message);
    
        } else {
            // Retourne une réponse d'erreur en JSON
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(array('message' => 'An error occurred while inserting the message.'));
        }
    }
    
    function receivePrivateMessage($receiver_id) {
        // J'appelle l'objet base de données
        $db = new Database();
    
        // Je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connection = $db->getConnection();
        // $id = $_SESSION['id'];
        
        // Je prépare la requête pour sélectionner les messages privés entre le récepteur et l'émetteur
        $sql = "
            SELECT private_message.message_content, user.firstname, user.lastname
            FROM private_message
            JOIN user ON private_message.transmitter_id = user.id
            WHERE private_message.receiver_id = :id
        ";
        $statement = $connection->prepare($sql);

        $statement->execute([
            ':id' => $receiver_id
        ]);
    
        $messages = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($messages);
        
    }
    // Le formulaire en front doit contenir un champ new_message_content qui contient le nouveau contenu du message
    function ifAuthorUpdateMessage($id_message) {

        $id = $_SESSION['id'];
        $message_content = $_POST['message_content'];
        
        // J'appelle l'objet base de données
        $db = new Database();
        
        // Je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connection = $db->getConnection();

        // vérififie si auteur du message
        
        $sql = "
            SELECT transmitter_id 
            FROM private_message 
            WHERE private_message.transmitter_id = :id
            AND private_message.id = :id_message
        ";
        $statement = $connection->prepare($sql);
        
        // J'exécute la requête en fournissant la valeur du paramètre
        $statement->execute([
            ':id' => $id,
            ':id_message' => $id_message
        ]);
        
        // Je récupère le résultat de la requête
        $message = $statement->fetch(PDO::FETCH_ASSOC);
        
        if (!$message) {
            // n'est pas l'auteur de commentaire
            $connection = null;
            $response = array('success' => false, 'message' => 'Not Author of the message');
            header('Content-Type: application/json');
            return json_encode($response);
        } else {
            // lorsque l'utilisateur est l'auteur du message
            $sql = "
                UPDATE private_message 
                SET message_content = :message_content
                WHERE id = :id_message
            ";
            $statement = $connection->prepare($sql);
            $statement->execute([
                ':message_content' => $message_content,
                ':id_message' => $id_message
            ]);
            $connection = null;
            $response = array('success' => true, 'message' => 'Message updated successfully.');
            header('Content-Type: application/json');
            return json_encode($response);
        }
    }
    function ifAuthorDeleteMessage($message_id) {

        $id = $_SESSION['id'];
        
        // J'appelle l'objet base de données
        $db = new Database();
        
        // Je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connection = $db->getConnection();

        // vérififie si auteur du message
        
        $sql = "
            SELECT transmitter_id 
            FROM private_message 
            WHERE private_message.transmitter_id = :id
            AND private_message.id = :id_message
        ";
        $statement = $connection->prepare($sql);
        
        // J'exécute la requête en fournissant la valeur du paramètre
        $statement->execute([
            ':id' => $id,
            ':id_message' => $id_message
        ]);
        
        // Je récupère le résultat de la requête
        $message = $statement->fetch(PDO::FETCH_ASSOC);
    
        if ($message) {
            // L'utilisateur est l'auteur du message, procéder à la suppression
            $sql = "
                DELETE FROM private_message 
                WHERE id = :message_id
            ";
            $deleteMessage = $connection->prepare($sql);

            $deleteMessage->execute([
                ':message_id' => $message_id
            ]);

            $message = "le message a bien été supprimé";
            header('Location: http://localhost:3000/Page/message.php?message=' . urlencode($message));
            exit;
    
        } else {
            // L'utilisateur n'est pas l'auteur du message
            $response = array('success' => false, 'message' => 'User is not the author of the message.');
        }
    
        // Éteindre la connexion à la DDB
        $connection = null;

    }
}