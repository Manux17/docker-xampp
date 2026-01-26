<?php
    session_start();

    if(isset($_SESSION['username']) && $_GET && isset($_GET['stanza']))
    {
        require_once("db.php");
        $stanza = $_GET['stanza'];

        // GESTIONE INVIO MESSAGGIO (POST)
        if($_POST && isset($_POST['messaggio']))
        {
            $messaggio = $_POST['messaggio'];
            $username = $_SESSION['username'];
            
            if(!empty($messaggio)) // se il messaggio non è vuoto
            {
                $stmt = $connection->prepare("INSERT INTO Messaggi (nomeStanza, user, testo, data) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("sss", $stanza, $username, $messaggio);
                $stmt->execute();
            }
        }

        // VISUALIZZAZIONE MESSAGGI
        echo "ECCO LA CHAT: " . ($stanza) . " TU SEI: " . ($_SESSION['username']);
        echo("<br>");
        
        $stmt = $connection->prepare("SELECT * FROM Messaggi WHERE nomeStanza=? ORDER BY data");
        $stmt->bind_param("s", $stanza); 
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                echo("<br>");
                echo($row['data']);
                echo(" - ");
                echo($row['user']);
                echo(": ");
                echo($row['testo']);
                echo("<br>");
            }
        }
        else
        {
            echo "Nessun messaggio trovato";
        }
        
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
    <br>
    <br>
    <form name="invioMess" method="POST" action="">
        <label for="messaggio">Scrivi un messaggio:</label><br>
        <input type="text" id="messaggio" name="messaggio">
        <button type="submit">Invia</button>
    </form>

    <br>
    <br>
    <a href='dashboard.php'> Torna alla dashboard </a>
</body>
</html>