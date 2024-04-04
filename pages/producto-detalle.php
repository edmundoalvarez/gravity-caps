<?php

    require_once __DIR__ . "/../bootstrap/autoload.php";    

    use App\Models\Producto;
    use App\Auth\Autenticacion;


    $p = (new Producto)->buscarId($_GET['id']);
    $a = new \NumberFormatter("it-IT", \NumberFormatter::CURRENCY);


    if((new Autenticacion)->estaAutenticado()){
        
        $u = (new Autenticacion)->getUsuario();
    }

?>

<section data-detalle="completa">
    <a href="index.php?s=productos" class="detalle-btn-volver">Volver</a>

    <article class="detalle-producto">
        <div class="detalle-producto-imagenes">

            <picture class="detalle-producto-img">
                <img src="<?= 'styles/img/editadas/big-' . $p->getImgGrande1();?>" alt="<?= $p->getImgAlt() ;?>">
            </picture>

            <div class="detalle-producto-miniaturas">
                <picture>
                    <img src="<?= 'styles/img/editadas/lit-' . $p->getImgGrande1();?>" alt="<?= $p->getImgAlt();?>">
                </picture>             
             
            </div>
        </div>
        <div class="detalle-producto-txt">
            <h2><?= $p->getNombre();?></h2>
            <p><?= $p->getDescripcion();?></p>
            <p>Precio de lista: <strong>$<span><?= $a->formatCurrency($p->getPrecio(), "ARS");?></span></strong></p>
            <div class="btn-productos">
                <a class="btn-producto-detalle" href="index.php?s=contacto">Consulta por mayor</a> 
                <form action="acciones/vincular-producto.php" method="post">
                        <input type="hidden" 
                            name="usuario_id_vincular"
                            id="usuario_id_vincular"
                            value="<?= $u->getUsuarioId() ;?>"
                        >
                        <input type="hidden" 
                            name="producto_id_vincular"
                            id="producto_id_vincular"
                            value="<?= $p->getProductoId() ;?>"
                        >
                    <button type="submit" class="btn-producto-compra">Agregar a Carrito</button>
                </form>
            </div>
        
        </div>
    </article>
</section>