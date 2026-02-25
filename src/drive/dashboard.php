<?php
    session_start();
    
    if($_SESSION && isset($_SESSION['email']))
    {
        echo "Ciao, $_SESSION[username]!";
        echo "<br><br>";

        require_once("db.php");

        $stmt = $connection->prepare("SELECT f.ID, f.nome, f.data FROM FILES f JOIN OWN o ON f.ID = o.ID WHERE o.email = ?");
        $stmt->bind_param("s", $_SESSION['email']);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            echo "I tuoi file:<br><br>";
            while($row = $result->fetch_assoc())
            {
                echo "- $row[nome] - creato il: $row[data] <br>";
            }
        }
        else
        {
            echo "Non hai ancora nessun file.";
        }

        echo "<br>";
        echo "<a href='nuovo_file.php'>Crea un nuovo file</a>";

        echo "<br>";
        echo "<a href='login.php'>Ritorna al login</a>";
    }
    else
    {
        header("Location: login.php");    
    }
?>