<?php 

    require_once __DIR__ . "/../bootstrap/autoload.php";

    use App\Models\Subcategoria;

    $subcategoria = (new Subcategoria())->todos();

?>

<section class="portada">
    <article class="home-general">
            <div class="home-txt">
                <h2>¡Bienvenidos a Gravity Caps!</h2>
                <p>En Gravity nos encargamos de confeccionar cada producto individualmente para alcanzar la calidad que buscamos. Además, no solo ofrecemos nuestros modelos de gorras al por menor sino también le damos la posibilidad a nuestros clientes de que puedan representarnos y vender nuestros productos.</p>
            </div>
    </article>
</section>


<section class="generos">
    <div class="generos-titulo">
        <h2>¡Buscá la que más te guste!</h2>
    </div>
    <ul class="generos-items">
        <?php foreach($subcategoria as $s):  ?>
        <li>
            <a href="index.php?s=productos-genero&g=<?= $s->getSubcategoriaId(); ?>" id="<?= $s->getNombre() == "Trucker Premium" ? 'Trucker' : $s->getNombre(); ?>"><?= $s->getNombre(); ?></a>
        </li>
        <?php endforeach ?>
    </ul>
</section>

<section class="home-consulta">
    <div>
        <h2>¿Querés vender nuestros productos?</h2>
        <div>
            <p>Consultá por precios mayoristas</p>
            <a href="index.php?s=contacto">Contacto</a>
        </div>
    </div>
</section>