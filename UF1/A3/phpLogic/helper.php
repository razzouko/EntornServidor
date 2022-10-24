<?php 


/**
 * Entrada una data s'aplica a la llavor del random
 * @param date    
 * 
 */ 
function setDateRand($date){

    srand($date);

}

/**
 * Funcio que retorna lletres aleatories segons la data
 * @return array Lletres aleatories
 */ 

function generarLletres() : array{

    $lletres = [];
    do{
        $aleatori = chr(rand(97 , 122));
        if(!in_array($aleatori, $lletres)){
            $lletres[] = $aleatori;
        }

    }while(count($lletres) < 7);
    $lletres[] = "_";
    
    return $lletres;

}


/**
 * Funcio que comprova i retorna funcions de php amb menys de 9 lletres diferents 
 * comptan la barra baixa
 * @return array Funcions amb menys de 8 caràcters diferents
 */ 
function obtenirFuncions() : array{

    $funcions = get_defined_functions()["internal"];
    $funcionsAComprovar = [];

    for ($i=0; $i < count($funcions) ; $i++) { 

        $caracDiferents = count_chars($funcions[$i] , 3);
        if(strlen($caracDiferents) <= 8){
            $funcionsAComprovar[] = $funcions[$i]; 
        }
    }

    return $funcionsAComprovar;
}


/**
 * 
 * @param array Funcions a comprovar
 * @return array `[0] = Lletra del mig , [1] = Lletres aletories , [2] Funcions amb les que jugar
 */ 
function obtenirFuncionsValides(array $funcions) : array{
    
    
    do{
        $lletres = generarLletres();
        $lletraMig = $lletres[0];
        $lletresAleatories = $lletres;
        $funcionsValides = [];
        for ($i=0; $i < count($funcions) ; $i++) {
            if($funcions[$i] == "_"){
                break;
            } 
            $caracters = str_split($funcions[$i] , 1);
            
            if(in_array($lletraMig, $caracters)){
                $diferents = array_diff($caracters , $lletresAleatories);
                if(count($diferents) == 0){
                    $funcionsValides[] = $funcions[$i];
                }
            }
            if(count($funcionsValides) >= 10)
                break;
        }
    }while(count($funcionsValides) < 10);

    unset($lletres[array_search("_", $lletres)]);
    unset($lletres[array_search($lletraMig, $lletres)]);
    shuffle($lletres);

    return [$lletraMig , $lletres , $funcionsValides];
}




?>