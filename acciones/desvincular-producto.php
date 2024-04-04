<?php
    use App\Models\Compra;
    use App\Auth\Autenticacion;
    use App\Models\Usuario;

    session_start();

    require_once __DIR__ . "/../bootstrap/autoload.php";

    $compras = (new Compra())->todas();
    $productoId = $_POST['producto_id_desvincular'];
    $usuarioId = $_POST['usuario_id_desvincular'];
    $usuario = (new Usuario)->buscarId($usuarioId);


    if(!(new Autenticacion)->estaAutenticado()){
        $_SESSION['mensajeError'] = 'Se requiere iniciar sesión para ver este contenido';
        header('Location: ../index.php?s=iniciar-sesion');
        exit;
    }

    try {

        foreach($compras as $c){
            if($c->getUsuarioFk() == $usuario->getUsuarioId()){
                $compraId = $c->getCompraId();
                $compra = $c;
            
                if (isset($_POST['producto_id_desvincular']) && isset($_POST['usuario_id_desvincular'])) {

                    if(count($compra->getProductos()) > 1) {
                        $compra->desvincularProducto($productoId, $compraId);
                    } else {
                        $compra->desvincularProducto($productoId, $compraId);
                        $compra->vaciarCompra($compraId);
                    }
                    header("Location: ../index.php?s=carrito&id=" . $usuarioId );
                }
            }
        }
    

    } catch(Exception $e) {

        $_SESSION['mensajeError'] = 'Ocurrió un problema inesperado al tratar de agregar más productos. Probá de nuevo mas tarde. Si el problema persiste, comunicate con nosotros.' . $e->getMessage();
        $_SESSION['oldData'] = $_POST;    
        
        header("Location: ../index.php?s=carrito&id=" . $usuarioId);
        exit;

    } 
?>