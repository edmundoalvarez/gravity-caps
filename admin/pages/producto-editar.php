<?php 
require_once __DIR__ . "/../../bootstrap/autoload.php";

use App\Models\Producto;
use \App\Models\EstadoPublicacion;
use \App\Models\Categoria;
use \App\Models\Subcategoria;
use \App\Models\Talle;
use \App\Models\Color;


$producto = (new Producto)->buscarId($_GET['id']);
$estadosPublicacion = (new EstadoPublicacion())->todos();
$categoria = (new Categoria())->todos();
$subcategoria = (new Subcategoria())->todos();
$talle = (new Talle())->todos();
$colores = (new Color())->todos();

if(isset($_SESSION['errores'])){
    $errores = $_SESSION['errores'];
    unset($_SESSION['errores']);
} else {
    $errores = [];
}

if(isset($_SESSION['oldData'])){
    $oldData = $_SESSION['oldData'];
    unset($_SESSION['oldData']);
} else {
    $oldData = [];
}

?>


<section class="crear-producto-completa">
    <a href="index.php?s=productos" class="detalle-btn-volver">Volver</a>
    <div>
        <h2>Editar producto</h2>
        <p class="form-text" >Los campos marcados con "*" son obligatorios.</p>
    </div>
    <div class="crear-producto-div-form">
        <form action="acciones/productos-editar.php?id=<?= $producto->getProductoId();?>" method="post" enctype="multipart/form-data">
            <div>
                <label for="nombre" class="form-label">Nombre de producto*</label>
                <input 
                    class="form-control" 
                    type="text" 
                    name="nombre" 
                    id="nombre" 
                    placeholder="Ingresar nombre de producto"
                    value="<?= $oldData['nombre'] ?? $producto->getNombre() ?>"
                    <?php if(isset($errores['nombre'])): ?> aria-describedby="error-nombre" <?php endif; ?>
                >
                <?php 
                if(isset($errores['nombre'])):
                ?>
                <div data-error="form">
                    <p id="error-nombre" class="form-text"><?= $errores['nombre'] ?></p>
                </div>
                <?php 
                endif;
                ?>
            </div>
            <div class="crear-producto-fk">
                <div>
                    <label for="categoria_fk" class="form-label">Categoria*</label>
                    <select 
                        class="form-select" 
                        name="categoria_fk" 
                        id="categoria_fk" 
                    >
                    <?php 
                    foreach($categoria as $c): 
                    ?>
                    <option 
                        value="<?= $c->getCategoriaId(); ?>" 
                        <?= $c->getCategoriaId() == ($oldData['categoria_fk'] ?? $producto->getCategoriaFk()) ? 'selected' : '';  ?>
                    > 
                        <?= $c->getNombre(); ?>
                    </option>
                    <?php 
                    endforeach;
                    ?>
                    </select>
                    <?php 
                    if(isset($errores['categoria_fk'])):
                    ?>
                        <div data-error="form">
                            <p id="error-categoria"  class="form-text"><?= $errores['categoria_fk'] ?></p>
                        </div>                
                    <?php 
                    endif;
                    ?>
                </div>
                <div>
                    <label for="subcategoria_fk" class="form-label">Subcategoria*</label>
                    <select 
                        class="form-select" 
                        name="subcategoria_fk" 
                        id="subcategoria_fk" 
                    >
                    <?php 
                    foreach($subcategoria as $sc): 
                    ?>
                    <option 
                        value="<?= $sc->getSubcategoriaId(); ?>" 
                        <?= $sc->getSubcategoriaId() == ($oldData['subcategoria_fk'] ?? $producto->getSubcategoriaFk()) ? 'selected' : '';  ?>
                    > 
                        <?= $sc->getNombre(); ?>
                    </option>
                    <?php 
                    endforeach;
                    ?>
                    </select>
                    <?php 
                    if(isset($errores['subcategoria_fk'])):
                    ?>
                        <div data-error="form">
                            <p id="error-subcategoria"  class="form-text"><?= $errores['subcategoria_fk'] ?></p>
                        </div>                
                    <?php 
                    endif;
                    ?>
                </div>
                <div>
                    <label for="talle_fk" class="form-label">Talle*</label>
                    <select 
                        class="form-select" 
                        name="talle_fk" 
                        id="talle_fk" 
                    >
                    <?php 
                    foreach($talle as $t): 
                    ?>
                    <option 
                        value="<?= $t->getTalleId(); ?>" 
                        <?= $t->getTalleId() == ($oldData['talle_fk'] ?? $producto->getTalleFk()) ? 'selected' : ''; ?>
                    > 
                        <?= $t->getNombre(); ?>
                    </option>
                    <?php 
                    endforeach;
                    ?>
                    </select>
                    <?php 
                    if(isset($errores['talle_fk'])):
                    ?>
                        <div data-error="form">
                            <p id="error-talle"  class="form-text"><?= $errores['talle_fk'] ?></p>
                        </div>                
                    <?php 
                    endif;
                    ?>
                </div>
            </div>
            <div class="adm-descripcion-colores">
                <div class="descripcion">
                    <label for="descripcion" class="form-label">Descripción de producto*</label>
                    <textarea 
                        class="form-control" 
                        name="descripcion" 
                        id="descripcion" 
                        placeholder="Ingresar descripción de producto"
                        <?php if(isset($errores['descripcion'])): ?> aria-describedby="error-descripcion" <?php endif; ?>
                    ><?= $oldData['descripcion'] ?? $producto->getDescripcion()  ?></textarea>
                    <?php 
                    if(isset($errores['descripcion'])):
                    ?>
                    <div data-error="form">
                        <p id="error-descripcion"  class="form-text"><?= $errores['descripcion'] ?></p>
                    </div>                
                    <?php 
                    endif;
                    ?>
                </div>
                <div class="colores">
                    <fieldset
                        <?php if(isset($errores['colores_fks'])): ?> aria-describedby="error-colores_fks" <?php endif; ?>
                    >
                        <legend>Colores*</legend>
                        <?php
                        foreach($colores as $color):
                        ?>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input
                                        type="checkbox"
                                        name="color_fk[]"
                                        value="<?= $color->getColorId();?>"
                                        class="form-check-input"
                                        <?php 
                                        foreach ($producto->getColores() as $c):
                                            if($color->getColorId() == $c->getColorId()) {
                                                echo 'checked';
                                            } else {
                                                echo '';
                                            };
                                        endforeach;
                                        ?>
                                        
                                    >
                                    <?= $color->getNombre();?>
                                </label>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </fieldset>
                    <?php 
                    if(isset($errores['colores_fks'])):
                    ?>
                    <div data-error="form">
                        <p id="error-colores_fks"  class="form-text"><?= $errores['colores_fks'] ?></p>
                    </div>                
                    <?php 
                    endif;
                    ?>
                </div>
            </div>
        
            <div class="img-grn">
                <div>
                    <p class="img-actual">Imagen grande actual</p>
                    <?php if($producto->getImgGrande1()): ?>
                        <picture>
                        <img src="<?= '../styles/img/editadas/big-' . $producto->getImgGrande1(); ?>" alt="<?=$producto->getImgAlt()?>">
                        </picture>
                    <?php else: ?>

                        <p>No existe una imagen</p>

                    <?php endif;  ?>
                </div> 
                <div>
                    <label for="imagen_grande_01" class="form-label">Cambiar imagen</label>
                    <input 
                    class="form-control" 
                    type="file" 
                    id="imagen_grande_01"
                    name="imagen_grande_01"
                    aria-describedby="help-imagen_grande_01"
                    >
                    <p class="form-text" id="help-imagen_grande_01">La imagen grande debe ser de 450 x 392 px.</p>
                </div>
            </div>
            <div>
                <label for="imagen_descripcion" class="form-label">Descripción de imagen*</label>
                <input 
                    class="form-control" 
                    type="text" 
                    name="imagen_descripcion" 
                    id="imagen_descripcion" 
                    placeholder="Ingresar descripción de imagen"
                    value="<?= $oldData['imagen_descripcion'] ?? $producto->getImgAlt()  ?>"
                    <?php if(isset($errores['imagen_descripcion'])): ?> aria-describedby="error-imagen_descripcion" <?php endif; ?>

                >
                <?php 
                if(isset($errores['imagen_descripcion'])):
                ?>
                <div data-error="form">
                    <p id="error-imagen_descripcion"  class="form-text" ><?= $errores['imagen_descripcion'] ?></p>
                </div>                
                <?php 
                endif;
                ?>
            </div>
            
            <div class="crear-producto-num">
                <div>
                    <label for="precio" class="form-label">Precio de producto*</label>
                    <input 
                        class="form-control" 
                        type="number" 
                        name="precio" 
                        id="precio" 
                        step="any"
                        placeholder="Ingresar precio de producto"
                        value="<?= $oldData['precio'] ?? number_format((float)$producto->getPrecio(), 2, '.', '');  ?>"


                        <?php if(isset($errores['precio'])): ?> aria-describedby="error-precio" <?php endif; ?>

                    >
                    <?php 
                    if(isset($errores['precio'])):
                    ?>
                    <div data-error="form">
                        <p id="error-precio"  class="form-text" ><?= $errores['precio'] ?></p>
                    </div> 
                    <?php 
                    endif;
                    ?> 
                </div>
                <div>
                    <label for="stock" class="form-label">Stock de producto*</label>
                    <input 
                        class="form-control" 
                        type="number" 
                        name="stock" 
                        id="stock" 
                        placeholder="Ingresar stock de producto"
                        value="<?= $oldData['stock'] ?? $producto->getStock()?>"
                        <?php if(isset($errores['stock'])): ?> aria-describedby="error-stock" <?php endif; ?>

                    >
                    <?php 
                    if(isset($errores['stock'])):
                    ?>
                    <div data-error="form">
                        <p id="error-stock"  class="form-text" ><?= $errores['stock'] ?></p>
                    </div>                     
                    <?php 
                    endif;
                    ?>
                </div>
            </div>
            <div>
                <label for="estado_publicacion_fk" class="form-label">Estado de publicación*</label>
                <select 
                    class="form-select" 
                    name="estado_publicacion_fk" 
                    id="estado_publicacion_fk" 
                >
                <?php 
                foreach($estadosPublicacion as $estado): 
                ?>
                <option 
                    value="<?= $estado->getEstadoPublicacionId(); ?>" 
                    <?= $estado->getEstadoPublicacionId() == ($oldData['estado_publicacion_fk'] ?? $producto->getEstadoPublicacionFk()) ? 'selected' : ''; ?>
                > 
                    <?= $estado->getNombre(); ?>
                </option>
                <?php 
                endforeach;
                ?>
                </select>
                <?php 
                if(isset($errores['estado_publicacion_fk'])):
                ?>
                    <div data-error="form">
                        <p id="error-estado-publicacion"  class="form-text"><?= $errores['estado_publicacion_fk'] ?></p>
                    </div>                
                <?php 
                endif;
                ?>
            </div>
            <div>
                <button class="btn-crear-producto" type="submit">Actualizar producto</button>
            </div>

        </form>
    </div>
</section>