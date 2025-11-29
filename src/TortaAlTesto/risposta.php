<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Risposta</title>
</head>
<body>
    <h1>Questa è la pagina risposta</h1>

    <?php
        //array super-global (dizionario / array associativi)

        $email = $_POST['email_post']; //email_post è la chiave del nostro array
        $password = $_POST['password_post'];
        $nome = $_POST['nome_post'];

        if($email == "ragione@lamia.sempre" && $password == "ciao" && $nome == "Ciao")
        {
            echo "LOGIN EFFETTUATA";
        }
        else
        {
            echo "LOGIN FALLITA";
        }
    ?>
</body>
</html>