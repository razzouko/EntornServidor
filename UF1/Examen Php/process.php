
<?php 
session_start();

$USERS_FILE = "users.json";
$CONNECTIONS_FILE = "connection.json";

// Tancar sessio si es prém el botó a la pàgina hola.php
if($_SERVER["REQUEST_METHOD"] == 'POST'){

    if(isset($_POST["tancaSessio"])){
        tancaSessio();
        header("Location: index.php");
    }
// Si es prém el botó de registre 
   if($_POST["method"] == 'signup'){
    $_SESSION["correuUsuari"] = $_POST["correuUsuari"];
    $_SESSION["nomUsuari"] = $_POST["nomUsuari"];
    $_SESSION["contrasenyaUsuari"] =$_POST["contrasenyaUsuari"];

    if(comprovarExistencia($USERS_FILE) === false && 
    $_SESSION["status"] == "usuari_incorrecte" &&
    $_POST["nomUsuari"] != ""){
        afegirUsuari($USERS_FILE);
        guardarLog();
        header("Location: hola.php");
    }else{
        $_SESSION["status"] = "creació-fallida";
        guardarLog();
        header("Location: index.php?errorRegistre=" . $_SESSION["status"]);
        tancaSessio();
    }
// Si es prém el botó d'inici de sessió
   }else if($_POST["method"] == 'signin'){
    $_SESSION["correuUsuari"] = $_POST["correuUsuari"];
    $dadesUsuari = comprovarExistencia($USERS_FILE);
    if($dadesUsuari === false){
        guardarLog();
        header("Location: index.php?errorInici=" . $_SESSION["status"]);
        tancaSessio();
    }else{
        $_SESSION["nomUsuari"] = $dadesUsuari["name"];
        guardarLog();
        header("Location: hola.php");
    };

   }
}


/**
 * Funció que tanca la sessió i elimina la cookie 'PHPSESSID'
 */
function tancaSessio(){
    session_unset();
    session_destroy();
    setcookie(session_name(),'',0,'/');
}

/**
 * Funció que guarda les accions d'accés a la pàgina dins el fitxer connection
 */
function guardarLog(){


    global $CONNECTIONS_FILE;
    $dadesConnexio = [];
    $dadesConnexio["ip"] = $_SERVER["REMOTE_ADDR"];
    $dadesConnexio["user"] = $_POST["correuUsuari"];
    $dadesConnexio["time"] = date("y-m-d h:i:s", time());
    $dadesConnexio["status"] = $_SESSION["status"];

    escriu($dadesConnexio ,$CONNECTIONS_FILE);

}


/**
 * Funció que afegeix les dades un usuari al fitxer que se l'hi passi
 * @param string $file fitxer on es guarden les dades dels usuaris
 */
function afegirUsuari(string $file) : void{

    $dadesUsuari["email"] = $_POST["correuUsuari"] ;
    $dadesUsuari["password"] = $_POST["contrasenyaUsuari"] ;
    $dadesUsuari["name"] = $_POST["nomUsuari"] ;
    $_SESSION["status"] = "nou_usuari";
    escriu($dadesUsuari, $file);
}

/**
 * Funció retorna l'existencia d'un usuari
 * @param string $file fitxer on es guarden les dades dels usuaris
 * @return boolean -> false si no s'ha trobat cap usuari correcte
 * @return array -> dades de l'usuari que coincideixen amb les dades entrades 
 */
function comprovarExistencia(string $file){

    $usuaris = llegeix($file);
    $dadesUsuari = [];
    $contrasenyaCorrecte = false;
    $correuCorrecte = false;
    foreach($usuaris as $correuUsuari => $valorsUsuari){
        if($_POST["correuUsuari"] == $correuUsuari){
            $correuCorrecte = true;
            if($valorsUsuari["password"] == $_POST["contrasenyaUsuari"]){
                $contrasenyaCorrecte = true;
                $dadesUsuari = $valorsUsuari;
            }
            break;
        }
    }

    if($correuCorrecte && $contrasenyaCorrecte){
        $_SESSION["status"] = "correcte";
        return $dadesUsuari;
    }else{          
        if(!$correuCorrecte){
            $_SESSION["status"] = "usuari_incorrecte";
            return false;
        }
        if(!$contrasenyaCorrecte){
            $_SESSION["status"] = "contrasenya_incorrecte";  
            return false;
        }
    }
    

}

/**
 * Funció que retorna les dades d'un usuari del fitxer  
 * @param string $file fitxer on hi han les dades dels usuaris
 * @return array -> de dades de l'usuari trobat
 */
function llegeix(string $file) : array | null
{
    $var = [];
    if ( file_exists($file) ) {
        $var = json_decode(file_get_contents($file), true);
    }
    return $var;
}

/**
 * Funció que escriu un array de dades en format json a l'arxiu definit
 * @param array $dades dades que es volen escriure en format json a l'arxiu definit
 * @param string $file fitxer on es guardaran les dades 
 */
function escriu(array $dades, string $file): void
{

    global $USERS_FILE;
    global $CONNECTIONS_FILE;
    $dadesArchiu = llegeix($file);
    if($dadesArchiu == null){
        $dadesArchiu = [];
    }

    if($file == $USERS_FILE){
        $dadesArchiu[$_POST["correuUsuari"]] = $dades;
        file_put_contents($file,json_encode($dadesArchiu, JSON_PRETTY_PRINT));
    }else if( $file == $CONNECTIONS_FILE ){
        $dadesArchiu[] = $dades;
        file_put_contents($file,json_encode($dadesArchiu, JSON_PRETTY_PRINT));
    }
    
}


?>