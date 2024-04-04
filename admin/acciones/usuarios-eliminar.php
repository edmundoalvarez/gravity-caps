<?php 

use App\Auth\Autenticacion;
use App\Models\Usuario;

session_start();

require_once __DIR__ . "/../../bootstrap/autoload.php";

if(!(new Autenticacion)->estaAutenticado()){
    $_SESSION['mensajeError'] = 'Se requiere iniciar sesión para ver este contenido';
    header('Location: ../index.php?s=iniciar-sesion');
    exit;
}

$id = $_GET['id'];
$usuario = (new Usuario)->buscarId($id);


if(!$usuario) {
    $_SESSION['mensajeError'] = 'El usuario que querías eliminar no existe' . $e->getMessage();
    header('Location: ../index.php?s=usuarios');
    exit;
}




try{
    (new Usuario)->eliminar($id);
    
    $_SESSION['mensajeExito'] = "El usuario fue eliminado con éxito.";
    header('Location: ../index.php?s=usuarios');
    exit;

} catch(Exception $e){
    $_SESSION['mensajeError'] = 'Ocurrió un problema inesperado al tratar de eliminar el producto. Probá de nuevo mas tarde. Si el problema persiste, comunicate con nosotros.' . $e;
    header('Location: ../index.php?s=usuarios');
    exit;
}
