<?php
const TAULA_CONNX = "connexions_usuaris";
const TAULA_USERS = "dades_usuaris";


function getConnection(){
    try{
        $hostname = "localhost";
        $dbname = "dwes_oussamarazzouk_autpdo";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $dbh = new PDO("mysql:host=$hostname;dbname=$dbname;" , "$username" , "$pw");
    } catch(PDOException $ex){
        echo "Error al fer la connexió amb la base de dades: ". $ex->getMessage();
        exit;
    }

    return $dbh;

}


function insertConn(array $dades , string $taula){

    $dbh = getConnection();

    try{
        $stmt = $dbh->prepare("insert into $taula values (? , ? , ? , ?)");
        $stmt->execute($dades);
        return true;
    }catch (PDOException $ex){
        echo "Error al fer l'inserció a base de dades: ". $ex->getMessage();
        return false;
    }

}

function insertUsr(array $dades , string $taula){

    $dbh = getConnection();
    $dades[1] = hash("md5" , $dades[1]);
    try{
        $stmt = $dbh->prepare("insert into $taula values (? , ? , ?)");
        $stmt->execute($dades);
        return true;
    }catch (PDOException $ex){
        echo "Error al fer l'inserció a base de dades: ". $ex->getMessage();
        return false;
    }

}


function getAllUsr(){

    $dbh = getConnection();
    try{
        $stmt = $dbh->prepare("select * from dades_usuaris");
        $stmt->execute();
        $valors = [];
        foreach ($stmt as $fila) {
            $email = $fila["email"];
            $pw = $fila["password"];
            $name = $fila["name"];
            $valors[$email] = ["email" => $email , "password" => $pw , "name"=> $name];
        }

        return $valors;

    }catch (PDOException $ex){
        echo "Error al buscar a la base de dades: ". $ex->getMessage();
    }
}

function getAllConn(){

    $dbh = getConnection();
    try{
        $stmt = $dbh->prepare("select * from connexions_usuaris");
        $stmt->execute();
        $valors = [];
        foreach ($stmt as $fila) {
            $ip = $fila["ip"];
            $user = $fila["user"];
            $time = $fila["time"];
            $status = $fila["status"];
            $valors[] = ["ip" => $ip , "user" => $user , "time"=> $time , "status" => $status];
        }

        return $valors;

    }catch (PDOException $ex){
        echo "Error al buscar a la base de dades: ". $ex->getMessage();
    }
}



/**
 * Llegeix les dades del fitxer. Si el document no existeix torna un array buit.
 *
 * @param string $file
 * @return array
 */
function llegeix(string $file) : array
{
    $var = [];
    if ( file_exists($file) ) {
        $var = json_decode(file_get_contents($file), true);
    }
    return $var;
}

/**
 * Guarda les dades a un fitxer
 *
 * @param array $dades
 * @param string $file
 */
function escriu(array $dades, string $file): void
{
    file_put_contents($file,json_encode($dades, JSON_PRETTY_PRINT));
}

/**
 * Mostra les connexions d'un usuari amb status success
 *
 * @param string $email
 * @return string
 */
function print_conns(string $email): string{
    $output = "";
    $data = getAllConn();

    foreach ($data as $fila){
        if($fila["user"] == $email && str_contains($fila["status"], "success"))
            $output .= "Connexió des de " . $fila["ip"] . " amb data " . $fila["time"]. "<br>\n";
    }

    return $output;
}
