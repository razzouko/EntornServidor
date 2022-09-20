<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php

   


    function arrayOposats() {

        $lletresOposades = [ " " => " " ];
        $oposada = 122;
            for ($i = 97 ; $i <= 122; $i++){
                 $lletresOposades[chr($i)] = chr($oposada) ;
                 $oposada--;
           
            }

    return $lletresOposades;
        
    }

    function retornaOposats($lletres){

            $arrayOposats = arrayOposats();

            for ($i = 0 ; $i < strlen($lletres) ; $i++){

                    if (preg_match("/[a-z]/" , $lletres[$i])){

                    $lletres = substr_replace($lletres ,$arrayOposats[$lletres[$i]] , $i ,1);
                    
                }

            }

    return $lletres;

    }

    function decrypt($valor){

        $desencriptat = "";
        $posicio = 0;
        for($i = 0; $i < strlen($valor); $i += 3 ){  
            
            $lletres = ""; 
            $lletres = substr($valor , $i , 3);
            $lletres = strrev($lletres);
            
            $desencriptat = $desencriptat . retornaOposats($lletres);

            $posicio++;
            }
    
    return $desencriptat;

    }

    $sp = "kfhxivrozziuortghrvxrrkcrozxlwflrh";
    $mr = " hv ovxozwozv vj o vfrfjvivfj h vmzvlo e hrxvhlmov oz ozx.vw z xve hv loqvn il hv lmnlg izxvwrhrvml ,hv b lh mv,rhhv mf w zrxvlrh.m";
   echo decrypt($sp) . "<br>";
   echo decrypt($mr);

?>


</body>
</html>