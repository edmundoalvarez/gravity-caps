<?php

    require_once __DIR__ . "/../../bootstrap/autoload.php";

    use App\Models\Producto;

    $producto = (new Producto)->buscarId($_GET['id']);
    $a = new \NumberFormatter("it-IT", \NumberFormatter::CURRENCY);


?>
<section data-detalle="completa">
    <a href="index.php?s=productos" class="detalle-btn-volver">Volver</a>

    <div class="eliminar-producto-title">
        <h2>Se requiere confirmación para eliminar</h2>
        <p>Estas por eliminar este producto por lo que necesitamos que confirmes la acción.</p>
    </div>

    <article class="detalle-producto">
        <div class="detalle-producto-imagenes">

            <picture class="detalle-producto-img">
                <img src="<?= '../styles/img/editadas/big-' . $producto->getImgGrande1();?>" alt="<?= $producto->getImgAlt() ;?>">
            </picture>

            <div class="detalle-producto-miniaturas">
                <picture>
                    <img src="<?= '../styles/img/editadas/lit-' . $producto->getImgGrande1();?>" alt="<?= $producto->getImgAlt();?>">
                </picture>             
             
            </div>
        </div>
        <div class="detalle-producto-txt">
            <h3><?= $producto->getNombre();?></h3>
            <p><?= $producto->getDescripcion();?></p>
            <p>Precio de lista: <strong>$<span><?= $a->formatCurrency($producto->getPrecio(), "ARS");?></span></strong></p>
            <form action="acciones/productos-eliminar.php?id=<?= $producto->getProductoId();?>" method="post">
                <button class="btn-producto-detalle" data-btn="eliminar" type="submit">Eliminar</button>
            </form>
        </div>
    </article>
</section>