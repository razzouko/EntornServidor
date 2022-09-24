
    <?php

        function creaMatriu( int $n) : array{
            $matriu = [];
            $asterisc = 0;
            for( $fila = 0; $fila < $n ; $fila++){
                $matriu[$fila]=[]; 
                for($columna = 0 ; $columna < $n ; $columna++){    
                    if($asterisc == $columna)
                        $matriu[$fila][$columna] = "*";
                    elseif($asterisc > $columna)
                        $matriu[$fila][$columna] = random_int(10,20);
                    elseif($asterisc < $columna)
                        $matriu[$fila][$columna] = $fila + $columna;
                }
                $asterisc += 1;
            }
            return $matriu;
        }

        function mostraMatriu(array $matriu) : string{
            $taula = "<table border = 1px> <tr>";
            $taula .= "<th>" . "</th>";
            for($i = 0 ; $i < count($matriu[0]) ; $i++){
                $taula .= "<th>" . $i ."</th>";
            }
            $taula .= "</tr>";
            foreach($matriu as $fila => $valors){
                $taula .=  "<tr>";
                $taula .= "<td> <b>" . $fila . " </b> </td>" ;    
                foreach($valors as $valor){
                    $taula .= "<td>". $valor ."</td>"; 
                }
                $taula .=  "</tr>";
            }
            $taula .= "</table>";
            return $taula;
        }
        
        function transposaMatriu(array $matriu) : array{
            
            $files = count($matriu);
            $columnes = count($matriu[0]);
            echo $files;
            #en cas que la matriu sigui rectangular per part de la columnes 
            if($columnes > $files)
                $matriu[$files] = [];

            $asterisc = 0;
            $aux = 0; 
            
            for($fila = 0 ; $fila < $files; $fila++){
                for($columna = 0 ; $columna < $columnes ; $columna++){
                    if($columna > $asterisc && $columna  ){
                        if(empty($matriu[$columna][$fila])){
                            $matriu[$columna][$fila] = $matriu[$fila][$columna];
                            unset($matriu[$fila][$columna]);
                        }else{
                            $aux = $matriu[$columna][$fila];
                            $matriu[$columna][$fila] = $matriu[$fila][$columna];
                            $matriu[$fila][$columna] = $aux;
                        }
                    }
                }
                $asterisc += 1;
            }
            return $matriu;
        }

        function creaMatriuRectangle( int $files , int $columnes) : array{
            $matriu = [];
            $asterisc = 0;
            for( $fila = 0; $fila < $files ; $fila++){
                $matriu[$fila]=[]; 
                for($columna = 0 ; $columna < $columnes ; $columna++){    
                    if($asterisc == $columna)
                        $matriu[$fila][$columna] = "*";
                    elseif($asterisc > $columna)
                        $matriu[$fila][$columna] = random_int(10,20);
                    elseif($asterisc < $columna)
                        $matriu[$fila][$columna] = $fila + $columna;
                }
                $asterisc += 1;
            }
            return $matriu;
        }
        
        
        $matriu = creaMatriuRectangle(5, 7);
        print_r($matriu);
        echo "<br />" . "Matriu inical";
        echo mostraMatriu($matriu);
        
        echo "<br />" . "Matriu transposada";
        echo mostraMatriu((transposaMatriu($matriu)));
        
        echo "<br />" . "Matriu Quadrada";
        $quadrada = creaMatriu(3);
        echo mostraMatriu($quadrada);
    ?>



