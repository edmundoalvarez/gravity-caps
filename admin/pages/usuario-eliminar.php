<?php

    require_once __DIR__ . "/../../bootstrap/autoload.php";

    use App\Models\Usuario;
    use App\Models\Rol;

    $usuario = (new Usuario)->buscarId($_GET['id']);
    $roles = (new Rol())->todos();

    foreach($roles as $rol):
        if($rol->getRolId() == $usuario->getRolFk()){
            $nombreRol = $rol->getNombre();
        }

    endforeach;    
?>
<section data-detalle="completa">
    <a href="index.php?s=usuarios" class="detalle-btn-volver">Volver</a>

    <div class="eliminar-producto-title">
        <h2>Se requiere confirmación para eliminar</h2>
        <p>Estas por eliminar este usuario por lo que necesitamos que confirmes la acción.</p>
    </div>

    <article class="detalle-usuario">
        <div class="detalle-usuario-txt">
            <p class="atencion-eliminar">¡Atención!</p>
            <p>¿Estas seguro que deseas eliminar a <span class="username-eliminar"> <?= $usuario->getUsername();?></span> (<?= $nombreRol;?>)?</p>
        </div>
        <form action="acciones/usuarios-eliminar.php?id=<?= $usuario->getUsuarioId();?>" method="post">
            <button class="btn-producto-detalle btn-usuario-eliminar" data-btn="eliminar" type="submit">Eliminar</button>
        </form>
    </article>
</section>