
<?php 

require_once __DIR__ . "/../moduls/gos.php";
require_once __DIR__ . "/../moduls/fase.php";


function getConnection(){
    try{
        $hostname = "localhost";
        $dbname = "concurs";
        $username = "osama";
        $pw = "osama";
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
            $gos = new Gos($fila["nom"],$fila["amo"],$fila["raça"],$fila["imatgeUrl"]);
            $gossos[] = $gos;
        }
        return $gossos;
    }catch (PDOException $ex){
        echo "Error al obtenir gossos de la base de dades: ". $ex->getMessage();
        return false;
    }

}

function eliminarDadesGos($nom){

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("delete from fase_x_gos where gos = ? ;");
        $stmt->execute([$nom]);
        return true;
    }catch(PDOException $ex){
        echo "Error al eliminar gos a base de dades: ". $ex->getMessage();
    }




}


function eliminarGos($nom){

    $dbh = getConnection();

    try{

        eliminarDadesGos($nom);
        $stmt = $dbh->prepare("delete from gos where nom = ? ;");
        $stmt->execute([$nom]);
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

function obtenirGos(string $nomGos){
    
    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("select * from gos where nom = ?");
        $stmt->execute([$nomGos]);
        $dades_gos = $stmt->fetch();
        $gos = new Gos($dades_gos["nom"], $dades_gos["amo"], $dades_gos["raça"] , $dades_gos["imatgeUrl"] );
        return $gos;
    
    }catch(PDOException $ex){
        echo "Error al obtenir gos a base de dades: ". $ex->getMessage();
 }
}



/* Gestions taula fase */

function nouIniciFase(string $numeroFase , $data): bool{

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("update fase set iniciActual = ? where numero = ? ;");
        $stmt->execute([$data , $numeroFase]);
        return true;
    }catch(PDOException $ex){
        echo "Error canviar inici de fase a base de dades: ". $ex->getMessage();
    }

}

function nouFinalFase(string $numeroFase , $data): bool{

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("update fase set finalActual = ? where numero = ? ;");
        $stmt->execute([$data , $numeroFase]);
        return true;
    }catch(PDOException $ex){
        echo "Error canviar final de fase a base de dades: ". $ex->getMessage();
    }

}

function obtenirDatesLimit(string $numero){

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("select iniciMaxim , finalMaxim from fase where numero = ?");
        $stmt->execute([$numero]);
        $dates = $stmt->fetch();
        return $dates;
    }catch(PDOException $ex){
        echo "Error obtenir dates de fase a base de dades: ". $ex->getMessage();
    }

}

function obtenirDatesActuals(string $fase): bool{

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("select iniciActual , finalActual from fase where numero = ?");
        $stmt->execute([$fase]);
        return $stmt->fetchAll();
    }catch(PDOException $ex){
        echo "Error canviar final de fase a base de dades: ". $ex->getMessage();
    }

}

function obtenirFasePerData($date){

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("select nom from fase where iniciActual <= ? AND finalActual >= ?");
        $stmt->execute([$date , $date]);
        $fase = $stmt->fetch();
        if(!$fase)
            return false;
        else
            return $fase["nom"];
    }catch(PDOException $ex){
        echo "Error obtenir fase per data a base de dades: ". $ex->getMessage();
    }

}

function obtenirFases(){

    $dbh = getConnection();

    try{

        $stmt = $dbh->prepare("select * from fase");
        $stmt->execute();
        $fases = $stmt->fetchAll();
        $datesFases = [];

        foreach($fases as $values){
            $datesFases[$values["numero"]]["iniciActual"] = $values["iniciActual"] ;
            $datesFases[$values["numero"]]["finalActual"] = $values["finalActual"] ;
        }

        return $datesFases;

    }catch(PDOException $ex){
        echo "Error obtenir fase per data a base de dades: ". $ex->getMessage();
    }


}


/* Gestions taula fase_x_gos */


    function obtenirGossosXFase(string $fase){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("select gos,vots from fase_x_gos where fase = ?;");
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
    
            $stmt = $dbh->prepare("update fase_x_gos set vots = 0 where fase = ?;");
            $stmt->execute([$fase]);
            return true;
        }catch(PDOException $ex){
            echo "Error al borrar vots a base de dades: ". $ex->getMessage();
        }

    }

    function borrarTotsElsVots(){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("update fase_x_gos set vots = 0;");
            $stmt->execute();
            return true;
        }catch(PDOException $ex){
            echo "Error al borrar vots a base de dades: ". $ex->getMessage();
        }


    }


    function actualitzarVotsGos( string $fase , string $gos , int $vots){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("update fase_x_gos set vots = ? where fase = ? and gos = ?;");
            $stmt->execute([$vots , $fase , $gos]);
            return true;
        }catch(PDOException $ex){
            echo "Error al actualitzar vots a base de dades: ". $ex->getMessage();
        }

    }

    function obtenirVotsGos(string $fase , string $gos){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("select vots from fase_x_gos where fase = ? and gos = ?;");
            $stmt->execute([$fase , $gos]);
            $vots = $stmt->fetch();
            return $vots["vots"];
        }catch(PDOException $ex){
            echo "Error al obtenir vots a base de dades: ". $ex->getMessage();
        }


    }


/* Gestio taula usuaris*/


    function afegirUsuari(string $nom , string $passwd , string $tipus){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("insert into usuaris values (? , ? , ?)");
            $stmt->execute([$nom , hash("md5" , $passwd) , $tipus]);
            return true;
        }catch(PDOException $ex){
            echo "Error al afegir usuari a base de dades: ". $ex->getMessage();
        }
    }

    function obtenirUsuari(string $nom, string $passwd){
        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("select * from usuaris where nom = ? AND passwrd = ?;");
            $stmt->execute([$nom , hash('md5',$passwd)]);
            $usuari = $stmt->fetch();
            return (is_bool($usuari))?  false :  $usuari;
        }catch(PDOException $ex){
            echo "Error al obtenir usuari a base de dades: ". $ex->getMessage();
        }
        
    }


/* Gestio taula votacions usuari*/

    function obtenirVotUsuari($usuari , $fase){

        $dbh = getConnection();

        try{
    
            $stmt = $dbh->prepare("select gos from usuari_x_fase where usuari = ? AND fase = ?;");
            $stmt->execute([$usuari , $fase]);
            $gosVotat = $stmt->fetchAll();
            return $gosVotat;
        }catch(PDOException $ex){
            echo "Error al obtenir vot usuari a base de dades: ". $ex->getMessage();
        }

    
    }

    function canviarVotUsuari($usuari , $fase , $gos){

        $dbh = getConnection();

        try{
            $stmt = $dbh->prepare("update usuari_x_fase set gos = ? where fase = ? and usuari = ? ;");
            $stmt->execute([$gos , $fase, $usuari]);
            $gosVotat = $stmt->fetchAll();
            return $gosVotat;
        }catch(PDOException $ex){
            echo "Error al canviar vot a base de dades: ". $ex->getMessage();
        }
    }

    
    function nouVotUsuari($usuari , $fase , $gos){

        $dbh = getConnection();

        try{
            $stmt = $dbh->prepare("insert into usuari_x_fase values (? , ? , ?) ");
            $stmt->execute([$fase,$gos ,$usuari]);
            return true;
        }catch(PDOException $ex){
            echo "Error al afegir nou vot a base de dades: ". $ex->getMessage();
        }
    }

?>