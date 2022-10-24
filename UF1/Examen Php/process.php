
<?php 
session_start();

$USERS_FILE = "users.json";
$CONNECTIONS_FILE = "connections.json";

if($_SERVER["REQUEST_METHOD"] == 'POST'){

    if(isset($_POST["tancaSessio"])){
        session_destroy();
        header("Location: index.php");
    }

   if($_POST["method"] == 'signup'){

    if(comprovarExistencia($USERS_FILE) === false){
        afegirUsuari($USERS_FILE);
        $_SESSION["nomUsuari"] = $_POST["nomUsuari"];
        $_SESSION["correuUsuari"] = $_POST["correuUsuari"];
        $_SESSION["contrasenyaUsuari"] =$_POST["contrasenyaUsuari"];
        $_SESSION["status"] = "correcte";
        header("Location: hola.php");
    }else{
        echo "ja existeix";
    } 
   }else if($_POST["method"] == 'signin'){
    $dadesUsuari = comprovarExistencia($USERS_FILE);
    if($dadesUsuari === false){
        echo "es incorrecte";
        header("Location: index.php");
    }else{
        $_SESSION["nomUsuari"] = $dadesUsuari["name"];
        $_SESSION["correuUsuari"] = $dadesUsuari["email"];
        $_SESSION["contrasenyaUsuari"] = $dadesUsuari["password"];
        header("Location: hola.php?nom=" . $dadesUsuari["name"]);
    };

   }
}


function afegirUsuari(string $file) : void{

    $dadesUsuari["email"] = $_POST["correuUsuari"] ;
    $dadesUsuari["password"] = $_POST["contrasenyaUsuari"] ;
    $dadesUsuari["name"] = $_POST["nomUsuari"] ;

    escriu($dadesUsuari, $file);
}

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
        if(!$correuCorrecte)
            $_SESSION["status"] = "usuari_incorrecte";
        if(!$contrasenyaCorrecte)
            $_SESSION["status"] = "contrasenya_incorrecte";  
        return $dadesUsuari;
    }else    
        return false;
    

}


function llegeix(string $file) : array
{
    $var = [];
    if ( file_exists($file) ) {
        $var = json_decode(file_get_contents($file), true);
    }
    return $var;
}

function escriu(array $dades, string $file): void
{
    $dadesArchiu = llegeix($file);
    $dadesArchiu[$_POST["correuUsuari"]] = $dades;
    file_put_contents($file,json_encode($dadesArchiu, JSON_PRETTY_PRINT));
}







?>