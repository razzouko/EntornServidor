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

        
        $ipClau = $_SERVER['REMOTE_ADDR'];
        $textPla = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer 
        took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It wa
        s popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        ";
        

        function obtenirArrayAscii($textPla){

            $paraulesAscii = [];
            #obtinc el text en base 64
            $textBase64 = base64_encode($textPla);

            for($i = 0 ; $i < strlen($textBase64) ; $i++){

                #paso caràcter a caràcter a ASCII
                 $paraulesAscii[$i] = ord($textBase64[$i]);

            }
        return $paraulesAscii;

        }

        function equivalentDeAsciiA64($valorsAscii){

            $equivalentsAscii = [];

            for($i = 0 ; $i < count($valorsAscii) ; $i++){

                #paso caràcter a caràcter a ASCII
                 $equivalentsAscii[$i] = chr($valorsAscii[$i]);

            }

        return  base64_decode(implode('',$equivalentsAscii));
        }

        function aBase62($textBase64 , $ipClau) {

            #generem l'equivalent als caracters que vull eliminar
            $suma = strval(ord("+") + ord($ipClau[-4]));
            $barra = strval(ord("/") + ord($ipClau[-4]));
            $igual = strval(ord("=") + ord($ipClau[-4]));
                for ( $i = 0 ; $i < count($textBase64) ; $i++){
                 
                    # es canvia cada ocurrencia del mes , la barra 0 l'igual per la cadena generada
                    if( preg_match('/[+]/' , $textBase64[$i]) == 1 ) {

                        $textBase64[$i] =str_ireplace("+" , $suma,$textBase64[$i]);

                    } elseif (preg_match('/[\/]/' , $textBase64[$i]) == 1){

                        $textBase64[$i] =str_ireplace("/" , $suma,$textBase64[$i]);

                    } elseif (preg_match('/[=]/' , $textBase64[$i]) == 1){

                        $textBase64[$i] =str_ireplace("=" , $igual,$textBase64[$i]);    

                    }
                }

        return $textBase64;
        }

        function deBase62a64($textBase62 , $ipClau) {

            #generem l'equivalent als caracters
            $suma = strval(ord("+") + ord($ipClau[-4]));
            $barra = strval(ord("/") + ord($ipClau[-4]));
            $igual = strval(ord("=") + ord($ipClau[-4]));

                for ( $i = 0 ; $i < count($textBase62) ; $i++){
                 
                        if (str_contains($textBase62[$i] , $suma)){

                            $textBase62[$i] =str_ireplace($suma, "+", $textBase62[$i]);

                        }elseif (str_contains($textBase62[$i] , $barra)){

                            $textBase62[$i] =str_ireplace($barra, "/", $textBase62[$i]);

                        }elseif (str_contains($textBase62[$i] , $igual)){

                            $textBase62[$i] =str_ireplace($igual, "+", $textBase62[$i]);

                        }
                    
                }

        return $textBase62;
        }

        function encriptar($textPla , $ipClau){

            #part de la ip que es fa servir
            $posicioIp = 0;
            #si es local host es pasa la ip literal
            if($ipClau[0] == ":")  {$ipClau = "127.0.0.1" ;}

            #separem les parts de l'ip
            $clau = explode(".",$ipClau);
           
            $textAscii = obtenirArrayAscii($textPla);
            
            $textConvertit = [];
             # cada codi ASCII que pertany a cada lletra del text convertit l'hi apliquem aquesta operació
            for ($i = 0 ; $i < count($textAscii) ; $i++) {

                #aquest serveix per controlar si una de les poscions de la ip es 0 aplicar una funcio diferent 
                if( $clau[$posicioIp] != 0 ) {
                    
                    
                    $textConvertit[$i] = base64_encode(($textAscii[$i] * $clau[$posicioIp]) * 2);

                    #amb l'if controlo que la posico vagi de 0 a 3 per no pasarse de posico a 
                    if( $posicioIp == 3){
                        $posicioIp = 0;
                    } else {
                        $posicioIp++;
                    }
                } else{
                    
                    #en cas que que la poscio de l'ip sigui 0 nomes faig el seu doble
                    $textConvertit[$i] = base64_encode(($textAscii[$i] * ($clau[$posicioIp] +1) ) * 2);
                    if( $posicioIp == 3){
                        $posicioIp = 0;
                    } else {
                        $posicioIp++;
                    }
                }

            }
        
             # paso de Base64 a Base 62 
             $textConvertit = aBase62($textConvertit , $ipClau);
             # genero un delimitador per separar les lletres
             $delimitador = "FeErfgg" . ord($ipClau[3]) . "kkkk1";
             
        return implode($delimitador , $textConvertit);
        }

       function desencriptar( $textEncriptat , $ipClau){
            
            $posicioIp = 0;
            if($ipClau[0] == ":")  {$ipClau = "127.0.0.1" ;}
            # separem cada lletra pel delimitador que hem fet servir per encriptar
             $arrayTextEncriptat = explode( "FeErfgg" . ord($ipClau[3]) . "kkkk1" , $textEncriptat);
            # pasem de base 62 a base 64
             $arrayTextEncriptat = deBase62a64($arrayTextEncriptat ,$ipClau);
           
            # obtenim les posicions de la IP
            $clau = explode('.' , $ipClau);
           
            $valorsAscii = [];
             for ($i = 0 ; $i < count($arrayTextEncriptat) ; $i++) {
                
                #aquest serveix per controlar si una de les poscions de la ip es 0 aplicar una funcio diferent 
                if( $clau[$posicioIp] != 0 ) {
                   
                    #paso de base64 al valor resultat de l'operacio amb l'ip
                    $valorDecode = intval(base64_decode($arrayTextEncriptat[$i])); 
                    $valorsAscii[$i] = $valorDecode/ 2 / $clau[$posicioIp]; 
                    #amb l'if controlo que la posicio vagi de 0 a 3 per no pasarse d'index
                    if( $posicioIp == 3){
                        $posicioIp = 0;
                    } else {
                        $posicioIp++;
                    }
                } else{
                   
                    #en cas que que la poscio de l'ip sigui 0 nomes faig el seu doble
                    $valorDecode = intval(base64_decode($arrayTextEncriptat[$i])); 
                    $valorsAscii[$i] = ($valorDecode / 2) / ($clau[$posicioIp] + 1); 
                    if( $posicioIp == 3){
                        $posicioIp = 0;
                    } else {
                        $posicioIp++;
                    }
                }

               
            }
            $textDesencriptat = equivalentDeAsciiA64($valorsAscii);
            return $textDesencriptat;
        }

        echo "-----------------TEXT ENCRIPTAT------------------" . "<br>";
        echo encriptar($textPla , $ipClau)  . "<br>";
        $encriptat = encriptar($textPla , $ipClau);
        echo "-----------------TEXT DESENCRIPTAT------------------"  . "<br>";
        echo  desencriptar($encriptat , $ipClau)
    ?>





</body>
</html>