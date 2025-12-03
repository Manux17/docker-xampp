<?php
    session_start(); 
    // Avvia una sessione PHP o riprende quella esistente.
    // Serve per poter accedere alle variabili di sessione come $_SESSION['utente'].

    $host = 'db'; 
    $dbname = 'SecretSanta'; 
    $user = 'user';
    $password = 'user';
    $port = 3306;
    // Variabili di configurazione per la connessione al database MySQL:
    // - host: indirizzo del server del database
    // - dbname: nome del database
    // - user: username per accedere al database
    // - password: password per l'utente
    // - port: porta di connessione (default MySQL = 3306)

    $connection = new mysqli($host, $user, $password, $dbname, $port);
    // Crea una nuova connessione al database usando l'estensione mysqli.
    // mysqli è orientato agli oggetti qui, quindi $connection è un oggetto che rappresenta la connessione.

    if ($connection->connect_error) {
        die("Errore di connessione: " . $connection->connect_error);
    }
    // Controlla se ci sono errori nella connessione. 
    // Se c'è un errore, interrompe l'esecuzione dello script con 'die()' e stampa il messaggio.

    $nome = $_SESSION['utente']; 
    // Recupera il nome dell'utente loggato dalla variabile di sessione.
    // Questo nome viene poi usato per assegnare o controllare il Secret Santa.

    //logica del programma

    // Controlla se l'utente ha già un abbinamento
    $query = "SELECT Abbinato FROM Abbinamenti WHERE Utente = '$nome'";
    $result = $connection->query($query);
    // Crea una query SQL per controllare se l'utente corrente ($nome) ha già un abbinamento nella tabella 'Abbinamenti'.
    // $connection->query($query) esegue la query e restituisce un oggetto mysqli_result.
    
    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        echo "Ciao $nome, il tuo Secret Santa è: " . $row['Abbinato'];
    } 
    // Se la query restituisce almeno una riga, significa che l'utente ha già un abbinamento.
    // fetch_assoc() prende la riga come array associativo (chiave = nome colonna).
    // Viene stampato a video il nome dell'utente abbinato.

    else 
    {
        // Prendi tutti gli utenti
        $query = "SELECT Nome FROM Utenti";
        $result = $connection->query($query);
        $utenti = [];
        while($row = $result->fetch_assoc())
        {
            $utenti[] = $row['Nome'];
        }
        // Qui si prendono tutti i nomi degli utenti dalla tabella 'Utenti'.
        // Ogni nome viene aggiunto all'array $utenti tramite fetch_assoc() in un ciclo while.

        // Rimuovi il nome dell'utente loggato
        $possibili = array_diff($utenti, [$nome]);
        // array_diff() crea un array con tutti gli utenti tranne il nome dell'utente corrente.
        // Serve a evitare che qualcuno si assegni a se stesso.

        // Rimuovi i nomi già assegnati ad altri
        $query = "SELECT Abbinato FROM Abbinamenti";
        $result = $connection->query($query);
        while($row = $result->fetch_assoc())
        {
            $possibili = array_diff($possibili, [$row['Abbinato']]);
        }
        // Prende tutti i nomi già assegnati come Secret Santa e li rimuove dall'array $possibili.
        // In questo modo non ci sono duplicati negli abbinamenti.

        // Scegli un nome a caso dai disponibili
        if(count($possibili) > 0)
        {
            $assegnato = $possibili[array_rand($possibili)];
            // array_rand($possibili) restituisce una chiave casuale dell'array $possibili
            // $assegnato è il nome scelto casualmente come Secret Santa per l'utente loggato.

            // Salva l'abbinamento nel database
            $query = "INSERT INTO Abbinamenti (Utente, Abbinato) VALUES ('$nome', '$assegnato')";
            $connection->query($query);
            // Inserisce il nuovo abbinamento nella tabella 'Abbinamenti' così da salvarlo permanentemente.

            echo "Ciao $nome, il tuo Secret Santa è: $assegnato";
            // Mostra all'utente chi è il suo Secret Santa.
        } 
        else 
        {
            echo "Spiacente, nessun utente disponibile.";
            // Caso limite: non ci sono utenti disponibili da abbinare (array vuoto).
        }
    }
?>
