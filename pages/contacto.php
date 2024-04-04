<?php

    require_once __DIR__ . "/../bootstrap/autoload.php";

    use App\Models\Producto;
    $productos = (new Producto)->todos();

?>
<section class="contacto-completa">
    <div class="contacto-intro">
        <h2>Consultanos por tu producto favorito</h2>
        <p>En el motivo de consulta podrás optar por uno de los productos en particular o bien por compra mayorista y sus respectivos precios.</p>
    </div>
    <form class="contacto-form" action="index.php?s=gracias" method="post" enctype="multipart/form-data">
        <div class="form-floating mb-3">
                <input type="text" name="nombre" placeholder="Nombre" class="form-control" id="nombre">
                <label  for="nombre">Nombre</label>
        </div>
        <div class="form-floating mb-3">
                <input type="text" name="apellido" placeholder="Apellido" class="form-control" id="apellido">
                <label  for="apellido">Apellido</label>
        </div>
        <div class="form-floating mb-3">
                <input type="text" name="empresa" placeholder="Empresa" class="form-control" id="empresa">
                <label  for="empresa">Empresa</label>
        </div>
        <div class="form-floating mb-3">
                <input type="text" name="email" placeholder="E-mail" class="form-control" id="email">
                <label  for="email">E-mail</label>
        </div>
        <div class="form-floating mb-3">
                <input type="text" name="telefono" placeholder="Teléfono" class="form-control" id="telefono">
                <label  for="telefono">Teléfono</label>
        </div>

        <div class="form-floating">
            <select class="form-select"  aria-label="Floating label select example" name="motivo-consulta" id="motivo-consulta">
                <option selected>Selecciona una opción</option>
                <?php 
                foreach($productos as $p):
                ?>
                <option value="<?= $p->getProductoId() ?>"><?= $p->getNombre() ?></option>
                <?php 
                endforeach;
                ?>
                <option value="mayorista">Compra mayorista</option>
            </select>
            <label for="motivo-consulta">Motivo de consulta</label>
        </div>
        <div data-form="textarea" class="form-floating">
            <textarea class="form-control" placeholder="Comentanos lo que buscás y cuantas unidades necesitas" name="descripcion-consulta" id="descripcion-consulta"></textarea>
            <label for="descripcion-consulta">Describinos lo que buscás</label>
        </div>
        <div class="contacto-form-btn">
            <button>Enviar</button>
        </div>

    </form>

</section>
