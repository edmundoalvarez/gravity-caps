<?php 
    use App\Models\Producto;
    $productos = (new Producto)->todos();
    $a = new \NumberFormatter("it-IT", \NumberFormatter::CURRENCY);



?>

<section class="administracion-productos-completa">
    
    <h2>Administración de productos</h2>

    <div class="crear-producto">
        <a class="filtro-productos-todos" href="index.php?s=producto-crear">Crear producto</a>
    </div>

    <div class="tabla">
        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Estado</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Subcategoría</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($productos as $producto):
                ?>
                <tr class="tabla-admin-productos">
                    <td><?= $producto->getEstadoPublicacion()->getNombre() ; ?></td>
                    <td><?= $producto->getNombre() ; ?></td>
                    <td><?= $producto->getCategoria()->getNombre() ; ?></td>
                    <td><?= $producto->getSubcategoria()->getNombre() ; ?></td>
                    <td><img src="<?= '../styles/img/editadas/lit-' . $producto->getImgGrande1();?>" alt="<?= $producto->getImgAlt();?>"></td>
                    <td>$<?= $a->formatCurrency($producto->getPrecio(), "ARS");?></td>
                    <td><?= $producto->getStock() ; ?></td>
                    <td>
                        <div class="adm-acciones">
                            <a class="adm-editar" href="index.php?s=producto-editar&id=<?= $producto->getProductoId();?>">Editar</a>
                            <a class="adm-eliminar" href="index.php?s=producto-eliminar&id=<?= $producto->getProductoId();?>">Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php 
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</section>