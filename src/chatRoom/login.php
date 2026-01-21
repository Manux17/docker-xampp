<?php
    if ($_POST && isset($_POST['username']) && isset($_POST['password'])) 
    {

        $username = $_POST['username'];
        $password = $_POST['password'];

        require_once("db.php");

        $stmt = $connection->prepare("SELECT password FROM Utenti WHERE user = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) 
        {

            $row = $result->fetch_assoc();
            $hashSalvato = $row['password'];

            if (password_verify($password, $hashSalvato)) 
            {
                session_start();
                $_SESSION['username']= $username;
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