<?php  
                // define variables to empty values  
                $nameErr = $cognErr = $emailErr = "";
                $name = $cogn = $email = "";

                //Input fields validation  
                if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                    
                    //name Validation  
                    if (empty($_POST["nome_utente"])) {  
                    $nameErr = "Inserisci il tuo nome";  
                    } else {  
                    $name = input_data($_POST["nome_utente"]);  
                        // check if name only contains letters and whitespace  
                        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {  
                            $nameErr = "Puoi inserire solo lettere e spazi caratteri speciali non sono ammessi";  
                        }  
                    } //close name validation 

                    //cognome Validation  
                    if (empty($_POST["cognome_utente"])) {  
                    $cognErr = "Inserisci il tuo cognome";  
                    } else {  
                    $cogn = input_data($_POST["cognome_utente"]);  
                        // check if name only contains letters and whitespace  
                        if (!preg_match("/^[a-zA-Z ]*$/",$cogn)) {  
                            $cognErr = "Puoi inserire solo lettere e spazi caratteri speciali non sono ammessi";  
                        }  
                    } //close cognome Validation 
                    
                    //Email Validation   
                    if (empty($_POST["email"])) {  
                        $emailErr = "Inserisci la tua mail";  
                    } else {  
                        $email = input_data($_POST["email"]);  
                        // check that the e-mail address is well-formed  
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                            $emailErr = "Inserisci la mail in un formato valido Es: esempio@mail.com";  
                        }  
                    }  //close Email Validation

                } //close frist if
                function input_data($data) {  
                    $data = trim($data);  
                    $data = stripslashes($data);  
                    $data = htmlspecialchars($data);  
                    return $data;  
                  }  
            ?>