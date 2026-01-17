<?php
    if ($_POST && isset($_POST['username']) && isset($_POST['password'])) 
    {

        $username = $_POST['username'];
        $password = $_POST['password'];

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

        $stmt = $connection->prepare("SELECT password FROM Utenti WHERE user = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) 
        {

            $row = $result->fetch_assoc();
            $hashSalvato = $row['password'];


            if ($password === $hashSalvato) 
            {
                session_start();
                $_SESSION['user']=$username;
                header("Location: dashboard.php");
            } 
            else 
            {
                echo "Password errata";
                echo "<a href='login.html'>Torna alla pagina di login</a>";
            }

        } 
        else 
        {
            echo "Utente non trovato";
            echo "<a href='registrazione.html'>REGISTRATI DEFICENTE! </a>";
        }

        $stmt->close();
        $connection->close();
    }
?>