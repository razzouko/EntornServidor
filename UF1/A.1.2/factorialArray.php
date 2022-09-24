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

        function factorial($numero){
            if($numero < 0) 
                return false;
            if ($numero == 1) 
                return 1;
            else 
                return $numero * factorial($numero -1);
        }
    
        function factorialArray($array) : array | bool{

            if(  is_array($array) != true ) 
                return false;
      
            for( $i = 0 ; $i < count($array) ; $i++ ){
                if (is_numeric($array[$i]) != true)
                    return false;
                $array[$i] = factorial($array[$i]);
                if ($array[$i] == false)
                    return false;
            }
            return $array;
        }
        
        print_r(factorialArray([1 , 2 , 3]))
         
    ?>









</body>
</html>