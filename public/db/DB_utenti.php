<!-- ricezione data da form -->
<?php
    // connection
    include_once 'DB_connect.php';

        $firstname = $_REQUEST['nome_utente'];
        $lastname = $_REQUEST['cognome_utente'];
        $email = $_REQUEST['email'];

        $sql = "INSERT INTO utenti (nome_utente, cognome_utente, email)
        VALUES( '$firstname', '$lastname', '$email')";

        $conn->query($sql);
        
        $conn->close();
    
        
        // header("Location: ../public/index.php");
        
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");

    
        // if( $query_run ) {
        //     $_SESSION['status'] = "Utente registrato correttamente";
        //     header("Location: ../index.php");
        //     exit(0);
        // } else if ( $firstname === "" )  {
        //     $_SESSION['status'] = "Contolla i campi inseriti";
        //     header("Location: ../index.php");
        //     exit(0);

        // }



    







