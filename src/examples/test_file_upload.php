<?php  
    echo 'richiesta POST';
    var_dump($_POST);
    echo "<br>";

    if($_POST && isset($_POST['submit']) && isset($_FILES))
    {

        var_dump($_FILES);
        echo "<br>";

        if(isset($_FILES['file1']))
        {
            echo "FILE1";
            var_dump($_FILES['file1']);
            echo "<br>";
    
            $percorso = $_FILES['file1']['tmp_name'];
    
            //controlla se in quel percorso esiste un file
            if(file_exists($percorso))
            {
                //file_get_contents restituisce il contenuto del file, se carichiamo un file di testo si visualizza il contnuto giusto
                //in caso di altri file prova a convertire
                echo 'Ecco il contenuto del file 1';
                $contenuto = file_get_contents($_FILES['file1']['tmp_name']);
                var_dump($contenuto);
                echo "<br>";
    
                $json = json_decode($contenuto, true);
                var_dump($json);
                echo ($json['nome']);
    
    
                //ciclo per stampare il json
                foreach($json as $chiave => $valore)
                {
                    var_dump($chiave);
                    var_dump($valore);
    
                    //inserisco la tupla appena letta dentro al database
                }
            }
            else
            {
                echo 'File2 non trovato';
            }
        }
        if(isset($_FILES['file2']))
        {
            echo 'FILE2';
            var_dump($_FILES['file2']);
            echo "<br>";

            $percorso = $_FILES['file2']['tmp_name'];

            if(file_exists($percorso))
            {
                //salvare il file nel db con campo blob
                //spostare il file dalla cartella temporanea a una persistente

                $nome = $_FILES['file2']['name'];

                move_uploaded_file($percorso, "./$nome");
                echo 'File2 salvato';
            }
            else
            {
                echo 'File2 non trovato';
            }
        }

        

        
        
    }
?>
<!DOCTYPE html>
<html>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
        Select image to upload:
            <input type="file" name="file1" id="fileToUpload">
            <input type="file" name="file2" id="ad">
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </body>
</html>