<?php
    session_start();

    //controllo se esiste la sessione e se è valida, poi controllo se esiste la post con i dati che voglio io
    //secondo controllo ridondante 
    if(isset($_SESSION['auth']) && $_SESSION['auth'] == true && $_POST && isset($_POST['nomeGiocattolo']) && isset($_POST['nomeElfo']))
    {
        $host = 'db'; 
        $dbname = 'babbonatale'; 
        $user = 'user';
        $password = 'user';
        $port = 3306;
        
        $connection = new mysqli($host, $user, $password, $dbname, $port);
        
        if ($connection->connect_error) 
        {
            die("Errore di connessione: " . $connection->connect_error);
        }

        $nomeGiocattolo = $_POST['nomeGiocattolo'];
        $nomeElfo = $_POST['nomeElfo'];

        //ci esponiamo alla SQL injection, bisognerebbe utilizzare il metodo prepare
        $query = "INSERT INTO `giocattoli`(`nomeGiocattolo`, `nomeElfo`) VALUES ('$nomeGiocattolo', '$nomeElfo')";

        $results = $connection->query($query);

        if ($connection->affected_rows > 0)
        {
            echo "Giocattolo inserito correttamente";
        }

        $connection->close();

        echo '<br>';
        echo '<a href="dashboard.php"> Schiaccia qui se vuoi ritornare al pannello</a>';
    }