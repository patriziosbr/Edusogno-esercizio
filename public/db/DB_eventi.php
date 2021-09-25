<!-- ricezione data da form -->
<?php
    // connection
    include 'DB_connect.php';

    $eventName = $_REQUEST['nome_evento'];
    $description = $_REQUEST['desc_evento'];
    $dateEvent = $_REQUEST['data_evento'];
    $hourEvent = $_REQUEST['ora_evento'];

    $sql = 
    "INSERT INTO eventi (nome_evento, desc_evento, data_evento, ora_evento)
    VALUES( '$eventName', '$description', '$dateEvent', '$hourEvent')";

    $conn->query($sql);

    $conn->close();

    // header("Location: ../public/index.php");

    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");


