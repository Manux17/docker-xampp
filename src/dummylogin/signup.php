<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>LOGIN</title>
</head>
<body>
    <?php
        $host = 'db'; 
        $dbname = 'root_db'; 
        $user = 'user';
        $password = 'user';
        $port = 3306;
        
        $connection = new mysqli($host, $user, $password, $dbname, $port);
        
        if ($connection->connect_error) {
            die("Errore di connessione: " . $connection->connect_error);
        }

        $email = $_POST['email_post']; //email_post è la chiave del nostro array
        $password = $_POST['password_post'];
        $nome = $_POST['nome_post'];

        $query = "INSERT INTO User (nome, email, password) 
                    VALUES ('$nome', '$email', '$password')";

        $result = $connection->query($query);
        
        $row = $result->fetch_assoc();

        if ($result->num_rows > 0) 
        {   
            echo "utente trovato" . "<br>"; 
            echo "<h1> Benvenuto " . $row['nome'] . "</h1>" . "<br>";
        }
        else
        {
            echo "utente non trovato";
        }

        $connection->close();
    ?>
</body>
</html>