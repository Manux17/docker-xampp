<h1> Hello world! </h1>

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

    echo "Connessione al database riuscita con mysqli! <br>";

    $email = "anna.moretti@example.com";
    $password = "AnnaPass99";

    $query = "SELECT * FROM User WHERE email='$email' AND password='$password'";

    echo $query;
    echo "<br>";

    $result = $connection->query($query);
    var_dump($result);

    $row = $result->fetch_assoc();
    echo "<h1>" . $query . "</h1>";
    echo "Nome: " . $row['nome'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Password: " . $row['password'] . "<br>";
    echo "<br>";

    if($result->num_rows > 0)
    {
        echo "LOGIN CORRETTO";
    }
    else
    {
        echo "LOGIN FALLITO";
    }

    //voglio visualizzare i dati dentro la tabella User
    $query = "SELECT * FROM User";
    $result = $connection->query($query);
    echo "<h1>" . $query . "</h1>";

    $row = $result->fetch_assoc(); //senza il while non stampa nulla 
    echo "Nome: " . $row['nome'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Password: " . $row['password'] . "<br>";
    echo "<br>";

    while ($row = $result->fetch_assoc())  //ho fatto il while perchè abbiamo più righe
    {
        echo "Nome: " . $row['nome'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Password: " . $row['password'] . "<br>";
        echo "<br>";
    }


    $connection->close();
?>

PROVA!