<?php
    // Variabili per la gestione degli errori
    $errore = null;
    $tipoErrore = null;

    // Controllo se il form è stato inviato con username e password
    if ($_POST && isset($_POST['username']) && isset($_POST['password'])) 
    {
        // Recupero dati dal form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connessione al database
        require_once("db.php");

        // Query per recuperare la password hashata dell'utente
        $stmt = $connection->prepare("SELECT password FROM Utenti WHERE user = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se l'utente esiste
        if ($result->num_rows === 1) 
        {
            // Recupero hash della password dal database
            $row = $result->fetch_assoc();
            $hashSalvato = $row['password'];

            // Verifica della password inserita con quella salvata
            if (password_verify($password, $hashSalvato)) 
            {
                // Login corretto: avvio sessione e salvataggio username
                session_start();
                $_SESSION['username'] = $username;

                // Reindirizzamento alla dashboard
                header("Location: dashboard.php");
            } 
            else 
            {
                // Password errata
                $errore = "Password errata";
                $tipoErrore = "danger";
            }
        } 
        else 
        {
            // Utente non trovato nel database
            $errore = "Utente non trovato";
            $tipoErrore = "warning";
        }

        // Chiusura risorse database
        $stmt->close();
        $connection->close();
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Framework CSS Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">

    <!-- Titolo pagina -->
    <title>Login - ChatRoom</title>
</head>
<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar is-dark" role="navigation">
        <div class="navbar-brand">
            <a class="navbar-item">
                <strong>ChatRoom</strong>
            </a>
        </div>
    </nav>

    <!-- ================= CONTENUTO PRINCIPALE ================= -->
    <section class="section is-fullheight">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5-tablet is-4-desktop">

                    <!-- Titolo pagina -->
                    <div class="content has-text-centered mb-6">
                        <h1 class="title is-2">Login</h1> <p class="subtitle">Accedi al tuo account</p>
                    </div>

                    <!-- ================= MESSAGGIO DI ERRORE ================= -->
                    <?php if($errore) { ?>
                        <div class="notification is-<?php echo $tipoErrore; ?>">
                            <button class="delete"></button> <p><?php echo $errore; ?></p>
                        </div>
                    <?php } ?>

                    <!-- ================= FORM DI LOGIN ================= -->
                    <div class="box">
                        <form method="POST" action="">
                            <div class="field">
                                <label class="label">Username</label>
                                <div class="control">
                                    <input class="input" type="text" name="username" placeholder="Inserisci il tuo username"required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Password</label>
                                <div class="control">
                                    <input class="input" type="password" name="password" placeholder="Inserisci la tua password" required>
                                </div>
                            </div>

                            <div class="field is-grouped is-grouped-centered">
                                <p class="control">
                                    <button class="button is-primary is-fullwidth" type="submit">Accedi</button>
                                </p>
                            </div>
                        </form>
                    </div>

                    <!-- ================= LINK REGISTRAZIONE ================= -->
                    <div class="content has-text-centered">
                        <p>
                            Non hai un account?
                            <a href="registrazione.php"><strong>Registrati</strong></a>
                        </p>
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
