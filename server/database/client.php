<?php

require_once './debug.php';

class Database {
    
    function getConnection () {
        
        // variables de connection a la bdd
        $host = "localhost";
        $dbname = "connectify";
        $username = "connectify";
        $password = "connectify";
        $port = 3306;

        $connection = null;
        try {
            $connection = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Erreur de connexion:" . $exception->getMessage();
        }

        return $connection;
    }
}