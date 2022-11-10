<?php
require_once 'utils.php';
$status = "error"; // per defecte error genèric
$user_email = null;
$user_data = null;
session_start();

// Resposta al formulari de SIGNIN
if (isset($_POST["method"]) && $_POST["method"] == "signin"){

    // Ens assegurem que hi sigui tot
    if(!isset($_POST["email"]) && !isset($_POST["password"])) die("Incorrect form");

    $user_email = $_POST["email"];
    $data = getAllUsr();

    if(!array_key_exists($user_email, $data)){ // Comprova si existeix l'email
        $status = "signin_email_error";
    }
    elseif ($data[$user_email]["password"] != hash("md5" , $_POST["password"])) { // Comprova la contrasenya
        $status = "signin_password_error";
    }
    else { // Tot correcte
        $status = "signin_success";
        $user_data = $data[$user_email];
    }
}

// Resposta al formulari de SIGNUP
elseif (isset($_POST["method"]) && $_POST["method"] == "signup"){

    // Ens assegurem que hi sigui tot
    if( !isset($_POST["email"]) && !isset($_POST["password"]) && !isset($_POST["name"])) die("Incorrect form");

    $user_email = $_POST["email"];
    $data = getAllUsr();

    if(!str_contains($user_email, "@")){  // Comprova que sigui un email
        $status = "signin_email_error";
    }
    elseif (!array_key_exists($user_email, $data)){ // Si l'email no existeix
        $nouUser = [$user_email, $_POST["password"],$_POST["name"]];
        if(insertUsr($nouUser, TAULA_USERS)){
            $status = "signup_success";
            $user_data = ["email" => $user_email, "password" => $_POST["password"], "name" => $_POST["name"]];
        }
    }
    else // L'email ja existeix
        $status = "signup_exist_error";
}

// Resposta al formulari de tancar la sessió
elseif (isset($_POST["method"]) && $_POST["method"] == "logoff") {
    $status = "logoff";
    $user_email = $_SESSION["user"]["email"] ?? "none";
    session_destroy();
}

// Guarda l'estat a connexions
//$cons = getAll(TAULA_CONNX);

$cons= [$_SERVER["REMOTE_ADDR"],$user_email,date("Y-m-d H:i:s"),$status];
insertConn($cons, TAULA_CONNX);

// Redireciona PGR a on toqui
if(str_contains($status, "success")) {
    header("Location: hola.php"); // per defecte 302
    $user_data["login_time_stamp"] = time();
    $_SESSION["user"] = $user_data;
}
else {
    header("Location: index.php?error=$status", true, 303);
}
