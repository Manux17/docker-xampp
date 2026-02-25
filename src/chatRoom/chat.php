<?php
    // Avvio della sessione
    session_start();

    // Controllo: utente loggato e parametro stanza presente in GET
    if(isset($_SESSION['username']) && $_GET && isset($_GET['stanza']))
    {
        // Connessione al database
        require_once("db.php");

        // Nome della stanza corrente
        $stanza = $_GET['stanza'];


        /* =====================================================
           GESTIONE INVIO MESSAGGIO (REQUEST POST)
           ===================================================== */
        if($_POST && isset($_POST['messaggio']))
        {
            // Testo del messaggio e username dell'utente loggato
            $messaggio = $_POST['messaggio'];
            $username = $_SESSION['username'];
            
            // Inserimento solo se il messaggio non è vuoto
            if(!empty($messaggio))
            {
                $stmt = $connection->prepare("INSERT INTO Messaggi (nomeStanza, user, testo, data) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("sss", $stanza, $username, $messaggio);
                $stmt->execute();
            }
        }

        /* =====================================================
           GESTIONE AGGIUNTA NUOVO UTENTE ALLA STANZA
           ===================================================== */
        $utenteAggiunto = false;
        $utenteEsiste = false;
        $utenteGiaPartecipa = false;

        // Controllo se è stato inviato il nome di un nuovo utente
        if($_POST && isset($_POST['nomeUtente']))
        {
            $utente = $_POST['nomeUtente'];

            // Verifica esistenza utente nel database
            $stmt = $connection->prepare("SELECT COUNT(*) AS numeroUtenti FROM Utenti WHERE user=?");
            $stmt->bind_param("s", $utente);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_assoc();

            if($result['numeroUtenti'] == 1)
            {
                $utenteEsiste = true;

                // Controllo se l'utente partecipa già alla stanza
                $stmt = $connection->prepare("SELECT COUNT(*) AS partecipa FROM Partecipa WHERE user=? and nome=?");
                $stmt->bind_param("ss", $utente, $stanza);
                $stmt->execute();
                $result = $stmt->get_result();
                $result = $result->fetch_assoc();

                // Se non partecipa, lo aggiungo
                if($result['partecipa'] == 0)
                {
                    $stmt = $connection->prepare("INSERT INTO Partecipa(nome, user) VALUES (?, ?)");
                    $stmt->bind_param("ss", $stanza, $utente);
                    $stmt->execute();

                    if($stmt->affected_rows > 0)
                    {
                        $utenteAggiunto = true;
                    }
                }
                else
                {
                    // L'utente è già presente nella stanza
                    $utenteGiaPartecipa = true;
                }
            }
        }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Framework CSS Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">

    <!-- Titolo dinamico con nome stanza -->
    <title>Chat - <?php echo $stanza; ?></title>
</head>
<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar is-dark" role="navigation">
        <div class="navbar-brand">
            <a class="navbar-item">
                <strong>ChatRoom</strong>
            </a>
        </div>

        <!-- Username dell'utente loggato -->
        <div class="navbar-end">
            <div class="navbar-item">
                <span><?php echo $_SESSION['username']; ?></span>
            </div>
        </div>
    </nav>

    <!-- ================= CONTENUTO PRINCIPALE ================= -->
    <section class="section">
        <div class="container">

            <!-- Titolo stanza -->
            <h1 class="title is-4"><?php echo $stanza; ?></h1>

            <!-- ================= MESSAGGI ================= -->
            <div class="box mb-5">
                <?php
                    // Recupero messaggi della stanza ordinati per data
                    $stmt = $connection->prepare("SELECT * FROM Messaggi WHERE nomeStanza=? ORDER BY data");
                    $stmt->bind_param("s", $stanza); 
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if($result->num_rows > 0)
                    {
                        // Stampa di ogni messaggio
                        while($row = $result->fetch_assoc())
                        {
                            echo "<div class='mb-3'>";
                            echo "  <strong>" . $row['user'] . "</strong> ";
                            echo "  <small class='has-text-grey-light'>" . $row['data'] . "</small>";
                            echo "  <p>" . $row['testo'] . "</p>";
                            echo "</div>";
                            echo "<hr>";
                        }
                    }
                    else
                    {
                        // Nessun messaggio presente
                        echo "<p class='has-text-grey'>Nessun messaggio trovato</p>";
                    }
                ?>
            </div>

            <!-- ================= FORM INVIO MESSAGGIO ================= -->
            <form name="invioMess" method="POST" action="" class="mb-5">
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <input class="input" type="text" id="messaggio" name="messaggio" placeholder="Scrivi un messaggio...">
                    </div>
                    <div class="control">
                        <button class="button is-info" type="submit">Invia</button>
                    </div>
                </div>
            </form>

            <!-- ================= NOTIFICHE ================= -->
            <?php if($utenteAggiunto) { ?>
                <div class="notification is-success">
                    <button class="delete"></button>
                    <p>Utente inserito correttamente.</p>
                </div>

            <?php } elseif($utenteGiaPartecipa) { ?>
                <div class="notification is-warning">
                    <button class="delete"></button>
                    <p>Utente partecipa già alla stanza.</p>
                </div>

            <?php } elseif (!$utenteEsiste) { ?>
                <div class="notification is-danger">
                    <button class="delete"></button>
                    <p>Utente non esistente.</p>
                </div>
            <?php } ?>

            <!-- ================= FORM ADMIN (SOLO CREATORE) ================= -->
            <?php
                // Recupero creatore della stanza
                $stmt = $connection->prepare("SELECT creatore FROM Stanze WHERE nome=?");
                $stmt->bind_param("s", $stanza);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if($result->num_rows > 0)
                {
                    $result = $result->fetch_assoc();

                    // Controllo se l'utente loggato è il creatore
                    if($_SESSION['username'] === $result['creatore'])
                    {
                        echo "<div class='box mb-5'>";
                        echo "  <h3 class='title is-6'>Aggiungi Utente</h3>";
                        echo "  <form name='nuovoUtente' method='POST' action=''>";
                        echo "    <div class='field has-addons'>";
                        echo "      <div class='control is-expanded'>";
                        echo "        <input class='input' type='text' id='nomeUtente' name='nomeUtente' placeholder='Username utente...'>";
                        echo "      </div>";
                        echo "      <div class='control'>";
                        echo "        <button class='button is-primary' type='submit'>Aggiungi</button>";
                        echo "      </div>";
                        echo "    </div>";
                        echo "  </form>";
                        echo "</div>";
                    }
                }
            ?>

            <!-- ================= LINK DASHBOARD ================= -->
            <a href="dashboard.php" class="button is-light">← Torna alla Dashboard</a>
        </div>
    </section>

    <!-- ================= SCRIPT PER CHIUDERE NOTIFICHE ================= -->
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
    // Chiusura controllo sessione e stanza
    }
?>
