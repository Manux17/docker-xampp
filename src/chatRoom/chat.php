<?php

    session_start();
    if(isset($_SESSION['username']) && $_GET && isset($_GET['stanza']))
    {
        require_once("db.php");
        $stanza = $_GET['stanza'];

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    fare il coso per mandare i messaggi

</form>
</body>
</html>