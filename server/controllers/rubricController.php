<?php

//Inclusion du fichier pour la connexion a la BDD
require_once './debug.php';
require_once './database/client.php';


// Création du controller users

// class Rubric {

//     function getRubricsForOnePage ($id_page){

//         $db = new Database();
//         $conn = $db->getConnection();

//         // requete la table rubric pour récupeérer toutes les rubriques d'une page (id_page)
//         // renvoyer en json le résultat de la requête sql


//     }

//     function addOneRubricForOnePage ($id_page){


//             // 1. je récupère les champs du formulaire

//             // 2. Vérifier que l'utilisateur est connecté et qu'il est un administrateur
//             // 2.a recupérer l'id de l'utilisateur dans la session

//             // 2.b requéter la base de donnée pour savoir si le role est admin
//             //SELECT role.name 
//             //FROM role 
//             //JOIN role_page
//             //ON role.id = role_page.role_id
//             //WHERE role_page.user_id = $1

//             // créer une variable qui contient l'id de l'utilisateur
//             session_start();

//             // requéter le role_id de la table role_page  join avec l'id de la table role de la base de donnée

//             if(isset($_SESSION['id'])) {
//                 $db = new Database();
//                 $conn = $db->getConnection();
//                 // Préparation de la requête d'insertion
//                 $stmt = $conn->prepare("INSERT INTO rubriques (titre, contenu, id_page) VALUES (:title, ?, ?)");
//                 // Liaison des paramètres
//                 $stmt->execute([

//                 ]);

//                 // renvoyer une réponse pour prévenir l'utilisateur du succès de l'ajout de la rubric
//             }
//              else {
//                 // Renvoyer un message d'erreur, en json

//             }
//     }



//         function addOneRubricForOnePage($id_page) {
//         // Vérifier que l'utilisateur est connecté et qu'il est un administrateur
//         session_start();
//         if(isset($_SESSION['id']) && $_SESSION['is_admin'] === true) {
//             // Connexion à la base de données
//             $conn = new mysqli('localhost', 'user', 'motdepasse', 'ma_base_de_donnees');
//             // Vérification de la connexion
//             if ($conn->connect_error) {
//                 die("La connexion a échoué: " . $conn->connect_error);
//             } 
//             // Préparation de la requête d'insertion
//             $stmt = $conn->prepare("INSERT INTO rubriques (titre, contenu, id_page) VALUES (?, ?, ?)");
//             // Liaison des paramètres
//             $stmt->bind_param("ssi", $titre, $contenu, $id_page);
//             // Définition des variables pour le titre et le contenu de la rubrique
//             $titre = ""; // Mettre ici le titre de la rubrique
//             $contenu = ""; // Mettre ici le contenu de la rubrique
//             // Exécution de la requête
//             $stmt->execute();
//             // Vérification de l'insertion
//             if ($stmt->affected_rows > 0) {
//                 echo "La rubrique a été ajoutée avec succès.";
//             } else {
//                 echo "Erreur lors de l'ajout de la rubrique.";
//             }
//             // Fermeture de la connexion et du statement
//             $stmt->close();
//             $conn->close();
//         } else {
//             // Renvoyer un message d'erreur
//             echo "Vous n'êtes pas autorisé à effectuer cette action.";
//         }

//     }








//     function deleteRubricsForOnePage ($id_rubric){

//             // Vérifier que l'utilisateur est bien connecté et est un administrateur
//             if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//                 return json_encode(['error' => 'Unauthorized access']);
//             }

//             // Créer une instance de la classe Rubric pour accéder aux méthodes permettant de manipuler les rubriques
//             $rubricModel = new Rubric();

//             // Récupérer la rubrique spécifiée par $id_rubric
//             $rubric = $rubricModel->getRubricById($id_rubric);

//             // Vérifier que la rubrique existe
//             if (!$rubric) {
//                 return json_encode(['error' => 'Rubric not found']);
//             }

//             // Supprimer la rubrique
//             $rubricModel->deleteRubricById($id_rubric);

//             // Retourner un message de succès
//             return json_encode(['message' => 'Rubric deleted successfully']);





//     }

//     function updateRubricsForOnePage ($id_rubric){


//             // Vérifier que l'utilisateur est bien connecté et est un administrateur
//             if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//                 return json_encode(['error' => 'Unauthorized access']);
//             }

//             // Créer une instance de la classe Rubric pour accéder aux méthodes permettant de manipuler les rubriques
//             $rubricModel = new Rubric();

//             // Récupérer la rubrique spécifiée par $id_rubric
//             $rubric = $rubricModel->getRubricById($id_rubric);

//             // Vérifier que la rubrique existe
//             if (!$rubric) {
//                 return json_encode(['error' => 'Rubric not found']);
//             }

//             // Supprimer la rubrique
//             $rubricModel->deleteRubricById($id_rubric);

//             // Retourner un message de succès
//             return json_encode(['message' => 'Rubric deleted successfully']);


//     }

// }
