<?php
    session_start();
    
    if($_SESSION && isset($_SESSION['email']) && $_POST && isset($_POST['submit']) && isset($_FILES))
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

        if(isset($_FILES['file']))
        {
            $percorso = $_FILES['file']['tmp_name'];
    
            if(file_exists($percorso))
            {
                $nome = $_FILES['file']['name'];
                $contenuto = file_get_contents($percorso);

                $stmt = $connection->prepare("INSERT INTO FILES (nome, data, contenuto) VALUES (?, NOW(), ?)");
                $stmt->bind_param("s", $nome, $contenuto);
                $stmt->execute();

                $connection->insert_id; 
                $stmt2 = $connection->prepare("INSERT INTO OWN (ID, email) VALUES (?, ?)"); 
                $stmt2->bind_param("is", $fileId, $_SESSION['email']); 
                $stmt2->execute();



            }
        }


        echo "<br>";
        echo "<a href='login.php'>Ritorna al login</a>";
    }
    else
    {
        header("Location: login.php");    
    }
?>

<!DOCTYPE html>
<html>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
            Seleziona il file da caricare:
            <input type="file" name="file" id="file">
            <input type="submit" value="Inserisci" name="submit">
        </form>
    </body>
</html>