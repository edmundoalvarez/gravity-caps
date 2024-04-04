<?php 
    use App\Models\Usuario;
    $usuarios = (new Usuario)->todos();
    

 ?>

<section class="administracion-productos-completa">
    <h2>Administración de usuarios</h2>
    <div class="crear-producto">
        <a class="filtro-productos-todos" href="index.php?s=usuario-crear">Crear usuario</a>
    </div>


    <div class="tabla tabla-usuarios">
        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Rol</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Cuit/Cuil</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($usuarios as $usuario):
                ?>
                <tr class="tabla-admin-productos">
                    <td><?= $usuario->getRol()->getNombre() ; ?></td>
                    <td><?= $usuario->getUsername() ; ?></td>
                    <td><?= $usuario->getEmail() ; ?></td>
                    <td><?= $usuario->getTelefono(); ?></td>
                    <td><?= $usuario->getEmpresa(); ?></td>
                    <td><?= $usuario->getCuitCuil(); ?></td>
                    <?php if($usuario->getRol()->getRolId() != 1){ ?>
                    <td>
                        <div class="adm-acciones">
                            <a class="adm-eliminar" href="index.php?s=usuario-eliminar&id=<?= $usuario->getUsuarioId();?>">Eliminar</a>
                        </div>
                        <div class="adm-acciones">
                            <a class="adm-editar" href="index.php?s=usuario-ver-compras&id=<?= $usuario->getUsuarioId();?>">Ver Compras</a>
                        </div>
                    
                    </td>
                    <?php } else { ?>
                        <td>No eliminar</td>
                    <?php } ?>
                </tr>
                <?php 
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</section>