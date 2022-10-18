
<?php 

    /*session_id(45);
    session_start();
    if(!isset($_SESSION["funcionsValides"]))
        $_SESSION["funcionsValides"] = obtenirFuncions();


    $funcions = $_SESSION["funcionsValides"];
*/
    
    srand(time());
    function generarLletres() : array{

        $lletres = [];
        do{
            $aleatori = chr(rand(97 , 122));
            if(!in_array($aleatori, $lletres)){
                $lletres[] = $aleatori;
            }
    
        }while(count($lletres) < 7);
        $lletres[] = "_";

        for ($i=1; $i < 10 ; $i++) { 
            $lletres[] = strval($i);
        }
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


    $funcions = get_defined_functions()["internal"];

    function obtenirFuncionsValides($funcions){
        
        do{
            $lletres = generarLletres();
            $lletresAleatories = $lletres;
            $funcionsValides = [];
            for ($i=0; $i < count($funcions) ; $i++) {
                if($funcions[$i] == "_"){
                    break;
                } 
                $caracters = str_split($funcions[$i] , 1);
                $diferents = array_diff($caracters , $lletresAleatories);
                if(count($diferents) == 0){
                    $funcionsValides[] = $funcions[$i];
                }

                if(count($funcionsValides) >= 10)
                    break;
            }
        }while(count($funcionsValides) < 10);

        
    $repeticionsLletra = [];
    foreach($funcionsValides as $nom){
        foreach(count_chars($nom , 1) as $lletra => $repeticions){
            if(isset($repeticionsLletra[chr($lletra)]))
                $repeticionsLletra[chr($lletra)] += $repeticions;
            else 
                $repeticionsLletra[chr($lletra)] = $repeticions;
        }
    }
        
    return array_search(max($repeticionsLletra) , $repeticionsLletra);
       
    }

    $funcionsValides = obtenirFuncionsValides($funcions);

     echo $funcionsValides;


?>