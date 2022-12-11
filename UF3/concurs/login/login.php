<?php 
    
    session_start();

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
        <form action="login_process.php" method="post">
            <h1>Registra't</h1>
            <span>crea un compte d'usuari</span>
            <input type="hidden" name="method" value="signup"/>
            <input type="text" name="nom" placeholder="Nom usuari"/>
            <input type="password" name="password" placeholder="Contrasenya"/>
            <input type="text" name="tipus" value="basic" hidden/>
            <button>Registra't</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="login_process.php" method="post">
            <h1>Inicia la sessió</h1>
            <span>introdueix les teves credencials</span>
            <input type="hidden" name="method" value="signin"/>
            <input type="text" name="nom" placeholder="Nom usuari"/>
            <input type="password" name="password" placeholder="Contrasenya"/>
            <button>Inicia la sessió</button>
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
            </div>
        </div>
    </div>
</div>
<div class="container-notifications" style="background-color: #eebf65 ; border-radius:5px;">
        <p style="color:red;"><?php echo (isset($_GET["error"]))? $_GET["error"] : ""; ?></p>
</div>
</body>
<script>
    function clear_gets() {
        window.history.replaceState(null, null, window.location.pathname)
    }

    function amagaError() {
        if (document.getElementById("message"))
            document.getElementById("message").style.opacity = "0"
        clear_gets()
    }

    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    window.onload = () => {
        setTimeout(amagaError, 2000)
    }
</script>
</html>