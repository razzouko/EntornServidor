<?php 

    include "helper.php";
    include "moduls/fase.php";
session_start();

    if (!isset($_SESSION["usuari"]))
        header("Location: http://localhost/entornservidor/concurs/login/login.php");
    elseif( $_SESSION["usuari"] != "admin") 
        header("Location: http://localhost/entornservidor/concurs/index.php");
    elseif (time() - $_SESSION["login_time_stamp"] > 60)
        header("Location: http://localhost/entornservidor/concurs/index.php");

    $nomFase = obtenirFaseActual();
    $faseActual = new Fase($nomFase); // mostrar gossos de la fase

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper medium">
    <header>ADMINISTRADOR - Concurs Internacional de Gossos d'Atura</header>
    <div class="admin">
        <div class="admin-row">
            <h1> Resultat parcial: <?php echo $faseActual->getNom() ?> </h1>
            <div class="gossos">
            <?php 

            foreach($faseActual->obtenirGossos() as $gos => $vots){
                echo "<img class='dog' alt='$gos' title='$gos $vots%' src="img/g1.png">"
            }
                




            /*<img class="dog" alt="Jingo" title="Jingo 45%" src="img/g2.png">
            <img class="dog" alt="Xuia" title="Xuia 4%" src="img/g3.png">
            <img class="dog" alt="Bruc" title="Bruc 3%" src="img/g4.png">
            <img class="dog" alt="Mango" title="Mango 13%" src="img/g5.png">
            <img class="dog" alt="Fluski" title="Fluski 12 %" src="img/g6.png">
            <img class="dog" alt="Fonoll" title="Fonoll 5%" src="img/g7.png">
            <img class="dog" alt="Swing" title="Swing 2%" src="img/g8.png">
            <img class="dog eliminat" alt="Coloma" title="Coloma 1%" src="img/g9.png">*/

            ?>
            </div>
        </div>
        <div class="admin-row">
            <h1> Fases: </h1>
            <form class="fase-row">
                Fase <input type="text" value="1" disabled style="width: 3em">
                del <input type="date" placeholder="Inici">
                al <input type="date" placeholder="Fi">
                <input type="button" value="Modifica">
            </form>

            <form class="fase-row">
                Fase <input type="text" value="2" disabled style="width: 3em">
                del <input type="date" placeholder="Inici">
                al <input type="date" placeholder="Fi">
                <input type="button" value="Modifica">
            </form>

            <form class="fase-row">
                Fase <input type="text" value="3" disabled style="width: 3em">
                del <input type="date" placeholder="Inici">
                al <input type="date" placeholder="Fi">
                <input type="button" value="Modifica">
            </form>

            <form class="fase-row">
                Fase <input type="text" value="4" disabled style="width: 3em">
                del <input type="date" placeholder="Inici">
                al <input type="date" placeholder="Fi">
                <input type="button" value="Modifica">
            </form>

            <form class="fase-row">
                Fase <input type="text" value="5" disabled style="width: 3em">
                del <input type="date" placeholder="Inici">
                al <input type="date" placeholder="Fi">
                <input type="button" value="Modifica">
            </form>

            <form class="fase-row">
                Fase <input type="text" value="6" disabled style="width: 3em">
                del <input type="date" placeholder="Inici">
                al <input type="date" placeholder="Fi">
                <input type="button" value="Modifica">
            </form>

            <form class="fase-row">
                Fase <input type="text" value="7" disabled style="width: 3em">
                del <input type="date" placeholder="Inici">
                al <input type="date" placeholder="Fi">
                <input type="button" value="Modifica">
            </form>

            <form class="fase-row">
                Fase <input type="text" value="8" disabled style="width: 3em">
                del <input type="date" placeholder="Inici">
                al <input type="date" placeholder="Fi">
                <input type="button" value="Modifica">
            </form>

        </div>

        <div class="admin-row">
            <h1> Concursants: </h1>
            <form>
                <label>1</label>
                <input type="text" placeholder="Nom" value="Musclo">
                <input type="text" placeholder="Imatge" value="img/g1.png">
                <input type="text" placeholder="Amo" value="Joan Pere Arnau">
                <input type="text" placeholder="Raça" value="Husky Siberià">
                <input type="button" value="Modifica">
            </form>

            <form>
                <label>2</label>
                <input type="text" placeholder="Nom" value="Musclo">
                <input type="text" placeholder="Imatge" value="img/g1.png">
                <input type="text" placeholder="Amo" value="Joan Pere Arnau">
                <input type="text" placeholder="Raça" value="Husky Siberià">
                <input type="button" value="Modifica">
            </form>

            <form>
                <label>3</label>
                <input type="text" placeholder="Nom" value="Musclo">
                <input type="text" placeholder="Imatge" value="img/g1.png">
                <input type="text" placeholder="Amo" value="Joan Pere Arnau">
                <input type="text" placeholder="Raça" value="Husky Siberià">
                <input type="button" value="Modifica">
            </form>

            <form>
                <label>4</label>
                <input type="text" placeholder="Nom" value="Musclo">
                <input type="text" placeholder="Imatge" value="img/g1.png">
                <input type="text" placeholder="Amo" value="Joan Pere Arnau">
                <input type="text" placeholder="Raça" value="Husky Siberià">
                <input type="button" value="Modifica">
            </form>

            <form>
                <label>5</label>
                <input type="text" placeholder="Nom" value="Musclo">
                <input type="text" placeholder="Imatge" value="img/g1.png">
                <input type="text" placeholder="Amo" value="Joan Pere Arnau">
                <input type="text" placeholder="Raça" value="Husky Siberià">
                <input type="button" value="Modifica">
            </form>

            <form>
                <label>6</label>
                <input type="text" placeholder="Nom" value="Musclo">
                <input type="text" placeholder="Imatge" value="img/g1.png">
                <input type="text" placeholder="Amo" value="Joan Pere Arnau">
                <input type="text" placeholder="Raça" value="Husky Siberià">
                <input type="button" value="Modifica">
            </form>

            <form>
                <label>7</label>
                <input type="text" placeholder="Nom" value="Musclo">
                <input type="text" placeholder="Imatge" value="img/g1.png">
                <input type="text" placeholder="Amo" value="Joan Pere Arnau">
                <input type="text" placeholder="Raça" value="Husky Siberià">
                <input type="button" value="Modifica">
            </form>

            <form>
                <label>8</label>
                <input type="text" placeholder="Nom" value="Musclo">
                <input type="text" placeholder="Imatge" value="img/g1.png">
                <input type="text" placeholder="Amo" value="Joan Pere Arnau">
                <input type="text" placeholder="Raça" value="Husky Siberià">
                <input type="button" value="Modifica">
            </form>

            <form>
                <label>9</label>
                <input type="text" placeholder="Nom" value="Musclo">
                <input type="text" placeholder="Imatge" value="img/g1.png">
                <input type="text" placeholder="Amo" value="Joan Pere Arnau">
                <input type="text" placeholder="Raça" value="Husky Siberià">
                <input type="button" value="Modifica">
            </form>
            
        </div>

        <div class="admin-row">
            <h1> Altres operacions: </h1>
            <form>
                Esborra els vots de la fase
                <input type="number" placeholder="Fase" value="">
                <input type="button" value="Esborra">
            </form>
            <form>
                Esborra tots els vots
                <input type="button" value="Esborra">
            </form>
        </div>
    </div>
</div>

</body>
</html>