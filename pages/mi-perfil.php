
<?php 
    use App\Models\Usuario;
    use App\Models\Historial;

    $a = new \NumberFormatter("it-IT", \NumberFormatter::CURRENCY);

    $usuario = (new Usuario)->buscarId($_GET['id']);
    $historiales = (new Historial())->todos();


    if(isset($_SESSION['mensajeError'])){
        $errores = $_SESSION['mensajeError'];
        unset($_SESSION['mensajeError']);
    } else {
        $errores = [];
    }



    

 ?>


<section class="mi-perfil">
    <h2>Mi Perfil</h2>

    <div>
        <div class="historial-compras">
            <h3>Historial de compras</h3>
            <?php 

            if(count($historiales) > 0){
            
            ?>
            <div class="tabla tabla-perfil">
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
            <?php 
            } else{
            ?>
            <div>
                <p>- No has hecho ninguna compra al momento -</p>
            </div>
            <?php } ?>
        </div>
        <div class="historial-compras">
            <h3>Datos personales</h3>
            <ul>
                <li><strong>Username</strong>: <?= $usuario->getUsername();  ?></li>
                <li><strong>email</strong>: <?= $usuario->getEmail();  ?></li>
                <li><strong>Cuit/Cuil</strong>: <?= $usuario->getCuitCuil();  ?></li>
            </ul>
        </div>
    </div>
</section>