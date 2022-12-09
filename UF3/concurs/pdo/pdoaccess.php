
<?php 

include "gos";
include "fase";

function getConnection(){
    try{
        $hostname = "localhost";
        $dbname = "concurs";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $dbh = new PDO("mysql:host=$hostname;dbname=$dbname;" , "$username" , "$pw");
    } catch(PDOException $ex){
        echo "Error al fer la connexió amb la base de dades: ". $ex->getMessage();
        exit;
    }
    return $dbh;
}


/* Gestions taula gos */
function obtenirGossosConcurs(){

    $dbh = getConnection();

    try{
        $stmt = $dbh->prepare("select * from gos;");
        $stmt->execute();
        $gossos = [];
        foreach ($stmt as $fila) {
            $gos = new Gos($fila["nom"],$fila["amo"],$fila["raça"],$fila["imatge_url"]);
            $gossos[] = $gos;
        }
        return $gossos;
    }catch (PDOException $ex){
        echo "Error al obtenir gossos de la base de dades: ". $ex->getMessage();
        return false;
    }

}


function eliminarGos($nom){

    $dbh = getConnection();

    try{
        $stmt = $dbh->prepare("delete from gos where nom = ? ;");
        $stmt->execute($nom);
        return true;
    }catch(PDOException $ex){
        echo "Error al eliminar gos a base de dades: ". $ex->getMessage();
    }

}

function afegirGos(Gos $gos){
    
    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("insert into gos values (? , ? , ? , ?)");
        $stmt->execute($gos->dadesFormatArr());
        return true;
    }catch(PDOException $ex){
        echo "Error al insertar gos a base de dades: ". $ex->getMessage();
 }
}

function obtenirGos(string $gos){
    
    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("select * from gos where nom = ?");
        $stmt->execute([$gos]);
        return true;
    }catch(PDOException $ex){
        echo "Error al obtenir gos a base de dades: ". $ex->getMessage();
 }
}



/* Gestions taula fase */

function nouIniciFase(string $fase , DateTime $data): bool{

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("update fase set inici = '?' where nom = '?' ;");
        $stmt->execute([$data , $fase]);
        return true;
    }catch(PDOException $ex){
        echo "Error canviar inici de fase a base de dades: ". $ex->getMessage();
    }

}

function nouFinalFase(string $fase , DateTime $data): bool{

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("update fase set final = '?' where nom = '?' ;");
        $stmt->execute([$data , $fase]);
        return true;
    }catch(PDOException $ex){
        echo "Error canviar final de fase a base de dades: ". $ex->getMessage();
    }

}

function obtenirDatesLimit(string $fase): bool{

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("select iniciMaxim , finalMaxim from fase where fase = ?");
        $stmt->execute([$fase]);
        return $stmt->fetchAll();
    }catch(PDOException $ex){
        echo "Error canviar final de fase a base de dades: ". $ex->getMessage();
    }

}




/* Gestions taula fase_x_gos */


    function obtenirGossosXFase(string $fase){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("select gos,vots from fase_x_gos where fase = '?';");
            $stmt->execute([$fase]);
            foreach ($stmt as $fila) {
                $gos_x_vots[$fila["gos"]] = $fila["vots"];
            }
            return $gos_x_vots;
        }catch(PDOException $ex){
            echo "Error obtenir gos i vots de fase a base de dades: ". $ex->getMessage();
        }

    }


    function borrarVots(string $fase){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("update fase_x_gos set vots = 0 where fase = '?';");
            $stmt->execute([$fase]);
            return true;
        }catch(PDOException $ex){
            echo "Error al borrar vots a base de dades: ". $ex->getMessage();
        }

    }


    function actualitzarVotsGos( string $fase , string $gos , int $vots){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("update fase_x_gos set vots = ? where fase = '?' and gos = '?';");
            $stmt->execute([$vots , $fase , $gos]);
            return true;
        }catch(PDOException $ex){
            echo "Error al actualitzar vots a base de dades: ". $ex->getMessage();
        }

    }


/* Gestio taula usuaris*/


    function afegirUsuari(string $nom , string $passwd){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("insert into usuaris values ('?' , '?')");
            $stmt->execute([$nom , $passwd]);
            return true;
        }catch(PDOException $ex){
            echo "Error al actualitzar vots a base de dades: ". $ex->getMessage();
        }
    }

    function obtenirUsuari(string $nom, string $passwd){
        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("select * from usuaris where nom = ? AND password = ?;");
            $stmt->execute([$nom , $passwd]);
            $usuari = $stmt->fetchAll();
            return (count($usuari) == 0)?  false :  true;
        }catch(PDOException $ex){
            echo "Error al obtenir usuari a base de dades: ". $ex->getMessage();
        }
        
    }
?>