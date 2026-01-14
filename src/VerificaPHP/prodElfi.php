<?php
    
    session_start();

    if ($_SESSION['auth'] && isset($_SESSION['auth']))
    { 
        $host = 'db'; 
        $dbname = 'babbonatale'; 
        $user = 'user';
        $password = 'user';
        $port = 3306;
        
        $conn = new mysqli($host, $user, $password, $dbname, $port);
        
        if ($conn->connect_error) {
            die("Errore di connessione: " . $conn->connect_error);
        }   
        
        //stampo tutta la tabella
        //la query raggruppa per nomeGiocattolo e conta il numero di righe corrispondenti
        $query = "SELECT nomeGiocattolo, COUNT(*) AS numeroUnità FROM giocattoli GROUP BY nomeGiocattolo";
        
        //esegui query
        $result = $conn->query($query);

        //Questo codice controlla se la query ha restituito dei risultati. Se ci sono dati, tramite un ciclo while legge una 
        // riga alla volta dalla tabella usando fetch_assoc(). Per ogni riga stampa il nome dell’elfo seguito dal nome del giocattolo, 
        // andando a capo dopo ogni risultato. In questo modo vengono visualizzati tutti i dati presenti nella tabella.


        //stampo la tabella
        if($result->num_rows > 0)
        {

            //fetch_assoc() serve a leggere una riga del risultato della query e a salvarla in un array associativo.
            //In pratica:
            //prende una riga alla volta dal risultato
            // restituisce un array in cui:
                // le chiavi sono i nomi delle colonne del database
                // i valori sono i dati di quella riga
            while ($row = $result->fetch_assoc()) 
            {
                echo ($row['nomeGiocattolo']) . ":";
                echo ($row['numeroUnità']) . '<br>' ;
            }
        }

        echo '<br>';
        echo "Vuoi ritornare alla home?";
        echo '<a href=dashboard.php> HOME </a>';


    }