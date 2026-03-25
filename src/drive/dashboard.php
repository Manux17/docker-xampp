<?php
session_start();
require_once("db.php");

// Se l'utente non è loggato, reindirizza al login
if (!isset($_SESSION['email'])) 
{
    header("Location: login.php");
}

$email = $_SESSION['email'];
$username = $_SESSION['username'];

// DOWNLOAD
// Se l'utente clicca su un file, lo scarica
if (isset($_GET['download']) && is_numeric($_GET['download'])) 
{
    $id = (int)$_GET['download'];

    // Prendo il file dal DB solo se appartiene all'utente loggato
    $stmt = $connection->prepare("SELECT f.nome, f.contenuto FROM FILES f JOIN OWN o ON f.ID = o.ID WHERE f.ID = ? AND o.email = ?");
    $stmt->bind_param("is", $id, $email);
    $stmt->execute();
    $row = $stmt->get_result();
    $dati = $row->fetch_assoc();

    if ($dati) 
    {
        header('Content-Disposition: attachment; filename="' . $dati['nome'] . '"');
        echo $dati['contenuto'];
    } 
    else 
    {
        echo "File non trovato.";
    }
}

// UPLOAD
// Se l'utente ha inviato un file tramite il form
$messaggio = "";
if (isset($_POST['submit'])) 
{
    $nome = $_FILES['file']['name'];
    $contenuto = file_get_contents($_FILES['file']['tmp_name']);

    // Inserisco il file nel DB
    $stmt = $connection->prepare("INSERT INTO FILES (nome, data, contenuto) VALUES (?, NOW(), ?)");
    $stmt->bind_param("sb", $nome, $contenuto);
    $stmt->execute();

    // Collego il file all'utente
    $id = $connection->insert_id;
    $stmt2 = $connection->prepare("INSERT INTO OWN (ID, email) VALUES (?, ?)");
    $stmt2->bind_param("is", $id, $email); 
    $stmt2->execute();

    $messaggio = "File caricato correttamente!";
}

// Recupero tutti i file dell'utente loggato
$stmt = $connection->prepare("SELECT f.ID, f.nome, f.data FROM FILES f JOIN OWN o ON f.ID = o.ID WHERE o.email = ? ORDER BY f.data DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$files = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo "Ciao, " . htmlspecialchars($username) . "!<br><br>"; 
if (!empty($files)) 
{
    echo "I tuoi file:<br>";
    foreach ($files as $f) 
    {
        echo "- <a href='?download=" . $f['ID'] . "'>" . htmlspecialchars($f['nome']) . "</a> - creato il: " . $f['data'] . "<br>";
    }
} 
else 
{
    echo "Non hai ancora nessun file.<br>";
}

if ($messaggio) 
{
    echo "<br>" . $messaggio . "<br>";
}

echo "<br>";
echo "<a href='login.php'>Ritorna al login</a>";
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data"> <!-- fix: mancava enctype -->
        <input type="file" name="file">
        <input type="submit" name="submit" value="Carica">
    </form>
</body>
</html>