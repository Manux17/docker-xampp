<?php

//presi dal docker-compose.yml
$host = 'db'; 
$dbname = 'root_db'; 
$user = 'user';
$password = 'user';
$port = 3306;

$connection = new mysqli($host, $user, $password, $dbname, $port);

if ($connection->connect_error) {
    die("Errore di connessione: " . $connection->connect_error);
}

echo "Connessione al database riuscita con mysqli!";

// logica
// passo 1: prendo i dati dalla richiesta http
// passo 2: costruisco le query utilizzando i dati dell'utente
// passo 3: eseguo le query
// passo 4: prendo la risposta della query
// passo 5: visualizzo i risultati

$connection->close();
