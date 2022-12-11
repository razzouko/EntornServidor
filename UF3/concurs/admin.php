<?php 

    require_once "helper.php";
    require_once "moduls/fase.php";

session_start();

    if (!isset($_SESSION["usuari"]))
        header("Location: http://localhost/MP07/UF3/concurs/login/login.php");
    elseif( $_SESSION["usuari"] != "admin") 
        header("Location: http://localhost/MP07/UF3/concurs/index.php");
    elseif (time() - $_SESSION["login_time_stamp"] > 60)
        header("Location: http://localhost/MP07/UF3/concurs/index.php");

    $nomFase = obtenirFaseActual();
    $fase = new Fase("Fase 1"); // mostrar gossos de la fase
    $fases = obtenirFases();
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
            <h1> Resultat parcial: <?php echo $fase->getNom() ?> </h1>
            <div class="gossos">
            <?php 

            $gossosFase = $fase->obtenirGossos();

            foreach( $gossosFase as $gos => $vots){
                echo "<img class='dog' alt='$gos' title='$gos $vots%' src=img/$gos.png>";
            }
                
            ?>
            </div>
        </div>
        <div class="admin-row">
            <h1> Nou usuari: </h1>
            <form action="admin_process.php" method="post">
                <input type="text" name="nom" placeholder="Nom">
                <input type="password" name="password" placeholder="Contrassenya">
                <input type="text" name="tipus" value="admin" hidden>
                <input type="text" name="nouUser" hidden>
                <button>Crea usuari</button>
                <label style="color: red;"> <?php echo (isset($_GET["errorUsuari"])) ? $_GET["errorUsuari"] :"" ;  ?> </label>
            </form>
        </div>
        <div class="admin-row">
            <h1> Fases: </h1>
            <label for="">  <?php echo (isset($_GET["errorData"])) ? $_GET["errorData"] :"" ;  ?>   </label>
            <form class="fase-row"  action="admin_process.php" method="post"  >
                Fase <input type="text" value="1" disabled style="width: 3em">
                del <input type="date"  name="dataInici" placeholder="Inici" value=<?php echo $fases[1]["iniciActual"] ?>  >
                al <input type="date" name="dataFi" placeholder="Fi" value=<?php echo $fases[1]["finalActual"] ?>>
                <input type="submit" value="Modifica">
                <input type="text" name="numeroFase" value="1" hidden>
                <input type="text" name="novaData" hidden>
            </form>

            <form class="fase-row" action="admin_process.php" method="post" >
                Fase <input type="text" value="2" disabled style="width: 3em">
                del <input type="date"  name="dataInici" placeholder="Inici" value=<?php echo $fases[2]["iniciActual"] ?>  >
                al <input type="date" name="dataFi" placeholder="Fi" value=<?php echo $fases[2]["finalActual"] ?>>
                <input type="text" name="novaData" hidden>
                <input type="text" name="numeroFase" value="2" hidden>
                <input type="submit"  value="Modifica">
            </form>

            <form class="fase-row" action="admin_process.php" method="post" >
                Fase <input type="text" value="3" disabled style="width: 3em">
                del <input type="date"  name="dataInici" placeholder="Inici" value=<?php echo $fases[3]["iniciActual"] ?>  >
                al <input type="date" name="dataFi" placeholder="Fi" value=<?php echo $fases[3]["finalActual"] ?>>
                <input type="text" name="novaData" hidden>
                <input type="text" name="numeroFase" value="3" hidden>
                <input type="submit" value="Modifica">
            </form>

            <form class="fase-row" action="admin_process.php" method="post" >
                Fase <input type="text" value="4" disabled style="width: 3em">
                del <input type="date"  name="dataInici" placeholder="Inici" value=<?php echo $fases[4]["iniciActual"] ?>  >
                al <input type="date" name="dataFi"placeholder="Fi" value=<?php echo $fases[4]["finalActual"] ?>>
                <input type="text" name="numeroFase" value="4" hidden>
                <input type="submit" value="Modifica">       
            </form>

            <form class="fase-row" action="admin_process.php" method="post" >
                Fase <input type="text" value="5" disabled style="width: 3em">
                del <input type="date"  name="dataInici" placeholder="Inici" value=<?php echo $fases[5]["iniciActual"] ?>  >
                al <input type="date" name="dataFi" placeholder="Fi" value=<?php echo $fases[5]["finalActual"] ?>>
                <input type="text" name="novaData" hidden>
                <input type="text" name="numeroFase" value="5" hidden>
                <input type="submit" value="Modifica">
            </form>

            <form class="fase-row" action="admin_process.php" method="post" >
                Fase <input type="text" value="6" disabled style="width: 3em">
                del <input type="date"  name="dataInici" placeholder="Inici" value=<?php echo $fases[6]["iniciActual"] ?>  >
                al <input type="date" name="dataFi" placeholder="Fi" value=<?php echo $fases[6]["finalActual"] ?>>
                <input type="text" name="novaData" hidden>
                <input type="text" name="numeroFase" value="6" hidden>
                <input type="submit" value="Modifica">
            </form>

            <form class="fase-row" action="admin_process.php" method="post" >
                Fase <input type="text" value="7" disabled style="width: 3em">
                del <input type="date"  name="dataInici" placeholder="Inici" value=<?php echo $fases[7]["iniciActual"] ?>  >
                al <input type="date" name="dataFi" placeholder="Fi" value=<?php echo $fases[7]["finalActual"] ?>>
                <input type="text" name="novaData" hidden>
                <input type="text" name="numeroFase" value="7" hidden>
                <input type="submit" value="Modifica">
            </form>

            <form class="fase-row" action="admin_process.php" method="post" >
                Fase <input type="text" value="8" disabled style="width: 3em">
                del <input type="date"  name="dataInici" placeholder="Inici" value=<?php echo $fases[8]["iniciActual"] ?>  >
                al <input type="date" name="dataFi" placeholder="Fi" value=<?php echo $fases[8]["finalActual"] ?>>
                <input type="text" name="novaData" hidden>
                <input type="text" name="numeroFase" value="8" hidden>
                <input type="submit" value="Modifica">
            </form>

        </div>

        <div class="admin-row">
            <h1> Concursants: </h1>

            <?php 
            
                $totsGossos = obtenirGossosConcurs();
            
                for ($i=0; $i < count($totsGossos); $i++) { 
                
                    $nom = $totsGossos[$i]->getNom();
                    $amo = $totsGossos[$i]->getAmo();
                    $raça = $totsGossos[$i]->getRaça();

                    echo "
                    <form action='admin_process.php' method='post'>
                    <label>$i</label>
                    <input type='text' name='nom' placeholder='Nom' value='$nom'>
                    <input type='text' name='imatge' placeholder='Imatge' value='img/$nom.png'>
                    <input type='text' name= 'amo' placeholder='Amo' value='$amo'>
                    <input type='text' name='raça' placeholder='Raça' value='$raça'>
                    <input type= 'text' name='editarGos' hidden>
                    <input type= 'text' name='nomAnterior' value='$nom' hidden>
                    <input type='submit' value='Modifica'>
                    </form>";
                }

            
            
            ?>

        </div>

        <div class="admin-row">
            <h1> Altres operacions: </h1>
            <form action="admin_process.php" method="post">
                Esborra els vots de la fase
                <input type="number" name="numeroFase" placeholder="Fase" value="">
                <input type="text" name="borrarVots" hidden>
                <input type="submit" value="Esborra">
            </form>
            <form action="admin_process.php" method="post">
                Esborra tots els vots
                <input type="submit" value="Esborra">
                <input type="text" name="borrarTotsElsVots" hidden>
            </form>
        </div>
    </div>
</div>

</body>
</html>