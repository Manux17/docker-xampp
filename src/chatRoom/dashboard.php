<?php
    // Avvio della sessione per recuperare l'utente loggato
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Framework CSS Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">

    <!-- Titolo pagina -->
    <title>Chat Dashboard</title>
</head>
<body>

    <?php
        // Controllo se l'utente è loggato
        if(isset($_SESSION['username']))
        {
            // Recupero username dalla sessione
            $username = $_SESSION['username'];
    ?>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar is-dark" role="navigation">
        <div class="navbar-brand">
            <a class="navbar-item"><strong>ChatRoom</strong></a>
        </div>

        <!-- Username visualizzato in alto a destra -->
        <div class="navbar-end">
            <div class="navbar-item">
                <span><?php echo $username; ?></span>
            </div>
        </div>
    </nav>

    <!-- ================= CONTENUTO PRINCIPALE ================= -->
    <section class="section">
        <div class="container">

            <!-- Messaggio di benvenuto -->
            <div class="content has-text-centered mb-6">
                <h1 class="title is-2">Benvenuto, <?php echo $username; ?>!</h1>
                <p class="subtitle">Seleziona una chat o creane una nuova</p>
            </div>

            <?php
                // Connessione al database
                require_once("db.php");

                // Recupero delle chat a cui l'utente partecipa
                $stmt = $connection->prepare("SELECT nome FROM Partecipa WHERE user = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                // Se l'utente partecipa ad almeno una chat
                if($result->num_rows > 0)
                {
                    echo "<h2 class='title is-4'>Le tue Chat (" . $result->num_rows . ")</h2>";

                    // Stampa di ogni chat come bottone
                    while($row = $result->fetch_assoc())
                    {
                        echo "<div class='box mb-3'>";
                        echo "  <a href='chat.php?stanza=" . $row['nome'] . "' class='button is-link is-fullwidth has-text-left'>";
                        echo        $row['nome'];
                        echo "  </a>";
                        echo "</div>";
                    }
                }
                else
                {
                    // Nessuna chat trovata
                    echo "<div class='notification is-info'>";
                    echo "  <p>Non sei iscritto a nessuna chat ancora</p>";
                    echo "</div>";
                }
            ?>

            <!-- ================= PULSANTI AZIONE ================= -->
            <div class="mt-6 buttons is-centered">
                <!-- Creazione nuova chat -->
                <a href="nuovachat.php" class="button is-primary">Crea una Nuova Chat</a>

                <!-- Logout -->
                <a href="login.php" class="button is-danger">Logout</a>
            </div>
        </div>
    </section>

    <?php
        }
        else
        {
            // Se l'utente non è loggato, reindirizzamento al login
            header("Location: login.html");
        }
    ?>
</body>
</html>
