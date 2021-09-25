
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">

        <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.7.3/dist/css/uikit.min.css" />
        <!-- /UIkit CSS -->

        <!-- UIkit JS -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.3/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.3/dist/js/uikit-icons.min.js"></script>
        <!-- /UIkit JS -->

        <!-- cdn jquery  -->
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <!-- cdn jquery  -->

        <!-- jquery.validate (minfied) -->
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
        <!-- /jquery.validate (minfied) -->

        <!-- fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- fontawesome -->


        <title>Edusogno Test</title>
    </head>

    <body>
        <header>
            <section>
                <div id="logo-box">
                    <a id="logo-white" href="#">
                        <img src="https://edusogno.com/wp-content/uploads/edusogno/logo/logo-v4-2.svg" alt="logo-edusogno">
                    </a>
                    <!-- <a  id="logo-black" href="#">
                        <img id="logo-black" src="https://edusogno.com/wp-content/uploads/edusogno/logo/logo-v2.svg" alt="logo-edusogno">
                    </a> -->
                </div>
            </section>
        </header>

        <main class="uk-flex">

        <?php 
            include_once  'php/user_validate.php';
        ;?>
            
            <!-- from utente -->
            <section class="uk-container">
                <h1 class="uk-margin-top uk-margin-bottom">
                    Info utente
                </h1>
                <small class="uk-display-block uk-margin-bottom" >(*) i campi contrassegnati con l’asterisco sono obbligatori</small>
            <form id="formUtenti" class="uk-form-stacked" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="nome_utente">Nome: *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="nome_utente" type="text" placeholder="Mi chiamo..." name="nome_utente" >
                            <small class="redError"><?php echo $nameErr; ?> </small>  
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="cognome_utente">Cognome: *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="cognome_utente" type="text" placeholder="Il mio cognome è..." name="cognome_utente" >
                                <small class="redError"><?php echo $cognErr; ?> </small>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="email">Email: *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="email" type="text" placeholder="La mia e-mail..." name="email" >
                            <small class="redError"><?php echo $emailErr; ?> </small> 
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-form-custom">
                            <button class="uk-button uk-button-primary" type="submit" name="submit" >
                                <i class="fas fa-user uk-margin-right"></i>    
                                Salva
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <!-- from utente -->

            <!-- validazione utenti ok store to DB -->
            <?php  
                if(isset($_POST['submit'])) {  
                    if($nameErr == "" && $cognErr == "" && $emailErr == "") {  
                        require_once  "db/DB_utenti.php";
                    }
                }  
            ?>  <!-- /validazione utenti ok store to DB -->


    
            <!-- from evento -->
            <section class="uk-container">
                <div class="titleContainer uk-flex uk-flex-between uk-flex-middle">
                    <div class="titleWarning">
                        <h1 class="uk-margin-top uk-margin-bottom">Info Evento</h1>
                        <small class="uk-display-block uk-margin-bottom" >(*) i campi contrassegnati con l’asterisco sono obbligatori</small>
                    </div>
                    <div class="shareBtn">
                        <form method="POST" action="./api/quickstart.php">
                            <div class="uk-form-custom">
                                <button class="uk-button uk-button-default" type="submit">
                                <i class="fas fa-share-alt uk-margin-right"></i>
                                Condividi</button>
                            </div>
                        </form>
                    </div>
                </div>   
                <form class="uk-form-stacked" method="POST" action="./db/DB_eventi.php">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="nome_evento">Nome evento: *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="nome_evento" type="text" placeholder="Scegli un titolo memorabile..." name="nome_evento" required >
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="desc_evento">Descrizione: *</label>
                        <div class="uk-form-controls">
                            <textarea class="uk-textarea" id="desc_evento" type="text" placeholder="Descrivi il tuo evento..." name="desc_evento" required></textarea>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="data_evento">Giorno:</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="data_evento" type="date" name="data_evento" required>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="ora_evento">Ora:</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="ora_evento" type="time" name="ora_evento" required>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-form-custom">
                            <button class="uk-button uk-button-primary" type="submit" >
                                <i class="fas fa-pen uk-margin-right"></i>
                                Crea evento
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <!-- /from evento -->

            

        </main>

        <!-- script -->
        <script src="js/script.js"></script>
    </body>

</html>
