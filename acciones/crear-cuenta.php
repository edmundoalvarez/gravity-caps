<?php 
use App\Models\Usuario;

session_start();

require_once __DIR__ . "/../bootstrap/autoload.php";


$rol_fk                 = $_POST['rol_fk'];
$username               = $_POST['username'];
$email                  = $_POST['email'];
$telefono               = $_POST['telefono'];
$empresa                = $_POST['empresa'];
$cuit_cuil              = $_POST['cuit_cuil'];
$password               = $_POST['password'];
$password_validate      = $_POST['password_validate'];


$pass_hash = password_hash($password , PASSWORD_DEFAULT);

$errores = [];
if(empty($username)){
    $errores['username'] = "El usuario debe tener un username";
}
if(empty($email)){
    $errores['email'] = "El usuario debe tener un email.";
}
if(empty($cuit_cuil)){
    $errores['cuit_cuil'] = "El usuario debe tener un Cuit/Cuil.";
}
if(empty($password)){
    $errores['password'] = "El usuario debe tener una contraseña.";
}
if ($password != $password_validate){
    $errores['password_validate'] = "Las contraseñas deben coincidir.";
};



if(count($errores) > 0){

    $_SESSION['errores'] = $errores;

    $_SESSION['oldData'] = $_POST;

    header("Location: ../index.php?s=crear-cuenta");
    exit;
}


try {
    (new Usuario)->crear([
        'rol_fk'        =>$rol_fk,
        'username'      =>$username,
        'email'         =>$email,
        'telefono'      =>$telefono,
        'empresa'       =>$empresa,
        'cuit_cuil'     =>$cuit_cuil,
        'password'      =>$pass_hash,

    ]);
    
    $_SESSION['mensajeExito'] = "El usuario <b>" . $username . "</b> fue creado con éxito.";
    header("Location: ../index.php?s=iniciar-sesion");
    exit;

} catch(Exception $e) {


    $_SESSION['mensajeError'] = 'Ocurrió un problema inesperado al tratar de crear el usuario. Probá de nuevo mas tarde. Si el problema persiste, comunicate con nosotros.' . $e->getMessage();
    $_SESSION['oldData'] = $_POST;    
    
    header("Location: ../index.php?s=crear-cuenta");
    exit;

} 