<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>LOGIN</title>
</head>
<body>
    <h1>Questa è la pagina login</h1>

    <?php
        // passo 1: prendo i dati dalla richiesta http
        // passo 2: costruisco le query utilizzando i dati dell'utente
        // passo 3: eseguo le query
        // passo 4: prendo la risposta della query
        // passo 5: visualizzo i risultati

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
        
        //array super-global (dizionario / array associativi)

        $email = $_POST['email_post']; //email_post è la chiave del nostro array
        $password = $_POST['password_post'];
        $nome = $_POST['nome_post'];

        $query = "SELECT * FROM utenti WHERE email = '$email' AND password = '$password'"  

        $connection->close();
    ?>
</body>
</html>