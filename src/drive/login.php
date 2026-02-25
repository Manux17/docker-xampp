<?php
    if($_POST && isset($_POST['email']) && isset($_POST['password']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        require_once("db.php");

        $stmt = $connection->prepare("SELECT password, username FROM USERS WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $contents = $stmt->get_result();

        if($contents->num_rows === 1)
        {
            $row = $contents->fetch_assoc();
            $hashSalvato = $row['password'];
            if(password_verify($password, $hashSalvato))
            {
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $row['username'];
                header("Location: dashboard.php");
            }
            else
            {
                echo "Password errata";
            }
        }
        else
        {
            echo "Errore nel login";
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
    <form name="loginForm" method="POST" action="">
        <label for="user">Email</label>
        <input type="email" id="email" name="email">

        <label for="password">Password</label>
        <input type="password" id="password" name="password">

        <button type="submit">LOGIN</button>
    </form>
    <a href="signin.php">REGISTRATI</a>
</body>
</html>