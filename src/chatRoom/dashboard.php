<?php
    session_start();
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
        echo "<h1> Benvenuto " . $username . "</h1>";

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
        echo "<a href='nuovachat.php'> CREA UN NUOVA CHAT </a>";
    }
?>