<?php 

use App\Auth\Autenticacion;
use App\Models\Producto;

session_start();

require_once __DIR__ . "/../../bootstrap/autoload.php";

if(!(new Autenticacion)->estaAutenticado()){
    $_SESSION['mensajeError'] = 'Se requiere iniciar sesión para ver este contenido';
    header('Location: ../index.php?s=iniciar-sesion');
    exit;
}

$id = $_GET['id'];
$producto = (new Producto)->buscarId($id);


if(!$producto) {
    $_SESSION['mensajeError'] = 'El producto que querías eliminar no existe' . $e->getMessage();
    header('Location: ../index.php?s=productos');
    exit;
}




try{
    (new Producto)->eliminar($id);

    if($producto->getImgGrande1() !== null){
        unlink(__DIR__ . '/../../styles/img/editadas/big-' . $producto->getImgGrande1());
        unlink(__DIR__ . '/../../styles/img/editadas/lit-' . $producto->getImgGrande1());
        unlink(__DIR__ . '/../../styles/img/editadas/med-' . $producto->getImgGrande1());
    }
    

    $_SESSION['mensajeExito'] = "El producto fue eliminado con éxito.";
    header('Location: ../index.php?s=productos');
    exit;

} catch(Exception $e){
    $_SESSION['mensajeError'] = 'Ocurrió un problema inesperado al tratar de eliminar el producto. Probá de nuevo mas tarde. Si el problema persiste, comunicate con nosotros.';
    header('Location: ../index.php?s=productos');
    exit;
}
