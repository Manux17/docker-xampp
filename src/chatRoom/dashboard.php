<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_SESSION['username']))
        {
            $username = $_SESSION['username'];
            echo "<h1 class=title is-2> Benvenuto " . $username . "</h1>";

            require_once("db.php");

            $stmt = $connection->prepare("SELECT nome FROM Partecipa WHERE user = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0)
            {
                echo "Ecco qua le tue chatroom disponibili:";
                while($row = $result->fetch_assoc())
                {
                    echo "<br>";
                    echo "<a href='chat.php?stanza=" . $row['nome'] . "'>" . $row['nome'] . "</a>";
                    echo "<br>";
                }
            }

            echo "<br>";
            echo "<a href='nuovachat.php' class='button'> CREA UN NUOVA CHAT </a>";

            echo "<br>";
            echo "<br>";
            echo "<a href='login.html' class='button'> LOGOUT";
        }
    ?>
</body>
</html>
