<?php
    session_start();

    if ($_SESSION['auth'])
    {
        //logica del progetto
        echo "ciaoSanta";
    }
