<?php
    session_start();
    include "../pdo/pdoaccess.php";


    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET' : header("Location: login.php", true , 302);
        case 'POST': ($_POST["method"] == "signin") ? treballarSignIn() : treballarSignUp();
    }

    function treballarSignIn(){

        if(obtenirUsuari($_POST["nom"], $_POST["password"])){
            $_SESSION["usuari"] = $_POST["nom"];
            $_SESSION["login_time_stamp"] = time();
            if($_POST["nom"] == "admin" && $_POST["password"] == "admin" )
                header("Location: http://localhost/entornservidor/concurs/admin.php");
            else    
                header("Location: http://localhost/entornservidor/concurs/index.php");
        }else 
            header("Location: http://localhost/entornservidor/concurs/login/login.php?error=Dades Incorrectes");


    }

    function treballarSignUp(){
            if(!obtenirUsuari($_POST["nom"], $_POST["password"])){
                afegirUsuari($_POST["nom"], $_POST["password"]);
                $_SESSION["usuari"] = $_POST["nom"];
                $_SESSION["login_time_stamp"] = time();
                header("Location: http://localhost/entornservidor/concurs/index.php");
            }
    }














?>