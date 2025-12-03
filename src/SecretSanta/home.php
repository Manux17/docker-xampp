<?php
session_start(); 

// Controlla se l'utente è loggato
if(!isset($_SESSION['utente'])) {
    header("Location: login.php");
    exit();
}

$host = 'db'; 
$dbname = 'SecretSanta'; 
$user = 'user';
$password = 'user';
$port = 3306;

$connection = new mysqli($host, $user, $password, $dbname, $port);

if ($connection->connect_error) {
    die("Errore di connessione: " . $connection->connect_error);
}

$nome = $_SESSION['utente']; 
$messaggio = "";

// Esegui la logica solo se l'utente preme il pulsante
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scopri'])) {
    // Controlla se l'utente ha già un abbinamento
    $query = "SELECT Abbinato FROM Abbinamenti WHERE Utente = '$nome'";
    $result = $connection->query($query);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $messaggio = "Il tuo Secret Santa è: " . $row['Abbinato'] . " 🎁";
    } else {
        // Prendi tutti gli utenti
        $query = "SELECT Nome FROM Utenti";
        $result = $connection->query($query);
        $utenti = [];
        while($row = $result->fetch_assoc()) {
            $utenti[] = $row['Nome'];
        }

        // Rimuovi il nome dell'utente loggato
        $possibili = array_diff($utenti, [$nome]);

        // Rimuovi i nomi già assegnati ad altri
        $query = "SELECT Abbinato FROM Abbinamenti";
        $result = $connection->query($query);
        while($row = $result->fetch_assoc()) {
            $possibili = array_diff($possibili, [$row['Abbinato']]);
        }

        // Scegli un nome a caso dai disponibili
        if(count($possibili) > 0) {
            $assegnato = $possibili[array_rand($possibili)];
            $query = "INSERT INTO Abbinamenti (Utente, Abbinato) VALUES ('$nome', '$assegnato')";
            $connection->query($query);
            $messaggio = "Il tuo Secret Santa è: $assegnato 🎁";
        } else {
            $messaggio = "Spiacente, nessun utente disponibile.";
        }
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Home Secret Santa</title>
    <link rel="icon" type="image/x-icon" href="immagini/babbo-natale-in-vespa.jpg">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #fff0f0, #ffe6e6);
            text-align: center;
            padding: 50px;
            color: #333;
        }

        h1 {
            color: #d62828;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.4em;
            margin-bottom: 30px;
        }

        .messaggio {
            font-size: 1.6em;
            color: #f77f00;
            font-weight: bold;
            margin: 30px 0;
        }

        .button {
            text-decoration: none;
            background-color: #f77f00;
            color: white;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1.2em;
            transition: all 0.3s ease;
            display: inline-block;
            margin: 10px 5px;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #d62828;
            transform: scale(1.05);
        }

        .logout {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #d62828;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .logout:hover {
            color: #f77f00;
        }
    </style>
</head>
<body>
    <h1>Ciao <?php echo $nome; ?>! 🎅</h1>
    <p>Benvenuto alla pagina del Secret Santa!</p>

    <!-- Form per scoprire il Secret Santa -->
    <form method="POST">
        <button type="submit" name="scopri" class="button">Scopri chi riceverà il tuo regalino</button>
    </form>

    <!-- Mostra il messaggio solo dopo il click -->
    <?php if($messaggio != ""): ?>
        <p class="messaggio"><?php echo $messaggio; ?></p>
    <?php endif; ?>

    <a href="home.php" class="button">Torna alla Home 🏠</a>
    <br>
    <a href="logout.php" class="logout">Logout</a>
</body>
</html>
