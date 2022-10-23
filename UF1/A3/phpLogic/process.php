<?php 
    session_start();

    if(isset($_POST["barrejar"])){
        shuffle($_SESSION["lletres"]);
        header("Location: formulari.php");
        }else if($_SERVER["REQUEST_METHOD"] == 'POST'){
            if(!str_contains($_POST["paraula"] , $_SESSION["lletraMig"])){
                $_SESSION["missatgeError"] = "No hi ha la lletra del mig(" . $_POST["paraula"] . ")";
                header("Location: formulari.php?encertada=False");
            }else if(in_array($_POST["paraula"] , $_SESSION["encertades"])){
                $_SESSION["missatgeError"] = "Ja hi ha la resposta (" . $_POST["paraula"] . ")";
                header("Location: formulari.php?encertada=False");
            }else if(in_array($_POST["paraula"] , $_SESSION["funcionsValides"])){
                $_SESSION["encertades"][] = $_POST["paraula"] ;
                $_SESSION["numeroEncertades"]++;
                header("Location: formulari.php?encertada=True");
            }else{
                $_SESSION["missatgeError"] = "La paraula no es una funcio PHP (" . $_POST["paraula"] . ")";
                header("Location: formulari.php?encertada=False");
            }
    }

?>