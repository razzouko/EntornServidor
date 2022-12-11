<?php
    session_start();
    include "../pdo/pdoaccess.php";


    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET' : header("Location: login.php", true , 302);
        case 'POST': ($_POST["method"] == "signin") ? treballarSignIn() : treballarSignUp();
    }

    function treballarSignIn(){

        $usuari = obtenirUsuari($_POST["nom"], $_POST["password"]);

        if(!is_bool($usuari)){
            $_SESSION["usuari"] = $_POST["nom"];
            $_SESSION["login_time_stamp"] = time();
            if($usuari["tipus"] == "admin")
                header("Location: http://localhost/MP07/UF3/concurs/admin.php");
            else    
                header("Location: http://localhost/MP07/UF3/concurs/index.php");
        }else 
            header("Location: http://localhost/MP07/UF3/concurs/login/login.php?error=Dades Incorrectes");


    }

    function treballarSignUp(){

            $usuari = !obtenirUsuari($_POST["nom"], $_POST["password"]);

            if(is_bool($usuari)){
                afegirUsuari($_POST["nom"], $_POST["password"] , $_POST["tipus"]);
                $_SESSION["usuari"] = $_POST["nom"];
                $_SESSION["login_time_stamp"] = time();
                header("Location: http://localhost/MP07/UF3/concurs/index.php");
            }else
                header("Location: http://localhost/MP07/UF3/concurs/login/login.php?error=Usuari ja existeix");

    }














?>