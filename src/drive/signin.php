<?php
    if ($_POST && isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['email'])) 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        require_once("db.php");

        $stmt = $connection->prepare("SELECT username FROM USERS WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) 
        {
            $messaggio = "Utente già esistente!";
        } 
        else 
        {
            $passwordHashata = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $connection->prepare("INSERT INTO USERS (username, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $passwordHashata, $email);

            if ($stmt->execute()) 
            {
                echo'Registrazione completata! Accedi al tuo account.';
            } 
            else 
            {
                echo 'Errore durante la registrazione.';
            }
        }
        echo "<a href='login.php'>Torna al login</a>";
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
<form name="regFORM" method="POST" action="">
        <label for="email">Email</label>
        <input type="email" id="email" name="email">

        <label for="user">Username</label>
        <input type="text" id="username" name="username">

        <label for="password">Password</label>
        <input type="password" id="password" name="password">

        <button type="submit">REGISTRATI</button>
    </form>
</body>
</html>


