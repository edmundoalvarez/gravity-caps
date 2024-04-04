<?php
    use App\Auth\Autenticacion;
    use App\Models\Compra;
    use App\Models\Usuario;
    use App\Models\Historial;

    session_start();

    require_once __DIR__ . "/../bootstrap/autoload.php";

    
    $usuarioId = $_POST['usuario_id_vincular'];
    $usuario = (new Usuario)->buscarId($usuarioId);
    $compras = (new Compra())->todas();

    foreach($compras as $c){

        if($c->getUsuarioFk() == $usuario->getUsuarioId()){
            $compraId = $c->getCompraId();
        }
    }
    $compra = (new Compra)->buscarId($compraId);

 
    if($compraId == $compra->getCompraId()):
        $total = $compra->getTotal();
    endif;

   $fecha = date('YmdHis');

    if(!(new Autenticacion)->estaAutenticado()){
        $_SESSION['mensajeError'] = 'Se requiere iniciar sesión para ver este contenido';
        header('Location: ../index.php?s=iniciar-sesion');
        exit;
    }

    try {
        (new Historial)->agregarCompra([
            'usuario_fk'        =>$usuarioId,
            'fecha'             =>$fecha,
            'total'             =>$total
        ]);
        
        (new Compra)->vaciarProductosCompra($compraId);
        (new Compra)->vaciarCompra($compraId);
        (new Compra)->actualizarTotal($compraId);
        
        $_SESSION['mensajeExito'] = "<b>¡Felicitaciones!</b> la compra se realizó con éxito.";
        header("Location: ../index.php?s=mi-perfil&id=" . $usuarioId);


    } catch(Exception $e) {

        $_SESSION['mensajeError'] = 'Ocurrió un problema inesperado al tratar de agregar más productos. Probá de nuevo mas tarde. Si el problema persiste, comunicate con nosotros.' . $e->getMessage();
        $_SESSION['oldData'] = $_POST;    
        
        header("Location: ../index.php?s=carrito&id=" . $usuarioId);


        exit;

    } 
?>