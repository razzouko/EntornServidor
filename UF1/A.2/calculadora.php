<!DOCTYPE html>
<html lang="ca">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Calculadora</title>
</head>
<body>
    <div class="container"> 
        <form action="" name="calc" class="calculator" method = "post">
            <input type="text" class="value"  name="screen" readonly value="<?php   echo ferCalcul()?>"/>
            <input type="hidden" name="lastval" value="<?php echo (isset($_POST["btn"])) ? $_POST["btn"] : ""; //input amagat on guardo l'últim valor que s'ha clicat?>"> 
            <span class="num"><input type ="submit" value="(" name ="btn"></span>
            <span class="num"><input type ="submit" value=")" name ="btn"></span>
            <span class="num"><input type ="submit" value="sin" name ="btn" ></span>
            <span class="num"><input type ="submit" value="cos" name ="btn"></span>
            <span class="num clear"><input type ="submit" value="C" name = "btn"></span>
            <span class="num"><input type ="submit" value="/" name=  "btn"></span>
            <span class="num"><input type ="submit" value="*" name = "btn"></span>
            <span class="num"><input type ="submit" value="7" name = "btn" ></span>
            <span class="num"><input type ="submit" value="8" name = "btn"></span>
            <span class="num"><input type ="submit" value="9" name = "btn"></span>
            <span class="num"><input type ="submit" value="-" name = "btn"></span>
            <span class="num"><input type ="submit" value="4" name = "btn"></span>
            <span class="num"><input type ="submit" value="5" name = "btn"></span>
            <span class="num"><input type ="submit" value="6" name = "btn"></span>
            <span class="num plus"><input type ="submit" value="+" name = "btn"></span>
            <span class="num"><input type ="submit" value="1" name = "btn"></span>
            <span class="num"><input type ="submit" value="2" name = "btn"></span>
            <span class="num"><input type ="submit" value="3" name = "btn"></span>
            <span class="num"><input type ="submit" value="0" name = "btn"></span>
            <span class="num"><input type ="submit" value="00" name = "btn"></span>
            <span class="num"><input type ="submit" value="." name = "btn"></span>
            <span class="num equal"><input type ="submit" value="=" name = "btn"></span>
        </form>

        <?php 
        
            /**
            * funció ferCalcul() verifica , construeix i calcula l'operació proposada
            * @param {} 
            * @returns {}
            */
            function ferCalcul(){

                if(!isset($_POST["btn"]) || !isset($_POST["screen"]))
                    return"";

                if(preg_match('/^[\$]$/' , $_POST["screen"]))
                    return;

                if($_POST["btn"] == "C")
                    return;
    
                if($_POST["btn"] != "=" && $_POST["lastval"] != "="){
                    if(preg_match('/^[\+|\-|\*|\/]$/' , substr($_POST["screen"] , -1)) 
                    && preg_match('/^[\+|\-|\*|\/]$/' ,$_POST["btn"])){
                        return substr_replace($_POST["screen"] , $_POST["btn"] , -1 , 1);
                    }elseif($_POST["btn"] == "sin" || $_POST["btn"] == "cos"){
                        return $_POST["screen"] . $_POST["btn"] . "(";
                    }else
                        return $_POST["screen"] . $_POST["btn"];
                }elseif($_POST["lastval"] == "=" && $_POST["btn"] != "=" ){
                    if($_POST["btn"] == "sin")
                        return "sin(" . $_POST["screen"] . ")";
                    elseif($_POST["btn"] == "cos")
                        return "cos(" . $_POST["screen"] . ")";
                    else
                        return $_POST["btn"]; 
                }

                if($_POST["btn"] == "="){
                    $operacio = comprovarParentesis();
                    $operacio = comprovarMultiplicar($operacio);
                    try{
                        eval("\$resultat = round(" . $operacio . " , 4);");
                        return $resultat;
                    }catch(DivisionByZeroError $e){
                        return "Inf";                    
                    }catch(Error $f){
                        return "Error";
                    }
                    return $resultat;
                  
                }      
            }

            /**
            * funció comprovarParentesis() comprova que els parèntesis estiguin correctament posat i sino arregla l'operació
            * 
            * @param {} 
            * @returns {}
            */
            function comprovarParentesis(){
                if(!preg_match('/\(/', $_POST["screen"]))
                    return $_POST["screen"];

                $stack = [];
                $operacio = $_POST["screen"];
                for($i = 0 ; $i < strlen($operacio) ; $i++){
                    if($operacio[$i] == "(")
                        $stack[] = $operacio[$i];

                    if($operacio[$i] == ")")
                        array_pop($stack);
                }

                for($i = 0 ; $i < count($stack) ; $i++){
                    
                    $operacio .= ')';

                }
                return $operacio;
            }

            /**
            * funció comprovarMultiplicar() pasada una operacio on es dona el cas que no s'especifica operant, entre un nombre i un parèntesis
            * o sin o cos, arregala l'operació interpretant l'operació com una multiplicació.
            *   
            * @param {String} 
            * @returns {String}
            */
            function comprovarMultiplicar( string $operacio) : string{

                for($i = 1 ; $i < strlen($operacio) ; $i++){
                    
                        if($operacio[$i] == "(" )
                            if(is_numeric($operacio[$i - 1]))
                               $operacio = substr_replace($operacio , "*" , $i , 0);
                        
                        if($operacio[$i] == "s" || $operacio[$i] == "c")
                            if(is_numeric($operacio[$i - 1]))
                                $operacio = substr_replace($operacio , "*" , $i , 0);

                }

                return $operacio;
            }

        ?>

    </div>
</body>