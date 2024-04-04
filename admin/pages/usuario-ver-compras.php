
<?php 
    use App\Models\Usuario;
    use App\Models\Historial;

    $a = new \NumberFormatter("it-IT", \NumberFormatter::CURRENCY);

    $usuario = (new Usuario)->buscarId($_GET['id']);
    $historiales = (new Historial())->todos();

    

 ?>


<section class="administracion-productos-completa">
    <a href="index.php?s=usuarios" class="detalle-btn-volver compras-btn-volver">Volver</a>

    <h2>Compras realizadas por el usuario</h2>

    <div class="historial-compras">
        <div class="tabla">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Compra ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                
                <?php 
                    foreach($historiales as $historial):
                    if($usuario->getUsuarioId() == $historial->getUsuarioFk()): 
                    ?>
                    <tr class="tabla-admin-productos">
                        <td><?= $historial->getHistorialId() ?></td>
                        <td><?= $historial->getFecha() ?></td>
                        <td>$ <span><?= $a->formatCurrency($historial->getTotal(), "ARS"); ?></span></td>
                    </tr>
                <?php 
                    endif;
                    endforeach; 
                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>