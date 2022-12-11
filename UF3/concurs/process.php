<?php 
    session_start();

    require_once "helper.php";
    // comprovar fase

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET' : header("Location: http://localhost/entornservidor/concurs/index.php");
        case 'POST' :
            if($_SESSION["Fase"] != "inactiva"){
                treballarPost();
            }else{
                header("Location: http://localhost/entornservidor/concurs/index.php");
            };
    }
    
    function treballarPost(){
        
        $fase = $_SESSION["Fase"]; // fase potser a session?

        // comprovar si el nou vot es diferent al anterior
        if($_SESSION['votActual'] != 'nou' && $_SESSION["votActual"] != $_POST["seleccio"]){
            desvotar($_SESSION["votActual"] , $fase);
            votar($_SESSION["usuari"] , $_POST["seleccio"] , $fase);
        }elseif( $_SESSION["votActual"] == "nou")
            votNou($_SESSION["usuari"] , $_POST["seleccio"] , $fase);
        
            
        header("Location: http://localhost/entornservidor/concurs/index.php");

    }


















?>

