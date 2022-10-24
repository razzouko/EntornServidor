
<?php 

function setDateRand($date){

    srand($date);

}

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



function obtenirFuncions(){

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



function obtenirFuncionsValides($funcions){
    
    
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
    return $lletres;

}

    $funcionsValides = obtenirFuncions();
    $prova = obtenirFuncionsValides($funcionsValides);
    echo print_r($prova);


?>