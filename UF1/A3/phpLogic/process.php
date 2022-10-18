<?php 
    session_start();
    header("Location: formulari.php");
    

    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        
        if(in_array($_POST["paraula"] , $_SESSION["funcionsValides"])){
            $_SESSION["encertades"][] = $_POST["paraula"] ;
            $_SESSION["numeroEncertades"]++;
            header("Location: formulari.php?encertada=True");
        }else    
            header("Location: formulari.php?encertada=False");

    }

?>