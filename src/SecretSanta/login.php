<?php
    session_start(); // ATTIVA LE SESSIONI

    $host = 'db'; 
    $dbname = 'SecretSanta'; 
    $user = 'user';
    $password = 'user';
    $port = 3306;

    $connection = new mysqli($host, $user, $password, $dbname, $port);

    if ($connection->connect_error) 
    {
        die("Errore di connessione: " . $connection->connect_error);
    }

    $nome = $_POST['nome_post'];
    $password = $_POST['password_post'];

    $query = "SELECT * FROM Utenti WHERE Nome = '$nome' AND Password = '$password'";
    $results = $connection->query($query);

    // LOGIN OK
    if($results->num_rows > 0)
    {
        $_SESSION['utente'] = $nome; // SALVO IL NOME UTENTE
        header("Location: home.php");
        exit;
    }

    // LOGIN FALLITO → mostro la pagina HTML con l’errore
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Errore Login</title>
    <link rel="icon" type="image/x-icon" href="immagini/babbo-natale-in-vespa.jpg">

    <style>
        body
        {
            background: linear-gradient(135deg, #b30000, #8b0000);
        }
    </style>
    
</head>
<body>
    <h1>Nome utente o password errati bisogna che te svegli</h1>
    <a href="login.html">
        <button>
            Torna alla pagina login
        </button>

    </a>
</body>
</html>