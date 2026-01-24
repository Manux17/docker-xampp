<?php
    $host = 'db'; 
    $dbname = 'Chatroom'; 
    $user = 'user';
    $pass = 'user';
    $port = 3306;

    $connection = new mysqli($host, $user, $pass, $dbname, $port);

    if ($connection->connect_error) 
    {
        die("Errore di connessione: " . $connection->connect_error);
    }
?>