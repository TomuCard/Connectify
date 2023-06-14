<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';
session_start();


// Création du controller users

class Group {

    function getAllgroupForOneUser ($id){
        
        $db = new Database();

        $connexion = $db->getConnection();

        // je récupère tout les group d'un utilisateur 
        $request = $connexion->prepare("  
            SELECT group.name, group.status, group.id
            FROM member
            JOIN `group`
            ON member.group_id = group.id
            WHERE member.user_id = :id
            AND member.status = 1
        ");
        
        $request->execute([
            ':id' => $id
        ]);

        $groups = $request->fetchAll(PDO::FETCH_ASSOC);

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($groups);
    }

    function getOnegroupInfo ($group_id){

        $db = new Database();

        $connexion = $db->getConnection();

        // je récupère tout les group d'un utilisateur 
        $request = $connexion->prepare("  
            SELECT group.name, group.description
            FROM `group`
            WHERE group.id = :group_id
        ");
        
        $request->execute([
            ':group_id' => $group_id
        ]);

        $group = $request->fetch(PDO::FETCH_ASSOC);

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($group);
    }

    function addGroupPublicOrPrivateForOneUser (){

        // je récupère les champs du formulaire 
        $name = $_POST['name'];
        $description = $_POST['description'];
        $status = $_POST['status'];
       
        // je récupère l'id de l'utilisateur
        $id = $_SESSION['id'];


        $db = new Database();

        $connexion = $db->getConnection();

        $requestGroup = $connexion->prepare("
            INSERT INTO `group` (group.name, group.description, group.status)
            VALUES (:name, :description, :status);
        ");

        $requestGroup->execute([
            'name' => $name,
            'description' => $description,
            'status' => $status
        ]);

        $group_id = $connexion->lastInsertId();

        $requestMember = $connexion->prepare("
            INSERT INTO member (group_id, user_id, role_id)
            VALUES (:group_id, :user_id, 3);
        ");

        $requestMember->execute([
            'group_id' => $group_id,
            'user_id' => $id
        ]);

        $connection = null;
        header('Location: http://localhost:3000/Page/group.php');
        exit;

    }

    function joinGroupPublicOrPrivateForOneUser ($group_id){

        // je récupère l'id de l'utilisateur
        $id = $_SESSION['id'];

        $db = new Database();

        $connexion = $db->getConnection();

        // je vérifie le status du groupe
        $request = $connexion->prepare("  
            SELECT group.status
            FROM group
            WHERE group.id = :group_id
        ");
        
        $request->execute(['group_id' => $group_id]);

        $group = $request->fetch(PDO::FETCH_ASSOC);

        switch($group['status']){
            case 'public':

                $request = $connexion->prepare("  
                    INSERT INTO member (group_id, user_id, role_id)
                    VALUES (:group_id, :user_id, 4);
                ");
                
                $request->execute([
                    'group_id' => $group_id,
                    'user_id' => $id
                ]);
        
                $request = $connexion->prepare("INSERT INTO member (member.group_id, member.user_id, member.role_id, member.status) VALUES (:group_id, :user_id, 4, 1)");
                $request->execute([
                    'group_id' => $group_id,
                    'user_id' => $id
                ]);
        
                $connection = null;
        
                $message = "Félicitation vous avez rejoint le groupe";
                header('Location: http://localhost:3000/Page/#.php/' . $group_id . '?message=' . urlencode($message));
                exit;
            break;

            case 'private':

                // je récupère les admins
                $request = $connexion->prepare("
                    SELECT member.user_id 
                    FROM member 
                    WHERE member.role_id = 3 
                    AND member.group_id = :group_id
                
                ");

                $request->execute(['group_id' => $group_id]);

                // je récupère les admins du group
                $admins = $request->fetchAll(PDO::FETCH_ASSOC);

                $request = $connexion->prepare("
                    SELECT user.firstname, user.lastname
                    FROM user 
                    WHERE user.id = :id  
                ");

                $request->execute(['id' => $id]);

                // nom et prénom de l'utilisateur qui veut rejoindre le groupe 
                $result = $request->fetch(PDO::FETCH_ASSOC);

                // je vérifie que l'utilisateur n'est pas déja en attente dans le groupe
                $request = $connexion->prepare("
                    SELECT *
                    FROM member 
                    WHERE member.user_id = :id
                    AND member.group_id = :group_id  
                ");

                $request->execute([
                    'id' => $id,
                    'group_id' => $group_id
                
                ]);

                $member = $request->fetch(PDO::FETCH_ASSOC);

                // Si aucun résultat = pas de demande en attente
                if(!$member){

                    $request = $connexion->prepare("INSERT INTO member (member.group_id, member.user_id, member.role_id) VALUES (:group_id, :user_id, 4)");
                    $request->execute([
                        'group_id' => $group_id,
                        'user_id' => $id
                    ]);
                    
                    // message à envoyer aux admins 
                    $message = $result['lastname'] . ' ' . $result['firstname'] . ' ' . "Souhaite rejoindre votre groupe";

                    // pour chaque admin dans admins
                    foreach ($admins as $admin) {
                        $transmitter_id = $id;
                        $receiver_id = $admin;
                        $message_content = $message;
                        
                        // j'envoie un message
                        $request = $connexion->prepare("
                            INSERT INTO private_message (transmitter_id, receiver_id, message_content)
                            VALUES (:transmitter_id, :receiver_id, :message_content);
                        ");
                    
                        $request->execute([
                            'transmitter_id' => $transmitter_id,
                            'receiver_id' => $receiver_id,
                            'message_content' => $message_content
                        ]);
                    }
                    $connection = null;
                    header('Content-Type: application/json');
                    echo json_encode("En attente ");
                }else{
                    $connection = null;
                    $message = "Vous avez déjas candidater dans ce groupe";
                    header('Location: http://localhost:3000/Page/#.php/?message=' . urlencode($message));
                    exit;
                }
            break;
        }

       
    }

    function addRelationOnGroup ($group_id, $relation_id){

        $id = $_SESSION['id'];

        // je me connecte a la base de donnée
        $db = new Database();

        $connexion = $db->getConnection();

        // je vérrifie le status du groupe
        $request = $connexion->prepare("  
            SELECT group.status
            FROM group
            WHERE group.id = :group_id
        ");
        
        $request->execute(['group_id' => $group_id]);

        $group = $request->fetch(PDO::FETCH_ASSOC);

        switch($group['status']){

            case 'public':
                // je récupère le nom et prénom de l'émetteur du message
                $request = $connexion->prepare("
                    SELECT user.firstname, user.lastname
                    FROM user 
                    WHERE user.id = :id  
                ");
        
                $request->execute(['id' => $id]);
        
                $transmitter = $request->fetch(PDO::FETCH_ASSOC);
        
                // j'envoie un message privé a l'utilisateur que je veux ajouter dans le groupe
                $request = $connexion->prepare("
                    INSERT INTO private_message 
                    (private_message.message_content, private_message.transmitter_id, private_message.receiver_id) 
                    VALUES (:message_content, :transmitter_id, :receiver_id)
                ");
        
                $message = $transmitter['firstname'] . ' ' . $transmitter['lastname'] . ' ' . 'vous invite a rejoindre un groupe';
        
                $request->execute([
                    'message_content' => $message,
                    'transmitter_id' => $id,
                    'receiver_id' => $relation_id
                ]);
        
                $connection = null;
        
                $message = "Le message a bien été envoyer";
                header('Location: http://localhost:3000/Page/#.php/?message=' . urlencode($message));
                exit;
                break;

            case 'private' :
                // je vérifie que l'utilisateur est admin
                $request = $connexion->prepare("
                    SELECT member.role_id
                    FROM member 
                    WHERE member.user_id = :id
                    AND member.group_id = :group_id  
                ");

                $request->execute([
                    'id' => $id,
                    'group_id' => $group_id
                
                ]);

                $isAdmin = $request->fetch(PDO::FETCH_ASSOC);

                if ($isAdmin == 3){
                     // je récupère le nom et prénom de l'émetteur du message
                    $request = $connexion->prepare("
                        SELECT user.firstname, user.lastname
                        FROM user 
                        WHERE user.id = :id  
                    ");
            
                    $request->execute(['id' => $id]);
            
                    $transmitter = $request->fetch(PDO::FETCH_ASSOC);
            
                    // j'envoie un message privé a l'utilisateur que je veux ajouter dans le groupe
                    $request = $connexion->prepare("
                        INSERT INTO private_message 
                        (private_message.message_content, private_message.transmitter_id, private_message.receiver_id) 
                        VALUES (:message_content, :transmitter_id, :receiver_id)
                    ");
            
                    $message = $transmitter['firstname'] . ' ' . $transmitter['lastname'] . ' ' . 'vous invite a rejoindre un groupe';
            
                    $request->execute([
                        'message_content' => $message,
                        'transmitter_id' => $id,
                        'receiver_id' => $relation_id
                    ]);
            
                    $connection = null;
            
                    $message = "Le message a bien été envoyer";
                    header('Location: http://localhost:3000/Page/#.php/?message=' . urlencode($message));
                    exit;

                }else{
                    $connection = null;
                    $message = "seul les admins peuvent inviter a rejoindre le group";
                    header('Location: http://localhost:3000/Page/#.php/?message=' . urlencode($message));
                    exit;
                }
                break;

        }



    }

    function acceptOrDeniedCandidateInGroup ($group_id, $cadidate_id){

        $isAccepted = $_POST['isAccepted'];
        
         // je me connecte a la base de donnée
         $db = new Database();

         $connexion = $db->getConnection();

         // vérifier que le candidat ne fait pas déja parti du groupe
         $request = $connexion->prepare("
            SELECT *
            FROM member 
            WHERE member.user_id = :id
            AND member.group_id = :group_id  
        ");

        $request->execute([
            'id' => $cadidate_id,
            'group_id' => $group_id
        
        ]);

        $member = $request->fetch(PDO::FETCH_ASSOC);

        if(!$member){
            
            switch($isAccepted){
                // si accepté 
               case TRUE :
                   $request = $connexion->prepare("INSERT INTO member (member.group_id, member.user_id, member.role_id, member.status) VALUES (:group_id, :user_id, 4, 1)");
                   $request->execute([
                       'group_id' => $group_id,
                       'user_id' => $cadidate_id
                   ]);
                   $connection = null;
                   $message = "Félicitation vous avez rejoint le groupe";
                   header('Location: http://localhost:3000/Page/#.php/' . $group_id . '?message=' . urlencode($message));
                   exit;
                   break;
               // si refusé
               case FALSE :
                   $request = $connexion->prepare("
                       DELETE FROM member 
                       WHERE member.user_id = :id
                       AND member.group_id = :group_id
                   ");
                   $request->execute([
                       ':id' => $cadidate_id,
                       'group_id' => $group_id
                   
                   ]);
                   $connection = null;
                   $message = "Vous avez refuser de rejoindre le groupe ou votre candidature a été refuser";
                   header('Location: http://localhost:3000?message=' . urlencode($message));
                   exit; 
                   break;
            };
        }else{
            $connection = null;
            $message = "Vous avez déjas candidater dans ce groupe ou vous faite déja partie du groupe";
            header('Location: http://localhost:3000/Page/#.php/?message=' . urlencode($message));
            exit;
        }

    }

    function ifAdminSetOtherAdminInGroup ($group_id, $user_id){

        // je récupère l'id de l'utilisateur
        $id = $_SESSION['id'];

        $db = new Database();

        $connexion = $db->getConnection();

        // je vérifie que l'utilisateur est admin
        $request = $connexion->prepare("
            SELECT member.role_id
            FROM member 
            WHERE member.user_id = :id
            AND member.group_id = :group_id  
        ");

        $request->execute([
            'id' => $id,
            'group_id' => $group_id
        
        ]);

        $isAdmin = $request->fetch(PDO::FETCH_ASSOC); 

        // si admin
        if ($isAdmin == 3){
            // je modifie le role du user concerné
            $request = $connexion->prepare("
            UPDATE member 
            SET(
                member.role_id = 3 
                WHERE member.user_id = :user_id
                AND member.group_id = :group_id
            )");

            $request->execute(
                [
                    ':user_id' => $user_id,
                    ':group_id' => $group_id
                ]
            );
            // Fermeture de la connexion
            $connection = null;
            $message = "L'utilisateur est maintenent admin";
            header('Location: http://localhost:3000/Page/#.php/' . $group_id . '?message=' . urlencode($message));
            exit;
        // si pas admin    
        }else{
            $message = "Vous n'avez pas l'authorisation de faire cela";
            header('Location: http://localhost:3000/Page/#.php/' . $group_id . '?message=' . urlencode($message));
            exit;
        }

    }

    function ifAdminBanishMember ($group_id, $user_id){

        // je récupère l'id de l'utilisateur
        $id = $_SESSION['id'];

        $db = new Database();

        $connexion = $db->getConnection();

        // je vérifie que l'utilisateur est admin
        $request = $connexion->prepare("
            SELECT member.role_id
            FROM member 
            WHERE member.user_id = :id
            AND member.group_id = :group_id  
        ");

        $request->execute([
            'id' => $id,
            'group_id' => $group_id
        
        ]);

        $isAdmin = $request->fetch(PDO::FETCH_ASSOC);
        
        // si admin
        if ($isAdmin == 3){
            // je modifie le status du user concerné
            $request = $connexion->prepare("
            UPDATE member 
            SET(
                member.status = 2 
                WHERE member.user_id = :user_id
                AND member.group_id = :group_id
            )");

            $request->execute(
                [
                    ':user_id' => $user_id,
                    ':group_id' => $group_id
                ]
            );
            // Fermeture de la connection
            $connection = null;
            $message = "L'utilisateur est banis !";
            header('Location: http://localhost:3000/Page/#.php/' . $group_id . '?message=' . urlencode($message));
            exit;
        // si pas admin    
        }else{
            $message = "Vous n'avez pas l'authorisation de faire cela";
            header('Location: http://localhost:3000/Page/#.php/' . $group_id . '?message=' . urlencode($message));
            exit;
        }
 
    }

    function ifAdminUpdateGroupInfo ($group_id){

        // je récupère l'id de l'utilisateur
        $id = $_SESSION['id'];

        // je récupère les champs du formulaire
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $status = filter_input(INPUT_POST, 'status');

        $db = new Database();

        $connexion = $db->getConnection();

        // je vérifie que l'utilisateur est admin
        $request = $connexion->prepare("
            SELECT member.role_id
            FROM member 
            WHERE member.user_id = :id
            AND member.group_id = :group_id  
        ");

        $request->execute([
            'id' => $id,
            'group_id' => $group_id
        
        ]);

        $isAdmin = $request->fetch(PDO::FETCH_ASSOC);

        // si admin
        if ($isAdmin == 3){
            // Je vérifie que tous les champs soit remplis
            if($name && $description && $status){

                // je prépare ma requète
                $request = $connexion->prepare("
                    UPDATE group SET(
                        group.name = :name,
                        group.description = :description,
                        group.status = :status
                    WHERE
                        group.id = :group_id;
                )");

                $request->execute(
                    [
                        ":name" => $name,
                        ":description" => $description,
                        ":status" => $status,
                        ":id" => $group_id
                    ]
                );
                // Fermeture de la connection
                $connection = null;

                $message = "les modifications ont bien été prit en compte";
                header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
                exit;

            }else {
                $connection = null;
                $message = "Tout les champs sont requis";
                header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
                exit;
            }
        
        }else{
            $message = "Vous n'avez pas l'authorisation de faire cela";
            header('Location: http://localhost:3000/Page/#.php/' . $group_id . '?message=' . urlencode($message));
            exit;
        }
    }


    
}