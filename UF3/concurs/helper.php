<?php 

    require_once("pdo/pdoaccess.php");


    function votFaseActual($usuari , $fase){

        $dadesGos = obtenirVotUsuari($usuari , $fase);
        if(count($dadesGos) < 1)
            return false;
        else    
            return $dadesGos[0]["gos"];

    }

    function votar($usuari , $gos , $fase){

        
        // sumar vots a gos
        $vots = obtenirVotsGos($fase , $gos);
        actualitzarVotsGos($fase , $gos , $vots+1);

        // canviar vot d'un usuari dins una fase 
        canviarVotUsuari($usuari , $fase , $gos);

    }

    function desvotar($gos , $fase){
        $vots = obtenirVotsGos($fase , $gos);
        actualitzarVotsGos($fase , $gos , $vots-1);
    }


    function votNou($usuari , $gos , $fase){

        // registrar nou vot de l'usuari
        nouVotUsuari($usuari, $fase , $gos);

        // sumar vot al gos

        $vots = obtenirVotsGos($fase , $gos);
        actualitzarVotsGos($fase , $gos , $vots+1);

    }

    function obtenirFaseActual(){

        $dataAvui = "2023-01-13"  ;//date("y-m-d");

        $fase = obtenirFasePerData($dataAvui);

        if(is_string($fase))
            return $fase;
        else
            return false;

    }

    function obtenirGossosDeFase($nom){

        $gos_vots = obtenirGossosXFase($nom);
        $vots_totals = 0;
        foreach($gos_vots as $gos => $vots){
            $vots_totals += $vots;
        }
        
        foreach($gos_vots as $gos => $vots){
                if($vots > 0)
                    $gos_vots[$gos]= intval(($vots * 100) / $vots_totals);
                else
                    $gos_vots[$gos] = 0;
        }

        return $gos_vots;
    }

    function obtenirGossos(){
        return obtenirGossosConcurs();
    }

    function modificarData($dataInici , $dataFi , $numeroFase){

        $dates = obtenirDatesLimit($numeroFase);

        if(strtotime($dataInici) >= strtotime($dates["iniciMaxim"]) && strtotime($dataInici) < strtotime($dates["finalMaxim"]) ){
            if(strtotime($dataFi) > strtotime($dates["iniciMaxim"]) && strtotime($dataFi) <= strtotime($dates["finalMaxim"])){
                    nouIniciFase($numeroFase , $dataInici);
                    nouFinalFase($numeroFase , $dataFi);
                    return true;
            }

        }else {
            return false;
        }

    }


    function modificarGos($nomAnterior , $nom , $amo , $imatge , $raça){

        eliminarGos($nomAnterior);

        $nouGos = new Gos($nom , $amo , $raça , $imatge);

        afegirGos($nouGos);
        return true;
    }

    function eliminarVotsFase($numeroFase){

        $nomFase = 'Fase ' . strval($numeroFase);
        borrarVots($nomFase);
    }

    function eliminarTotsElsVots(){

        borrarTotsElsVots();

    }
?>
