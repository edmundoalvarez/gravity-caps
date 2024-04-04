<?php 

    require_once __DIR__ . "/../bootstrap/autoload.php";

    $busqueda = [

        ['estado_publicacion_fk', '=', 2],

    ];

    if(!empty($_GET['nombre'])){
        $busqueda[] = ['p.nombre', 'LIKE', '%' .  $_GET['nombre'] . '%'];
    }

    use App\Models\Producto;
    use App\Models\Subcategoria;

    $productos = (new Producto)->buscarGenero($_GET['g']);
    $subcategoria = (new Subcategoria())->todos();
    $a = new \NumberFormatter("it-IT", \NumberFormatter::CURRENCY);



    $g = $_GET['g'];

?>

<section class="productos-completa">

    <div data-productos="titulo">
        <h2>Nuestros productos</h2>
    </div>

    <div>
        <form action="index.php" method="get" class="buscador">
            <h3>Buscador:</h3>
            <input type="hidden" name="s" value="productos">
            <div class="form-fila">
                <label for="nombre" class="label-nombre"></label>
                <input 
                type="search" 
                id="nombre" 
                name="nombre" 
                class="form-control"
                value="<?= $_GET['nombre'] ?? null;?>"
                >
            </div>
            <button type="submit" class="filtro-productos-todos">Buscar</button>
        </form>
    </div>

    <div class="productos-filtro">
        <h3>Filtros:</h3>
        <a href="index.php?s=productos" class="filtro-productos-todos">Ver todos</a>
        <?php foreach($subcategoria as $s): ?>
            <a href="index.php?s=productos-genero&g=<?= $s->getSubcategoriaId(); ?>" class="filtro-productos-todos" <?php if($g == $s->getSubcategoriaId()) { ?> data-productos="filtro-seleccionado" <?php } ;?>> <?= $s->getNombre()  ?> </a>
        <?php endforeach; ?>
    </div>

    <div class="productos-lista-completa">
    <?php  
        
        foreach($productos as $p):
    ?>
        <a href="index.php?s=producto-detalle&id=<?= $p->getProductoId()?>">
            <article class="productos-producto">
                <div class="producto-imagen">
                    <picture>
                        <img src="<?= 'styles/img/editadas/med-' . $p->getImgGrande1();?>" alt="<?= $p->getImgAlt();?>">
                    </picture>
                </div>
                <div class="producto-texto">  
                    <h3><?= $p->getNombre() ; ?></h3>
                    <p>$<span><?= $a->formatCurrency($p->getPrecio(), "ARS"); ?></span></p>
                </div>
            </article>
        </a>
    <?php
        endforeach;
    ?>
    </div>

</section>