<?php
    require_once "helper.php";
    require_once "moduls/fase.php";
    session_start();

    if (!isset($_SESSION["usuari"])){
        header("Location: http://localhost/entornservidor/concurs/login/login.php");
    } elseif( time() - $_SESSION["login_time_stamp"] > 60 ) {
        header("Location: http://localhost/entornservidor/concurs/login/login.php");
    }

    // calcular per dies la fase actual, si no estas dins una fase no deixa votar
    $nomFase = obtenirFaseActual();
    
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votació popular Concurs Internacional de Gossos d'Atura 2023</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <header> Votació popular del Concurs Internacional de Gossos d'Atura 2023- 
    <?php 

    if(!$nomFase){
        echo "No hi ha cap fase activa";
        $_SESSION["Fase"] = "inactiva";
    }else{
        echo $nomFase;
        $_SESSION["Fase"] = $nomFase;
        $fase = new Fase($nomFase);
    }



    ?> 



    </header>
    <p class="info"> Podeu votar fins el dia 01/02/2023</p>

    <p class="warning">
    <?php      
    if(is_string($nomFase)){
        $gos = votFaseActual($_SESSION["usuari"], $nomFase);
        $_SESSION["votActual"] =  $gos;
        
        if(!is_string($gos)){
            echo "Encara no has votat";
            $_SESSION["votActual"] = 'nou';
        }else
            echo "Ja has votat al gos ". $gos . " Es modificarà la teva resposta";
        $hidden = false;

        $gossos = $fase->obtenirGossos();


    } else{
        echo "No es pot votar";
        $hidden = true;
    }
    ?>
    </p>
    <div class="poll-area" <?php echo ($hidden)? "hidden": "" ; ?>>
        <form action="process.php" method="post">
        <input type="checkbox" name="poll" id="opt-1">
        <input type="checkbox" name="poll" id="opt-2">
        <input type="checkbox" name="poll" id="opt-3">
        <input type="checkbox" name="poll" id="opt-4">
        <input type="checkbox" name="poll" id="opt-5">
        <input type="checkbox" name="poll" id="opt-6">
        <input type="checkbox" name="poll" id="opt-7">
        <input type="checkbox" name="poll" id="opt-8">
        <input type="checkbox" name="poll" id="opt-9">
        <input type="text" name="seleccio" hidden>

        <?php 
        
            $optNum = 1;

            foreach($gossos as $nom => $vots){

                $opt = "opt-" . $optNum;
                $optNum++;

                echo " <label for= " . $opt . " class= " .$opt . ">";
                echo " <div class=row >";
                echo " <div class='column'>";
                echo " <div class='right' >";
                echo " <span class='circle'></span>";
                echo " <span class='text'>" . $nom . "</span>";
                echo " </div>";
                echo " <img class='dog'  alt=$nom src='img/$nom.png'>";
                echo " </div>";
                echo " </div>";
                echo " </label>";
            }
        
        
        
        
        
        
        ?>





        <!--
        <label for="opt-1" class="opt-1" >
            <div class="row" >
                <div class="column">
                    <div class="right">
                    <span class="circle"></span>
                    <span class="text">Musclo</span>
                    </div>
                    <img class="dog"  alt="Musclo" src="img/g1.png">
                </div>
            </div>
        </label> 
        
        <label for="opt-2" class="opt-2">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Jingo</span>
                    </div>
                    <img class="dog"  alt="Jingo" src="img/g2.png">
                </div>
            </div>
        </label>
        <label for="opt-3" class="opt-3">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Xuia</span>
                    </div>
                    <img class="dog"  alt="Xuia" src="img/g3.png">
                </div>
            </div>
        </label>
        <label for="opt-4" class="opt-4">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Bruc</span>
                    </div>
                    <img class="dog"  alt="Bruc" src="img/g4.png">
                </div>
            </div>
        </label>
        <label for="opt-5" class="opt-5">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Mango</span>
                    </div>
                    <img class="dog"  alt="Mango" src="img/g5.png">
                </div>
            </div>
        </label>
        <label for="opt-6" class="opt-6">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Fluski</span>
                    </div>
                    <img class="dog"  alt="Fluski" src="img/g6.png">
                </div>
            </div>
        </label>
        <label for="opt-7" class="opt-7">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Fonoll</span>
                    </div>
                    <img class="dog"  alt="Fonoll" src="img/g7.png">
                </div>
            </div>
        </label>
        <label for="opt-8" class="opt-8">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Swing</span>
                    </div>
                    <img class="dog"  alt="Swing" src="img/g8.png">
                </div>
            </div>
        </label>
        <label for="opt-9" class="opt-9">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Coloma</span>
                    </div>
                    <img class="dog"  alt="Coloma" src="img/g9.png">
                </div>
            </div>
        </label>
-->
        </form>
    </div>

    <p> Mostra els <a href="resultats.html">resultats</a> de les fases anteriors.</p>
</div>

</body>

    <script>

        window.onload = carregarBotons();


        function carregarBotons(){

            let eleccions = document.getElementsByTagName("label");

            for (let i = 0; i < eleccions.length ; i++) {
                eleccions[i].addEventListener("click", function(){
                    
                    let inputSeleccio = document.getElementsByName("seleccio")[0];
                    let opcioNum = parseInt(this.className.substr(4 ,1));
                    let spanText = document.getElementsByClassName("text")[opcioNum -1];
                    inputSeleccio.value = spanText.innerHTML;
                    document.getElementsByTagName("form")[0].submit();
                })
            }


        }
        
    </script>


</html>