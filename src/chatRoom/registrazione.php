<?php
    // Variabili per la gestione dei messaggi all'utente
    $messaggio = null;
    $tipoMessaggio = null;

    // Flag per decidere se mostrare o meno il form
    $vedereForm = true;

    // Controllo invio del form di registrazione
    if ($_POST && isset($_POST['username']) && isset($_POST['password'])) 
    {
        // Recupero dati dal form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connessione al database
        require_once("db.php");

        // Controllo se l'utente esiste già
        $stmt = $connection->prepare("SELECT user FROM Utenti WHERE user = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se l'username è già presente nel database
        if ($result->num_rows > 0) 
        {
            $messaggio = "Utente già esistente!";
            $tipoMessaggio = "warning";
        } 
        else 
        {
            // Hash della password prima del salvataggio
            $passwordHashata = password_hash($password, PASSWORD_DEFAULT);

            // Inserimento del nuovo utente nel database
            $stmt = $connection->prepare("INSERT INTO Utenti (user, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $passwordHashata);

            // Controllo esito inserimento
            if ($stmt->execute()) 
            {
                $messaggio = "Registrazione completata! Accedi al tuo account.";
                $tipoMessaggio = "success";
                $vedereForm = false;
            } 
            else 
            {
                $messaggio = "Errore durante la registrazione.";
                $tipoMessaggio = "danger";
            }
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
    <title>Registrazione - ChatRoom</title>
</head>
<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar is-dark" role="navigation">
        <div class="navbar-brand">
            <a class="navbar-item"> <strong>ChatRoom</strong> </a>
        </div>
    </nav>

    <!-- ================= CONTENUTO PRINCIPALE ================= -->
    <section class="section is-fullheight">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-5-tablet is-4-desktop">

                    <!-- Titolo pagina -->
                    <div class="content has-text-centered mb-6">
                        <h1 class="title is-2">Registrazione</h1>
                        <p class="subtitle">Crea il tuo account</p>
                    </div>

                    <!-- ================= MESSAGGIO DI STATO ================= -->
                    <?php if($messaggio) { ?>
                        <div class="notification is-<?php echo $tipoMessaggio; ?>">
                            <button class="delete"></button> <p><?php echo $messaggio; ?></p>
                        </div>
                    <?php } ?>

                    <!-- ================= FORM REGISTRAZIONE ================= -->
                    <?php if($vedereForm) { ?>
                        <div class="box">
                            <form method="POST" action="">
                                <div class="field">
                                    <label class="label">Username</label>
                                    <div class="control">
                                        <input class="input" type="text" name="username" placeholder="Scegli il tuo username" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Password</label>
                                    <div class="control">
                                        <input class="input" type="password" name="password" placeholder="Scegli una password sicura" required>
                                    </div>
                                </div>

                                <div class="field is-grouped is-grouped-centered">
                                    <p class="control">
                                        <button class="button is-primary is-fullwidth" type="submit">Registrati</button>
                                    </p>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>

                        <!-- ================= STATO DI SUCCESSO ================= -->
                        <div class="box has-text-centered">
                            <p class="mb-4">
                                <span class="icon is-large">
                                    <i class="fas fa-check-circle" style="font-size: 3rem; color: #48c774;"></i>
                                </span>
                            </p>
                            <a href="login.php" class="button is-primary is-fullwidth">Vai al Login</a>
                        </div>
                    <?php } ?>

                    <!-- ================= LINK LOGIN ================= -->
                    <div class="content has-text-centered">
                        <p>Hai già un account? <a href="login.php"><strong>Accedi</strong></a></p>
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
