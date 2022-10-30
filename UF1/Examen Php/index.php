<?php

ini_set('session.gc_maxlifetime', 60);
ini_set('session.cookie_lifetime', 60);
session_start();
if(isset($_SESSION["correuUsuari"]))
    header("Location: hola.php");


?>




<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Accés</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">

</head>
<body>


    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="process.php" method="POST">
                <h1>Registra't</h1>
                <span>crea un compte d'usuari</span>
                <input type="hidden" name="method" value="signup"/>
                <input type="text" placeholder="Nom" name="nomUsuari" />
                <input type="email" placeholder="Correu electronic" name="correuUsuari" />
                <input type="password" placeholder="Contrasenya" name="contrasenyaUsuari" />
                <button>Registrat</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="process.php" method="POST">
                <h1>Inicia la sessió</h1>
                <span>introdueix les teves credencials</span>
                <input type="hidden" name="method" value="signin"/>
                <input type="email" placeholder="Correu electronic" name ="correuUsuari"/>
                <input type="password" placeholder="Contrasenya" name ="contrasenyaUsuari" />
                <button>Inicia la sessió</button>
                <span id="msgError" <?php echo (isset($_GET["errorInici"]))? "": "hidden" ?>><label><?php echo (isset($_GET["errorInici"]))?  $_GET["errorInici"]: "" ?> </label></span>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Ja tens un compte?</h1>
                    <p>Introdueix les teves dades per connectar-nos de nou</p>
                    <button class="ghost" id="signIn">Inicia la sessió</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Primera vegada per aquí?</h1>
                    <p>Introdueix les teves dades i crea un nou compte d'usuari</p>
                    <button class="ghost" id="signUp">Registra't</button>
                <span id="msgError" <?php echo (isset($_GET["errorRegistre"]))? "": "hidden" ?>><label><?php echo (isset($_GET["errorRegistre"]))?  $_GET["errorRegistre"]: "" ?> </label></span>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');


        signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    

</script>
</html>