
<?php 
use App\Models\Usuario;
use App\Models\Compra;
use App\Models\Producto;

if(isset($_SESSION['mensajeError'])){
    $errores = $_SESSION['mensajeError'];
    unset($_SESSION['mensajeError']);
} else {
    $errores = [];
}

if(isset($_SESSION['oldData'])){
    $oldData = $_SESSION['oldData'];
    unset($_SESSION['oldData']);
} else {
    $oldData = [];
}

$a = new \NumberFormatter("it-IT", \NumberFormatter::CURRENCY);

$usuario = (new Usuario)->buscarId($_GET['id']);
$compras = (new Compra)->todasConGroupBy();
$productos = (new Producto())->todos();

foreach($compras as $c):
    if($usuario->getUsuarioId() == $c->getUsuarioFk()):
        $compra = $c;

    endif;
endforeach;



?>


<section class="carrito-completa">

    <h2>Carrito de compras</h2>
    

    <?php if(count($compras) > 0){ ?>
    <div class="carrito-con-productos">
        <div class="tabla">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($compras as $compra):
                            if($compra->getUsuarioFk() == $usuario->getUsuarioId()):
                            foreach ($compra->getProductos() as $compraProducto):
                    ?>
                
                    <tr class="tabla-admin-productos">
                        <td><?= $compraProducto->getNombre() ?></td>
                        <td><img src="<?= 'styles/img/editadas/lit-' . $compraProducto->getImgGrande1();?>" alt="<?= $compraProducto->getImgAlt();?>"></td>
                        <td class="cantidad-producto">
                            <div>
                                <?php 
                                    foreach($productos as $producto): 
                                        if($producto->getProductoId() == $compraProducto->getProductoId()):
                                ?>
                                <form action="acciones/agregar-a-carrito.php" method="post" class="btn-sumar-producto" >
                                        <input type="hidden" 
                                            name="usuario_id_sumar"
                                            value="<?= $usuario->getUsuarioId() ?>"
                                        >
                                    <label for="producto_id_sumar=<?= $compraProducto->getProductoId()?>">
                                        <input 
                                            type="submit" 
                                            name="producto_id_sumar"
                                            value="<?= $compraProducto->getProductoId() ?>"
                                            class="btn-sumar-producto"
                                            id="producto_id_sumar=<?= $compraProducto->getProductoId()?>"
                                        >
                                    </label>
                                </form>
                                <span class="cantidad"><?= $compraProducto->getCantidad() ?></span> 
                                <form action="acciones/restar-a-carrito.php" method="post" class="btn-restar-producto">
                                        <input type="hidden" 
                                            name="usuario_id_restar"
                                            value="<?= $usuario->getUsuarioId() ?>"
                                        >
                                    <label for="producto_id_restar=<?= $compraProducto->getProductoId()?>">
                                        <input 
                                            type="submit" 
                                            name="producto_id_restar"
                                            id="producto_id_restar=<?= $compraProducto->getProductoId()?>"
                                            value="<?= $compraProducto->getProductoId() ?>"
                                            class="btn-restar-producto"
                                        >
                                    </label>
                                </form>                            
                                <?php 
                                endif; 
                                endforeach; 
                                ?>
                            </div>
                            
                        </td>
                        <td>$ <span><?= $a->formatCurrency($compraProducto->getSubtotal(), "ARS"); ?></span></td>
                        <td>
                            <form action="acciones/desvincular-producto.php" method="post" class="btn-eliminar-carrito">
                                    <input type="hidden" 
                                        name="usuario_id_desvincular"
                                        id="usuario_id_desvincular=<?= $compraProducto->getProductoId() ?>"
                                        value="<?= $usuario->getUsuarioId() ?>"
                                    >
                                <label for="producto_id_desvincular=<?= $compraProducto->getProductoId() ?>">
                                    <input 
                                        type="submit" 
                                        name="producto_id_desvincular"
                                        id="producto_id_desvincular=<?= $compraProducto->getProductoId() ?>"
                                        value="<?= $compraProducto->getProductoId() ?>"
                                        class="btn-eliminar-carrito"
                                    >
                                </label>
                            </form> 
                            <!-- <button class="btn-eliminar-carrito">Eliminar</button> -->
                        </td>
                    </tr>
                    <?php 
                        endforeach;
                    ?>
                </tbody>
            </table>
        </div>
        <div class="resumen">
            <div class="total-carrito">
                <div>
                    <p>Total:</p>
                    <p>$ <span><?=  $a->formatCurrency($compra->getTotal() , "ARS");?></span></p>
                </div>
            </div>
            <div class="finalizar-carrito">
                <form action="acciones/agregar-compra-historial.php" method="post">
                        <input type="hidden" 
                            name="usuario_id_vincular"
                            id="usuario_id_vincular"
                            value="<?= $usuario->getUsuarioId() ?>"
                        >
                        <input 
                            type="hidden" 
                            name="compra_id_vincular"
                            id="compra_id_vincular"
                            value="<?= $compra->getCompraId() ?>"
                            
                        >
                    <button type="submit" class="btn-finalizar-compra">Confirmar Compra</button>
                </form> 
            </div>
        </div>
    </div>
        <?php 
        endif;
        endforeach;
        ?>
    <?php }else { ?>
    <div class="carrito-vacio">
        <p>- El carrito está vacio -</p>
    </div>
    <?php }?>

</section>