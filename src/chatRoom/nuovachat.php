<?php
    // Avvio della sessione
    session_start();

    // Connessione al database
    require_once("db.php");

    // Controllo se l'utente è loggato
    if($_SESSION && isset($_SESSION['username']))
    {
        // Recupero username dalla sessione
        $username = $_SESSION['username'];

        // Flag per verificare se la chat è stata creata correttamente
        $aggiunta = false;
        
        // Controllo invio form con nome della stanza
        if($_POST && isset($_POST['nomeStanza']))
        {
            // Nome della nuova chat
            $nomeChat = $_POST['nomeStanza'];

            // Inserimento della nuova stanza con il creatore
            $stmt = $connection->prepare("INSERT INTO Stanze (nome,creatore) VALUES (?, ?)");
            $stmt->bind_param("ss", $nomeChat, $username);
            $stmt->execute();

            // Inserimento automatico del creatore come partecipante
            $stmt = $connection->prepare("INSERT INTO Partecipa (nome, user) VALUES (?, ?)");
            $stmt->bind_param("ss", $nomeChat, $username);
            $stmt->execute();

            // Controllo se l'inserimento è avvenuto correttamente
            if($stmt->affected_rows > 0)
            {
                $aggiunta = true;
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Framework CSS Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">

    <!-- Titolo pagina -->
    <title>Crea una Nuova Chat</title>
</head>
<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar is-dark" role="navigation">
        <div class="navbar-brand">
            <a class="navbar-item">
                <strong>ChatRoom</strong>
            </a>
        </div>

        <!-- Username utente loggato -->
        <div class="navbar-end">
            <div class="navbar-item">
                <span><?php echo $username; ?></span>
            </div>
        </div>
    </nav>

    <!-- ================= CONTENUTO PRINCIPALE ================= -->
    <section class="section">
        <div class="container">

            <!-- Titolo e descrizione -->
            <div class="content has-text-centered mb-6">
                <h1 class="title is-2">Crea una Nuova Chat</h1>
                <p class="subtitle">Inserisci il nome della tua chat</p>
            </div>

            <!-- ================= NOTIFICA DI SUCCESSO ================= -->
            <?php if($aggiunta){ ?>
                <div class="notification is-success">
                    <button class="delete"></button> <p><strong>Successo!</strong> La chat è stata creata con successo.</p>
                </div>
            <?php }?>

            <!-- ================= FORM CREAZIONE CHAT ================= -->
            <div class="columns is-centered">
                <div class="column is-half">
                    <div class="box">
                        <form name="nuovaStanza" method="POST" action="">
                            <div class="field">
                                <label class="label">Nome della chat</label>
                                <div class="control">
                                    <input class="input" type="text" id="nomeStanza" name="nomeStanza" placeholder="Es. Amici, Lavoro, Gaming..."  required>
                                </div>
                            </div>

                            <!-- Pulsanti azione -->
                            <div class="field is-grouped is-grouped-centered">
                                <p class="control">
                                    <button class="button is-primary" type="submit">Crea Chat</button>
                                </p>
                                <p class="control">
                                    <a href="dashboard.php" class="button is-light">Annulla</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= SCRIPT CHIUSURA NOTIFICHE ================= -->
    <script>
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', () => {
                button.parentElement.remove();
            });
        });
    </script>
</body>
</html>

<?php
    // Chiusura controllo sessione
    }
?>
