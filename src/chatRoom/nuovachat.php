<?php
    session_start();
    require_once("db.php");

    if($_SESSION && isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
        echo "Benvenuto " . $username;

        echo "<form name='nuovaStanza' method='POST' action=''>";
            echo "<label for='nomeStanza'>Nome della chat:</label>";
            echo "<input type='text' id='nomeStanza' name='nomeStanza'>";
            echo "<button type='submit'>Invia</button>";
        echo "</form>";
        
        if($_POST && isset($_POST['nomeStanza']))
        {
            $nomeChat = $_POST['nomeStanza'];

            $stmt = $connection->prepare("INSERT INTO Stanze (nome,creatore) VALUES (?, ?)");
            $stmt->bind_param("ss", $nomeChat, $username);
            $stmt->execute();

            $stmt = $connection->prepare("INSERT INTO Partecipa (nome, user) VALUES (?, ?)");
            $stmt->bind_param("ss", $nomeChat, $username);
            $stmt->execute();

            if($stmt->affected_rows >0)
            {
                echo "Stanza creata";
            }
        }

        echo "<br>";
        echo "<br>";
        echo "<a href='dashboard.php'> TORNA ALLA DASHBOARD </a>";
    }


