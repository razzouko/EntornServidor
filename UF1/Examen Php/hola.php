<?php 
    if(!isset($_COOKIE["PHPSESSID"])){
        header("Location: index.php");
    }

    include("process.php")
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Benvingut</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container noheight" id="container">
    <div class="welcome-container">
        <h1>Benvingut!</h1>
        <div>Hola <?php echo (isset($_SESSION["nomUsuari"]))? $_SESSION["nomUsuari"] : "error"  ?>, les teves darreres connexions són:</div>
        <form action="process.php" method="post">
        <p>
            <?php 
                $connexions = llegeix($CONNECTIONS_FILE);
                foreach( $connexions as $valors){
                    if($valors["user"] == $_SESSION["correuUsuari"] && $valors["status"] == "correcte"){
                        echo "Connexio desde " .  $valors["ip"] . 
                        "  data " . $valors["time"] . 
                        " amb estat " . $valors["status"] . "<br>";
                    }

                }
            ?>
            </p>
            <input type="text" name="tancaSessio" value="tancar" hidden>
            <button>Tanca la sessió</button>
        </form>
    </div>
</div>
</body>
</html>