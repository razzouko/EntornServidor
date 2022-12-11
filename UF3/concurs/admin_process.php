<?php 

    require_once "helper.php";
    

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET' : header("Location: login/login.php");
        case 'POST' : treballarPost();
    }



    function treballarPost(){


        if(isset($_POST["nouUser"])){

            $usuari = obtenirUsuari($_POST["nom"], isset($_POST["password"]));
                if(is_bool($usuari)) {
                    afegirUsuari($_POST["nom"], isset($_POST["password"]) , $_POST["tipus"]);
                    header("Location: admin.php");
                }else 
                    header("Location: admin.php?errorUsuari= Usuari ja existeix");
     
        }

        if(isset($_POST["novaData"])){

                $modificat = modificarData($_POST["dataInici"] , $_POST["dataFi"] , $_POST["numeroFase"]);

                if($modificat){
                    header("Location: admin.php");
                }else   
                    header("Location: admin.php?errorData= Dates incorrectes");
                
        }

        if (isset($_POST["editarGos"])) {

            modificarGos($_POST["nomAnterior"] , $_POST["nom"], $_POST["amo"] , $_POST["imatge"] , $_POST["raça"] );
            header("Location: admin.php");
        }

        if(isset($_POST["borrarVots"])){
            eliminarVotsFase($_POST["numeroFase"]);
            header("Location: admin.php");
        }

        if(isset($_POST["borrarTotsElsVots"])){
            eliminarTotsElsVots();
            header("Location: admin.php");
        }
    }


?>