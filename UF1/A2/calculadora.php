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
            <input type="text" class="value" name="screen" readonly value="<?php $_POST["btn"] != "="? construirOperacio(): ferCalcul()  ?>"/>
            <span class="num"><input type ="submit" value="(" name=  "btn"></span>
            <span class="num"><input type ="submit" value=")" name = "btn"></span>
            <span class="num"><input type ="submit" value="sin" name = "btn" ></span>
            <span class="num"><input type ="submit" value="cos" name = "btn"></span>
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
        
            function ferCalcul(){

                // protegir el codi de l'eval
                if($_POST["btn"] == "="){
                    $operacio = $_POST["screen"];
                    try{
                        eval("\$resultat = " . $operacio . ";");
                        //s'ha de fer un trim pel tema dels decimals
                        return $resultat;
                    }catch(DivisionByZeroError $e){
                        return "Inf";                    
                    }catch(Error $f){
                        return "Error";
                    }
                    return $resultat;
                }      
            }

            function construirOperacio(){

                if($_POST["btn"] == "C")
                return;

                if($_POST["btn"] != "="){
                    if(preg_match('/^[\+|\-|\*|\/]$/' , substr($_POST["screen"] , -1)) 
                        && preg_match('/^[\+|\-|\*|\/]$/' ,$_POST["btn"])){
                            return substr_replace($_POST["screen"] , $_POST["btn"] , -1 , 1);
                        }
                        return $_POST["screen"] . $_POST["btn"];
                    }
                
            }
        





















        ?>

    </div>
</body>