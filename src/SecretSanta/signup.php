<?php
    $host = 'db'; 
    $dbname = 'SecretSanta'; 
    $user = 'user';
    $password = 'user';
    $port = 3306;

    $connection = new mysqli($host, $user, $password, $dbname, $port);

    if ($connection->connect_error) {
        die("Errore di connessione: " . $connection->connect_error);
    }

    $nome = $_POST['nome_post'];
    $password = $_POST['password_post'];

    $query = "SELECT * FROM Utenti WHERE Nome = '$nome'";
    $results = $connection->query($query);

    if($results->num_rows > 0)
    {
        echo "<h1>" . "T'hanne rubato il nome cogl'Ion" . "</h1>";
    }
    else
    {
        $query = "INSERT INTO Utenti (Nome, Password) VALUES ('$nome', '$password')";
        $connection->query($query);
        header("Location: login.html");
        exit;
    }        
?>
