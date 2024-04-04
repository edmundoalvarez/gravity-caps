<?php
    use App\Models\Compra;
    use App\Auth\Autenticacion;
    use App\Models\Usuario;
    use App\Models\Producto;

    session_start();

    require_once __DIR__ . "/../bootstrap/autoload.php";

    $compras = (new Compra())->todas();

    $productoId = $_POST['producto_id_vincular'];
    $producto = (new Producto)->buscarId($productoId);

    $usuarioId = $_POST['usuario_id_vincular'];
    $usuario = (new Usuario)->buscarId($usuarioId);

    foreach($compras as $compra){

        if($compra->getUsuarioFk() == $usuario->getUsuarioId()){
            $compraId = $compra->getCompraId();
        }
    }



    $productosEnCompra = $compra->getProductos();
    foreach ($productosEnCompra as $productoEnCompra):
        $productoEnCompraFk = $productoEnCompra->getProductoId();
    endforeach;

    $cantidad = 1;
    $precio = $producto->getPrecio();
    $subtotal = $precio * $cantidad;



    if(!(new Autenticacion)->estaAutenticado()){
        $_SESSION['mensajeError'] = 'Se requiere iniciar sesión para ver este contenido';
        header('Location: ../index.php?s=iniciar-sesion');
        exit;
    }

    try {
            (new Compra)->vincularProducto([
                'compra_fk'         =>$compraId,
                'producto_fk'       =>$productoId,
                'cantidad'          =>$cantidad,
                'precio'            =>$precio,
                'subtotal'          =>$subtotal

            ]);
            $_SESSION['mensajeExito'] = "El producto <b>" . $producto->getNombre() . "</b> se agregó con éxito.";
            header("Location: ../index.php?s=carrito&id=" . $usuarioId );
     

    } catch(Exception $e) {

        if( $producto->getProductoId() == $productoEnCompraFk){
            $_SESSION['mensajeError'] = 'Ocurrió un problema inesperado al tratar de agregar más productos. Probá de nuevo mas tarde. Si el problema persiste, comunicate con nosotros.' . $e->getMessage();
            $_SESSION['oldData'] = $_POST;    
            
            header("Location: ../index.php?s=producto-detalle&id=" . $productoId);

        }else {
            $_SESSION['mensajeError'] = "El producto <b>" . $producto->getNombre() . "</b> ya está agregado al carrito." . $e->getMessage();
            header("Location: ../index.php?s=producto-detalle&id=" . $productoId);
        }

        
        exit;

    } 
?>