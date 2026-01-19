<?php

    if ($_POST && isset($_POST['username']) && isset($_POST['password'])) 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connessione al DB
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

        // Controllo se l'utente esiste già
        $stmt = $connection->prepare("SELECT user FROM Utenti WHERE user = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            echo "Utente già esistente!";
            echo '<a href="registrazione.html">Torna alla registrazione</a>';
        } 
        else 
        {
            // Inserimento nel DB
            $passwordHashata = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $connection->prepare("INSERT INTO Utenti (user, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $passwordHashata);

            if ($stmt->execute()) 
            {
                echo "Registrazione completata!";
                echo '<a href="login.html">Vai al login</a>';
            } 
            else 
            {
                echo "Errore durante la registrazione.";
            }
        }

        $stmt->close();
        $connection->close();
    }
?>