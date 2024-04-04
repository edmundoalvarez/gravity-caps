<?php
    use App\Models\Compra;
    use App\Auth\Autenticacion;
    use App\Models\Usuario;

    session_start();

    require_once __DIR__ . "/../bootstrap/autoload.php";

    $compras = (new Compra())->todas();
    $productoId = $_POST['producto_id_restar'];
    $usuarioId = $_POST['usuario_id_restar'];
    $usuario = (new Usuario)->buscarId($usuarioId);
    
    foreach($compras as $compra){

        if($compra->getUsuarioFk() == $usuario->getUsuarioId()){
            $compraId = $compra->getCompraId();
        }
    }


    if(!(new Autenticacion)->estaAutenticado()){
        $_SESSION['mensajeError'] = 'Se requiere iniciar sesión para ver este contenido';
        header('Location: ../index.php?s=iniciar-sesion');
        exit;
    }

    try {

        if (isset($_POST['producto_id_restar']) && isset ($_POST['usuario_id_restar'])) {
            $compra->restarProductos($productoId, $compraId);
            header("Location: ../index.php?s=carrito&id=" . $usuarioId );
        }

    } catch(Exception $e) {

        $_SESSION['mensajeError'] = 'Ocurrió un problema inesperado al tratar de agregar más productos. Probá de nuevo mas tarde. Si el problema persiste, comunicate con nosotros.' . $e->getMessage();
        $_SESSION['oldData'] = $_POST;    
        
        header("Location: ../index.php?s=carrito&id=" . $usuarioId);
        exit;

    } 
?>