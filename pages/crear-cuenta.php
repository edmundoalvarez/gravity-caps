<?php 

use \App\Models\Rol;
use \App\Models\Compra;


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

$roles = (new Rol())->todos();
$carrito = (new Compra())->todas();

?>

<section class="crear-producto-completa">
    <a href="index.php?s=usuarios" class="detalle-btn-volver">Volver</a>

    <div>
        <h2>Crear usuario</h2>
        <p class="form-text" >Los campos marcados con "*" son obligatorios.</p>
    </div>
    <div class="crear-producto-div-form">
        <form action="acciones/crear-cuenta.php" method="post" enctype="multipart/form-data">
            <div class="crear-producto-fk">
                <div>
                    <label for="username" class="form-label">Username*</label>
                    <input 
                        class="form-control" 
                        type="text" 
                        name="username" 
                        id="username" 
                        placeholder="Ingresar el username del usuario"
                        value="<?= $oldData['username'] ?? null ?>"
                        <?php if(isset($errores['username'])): ?> aria-describedby="error-username" <?php endif; ?>
                    >
                    <?php 
                    if(isset($errores['username'])):
                    ?>
                    <div data-error="form">
                        <p id="error-username" class="form-text"> <?= $errores['username'] ?> </p>
                    </div>
                    <?php 
                    endif;
                    ?>
                </div>
                <div>
                    <label for="email" class="form-label">Email*</label>
                    <input 
                        class="form-control" 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="Ingresar el email del usuario"
                        value="<?= $oldData['email'] ?? null ?>"
                        <?php if(isset($errores['email'])): ?> aria-describedby="error-email" <?php endif; ?>
                    >
                    <?php 
                    if(isset($errores['email'])):
                    ?>
                    <div data-error="form">
                        <p id="error-email" class="form-text"> <?= $errores['email'] ?> </p>
                    </div>
                    <?php 
                    endif;
                    ?>
                </div>
                <div>
                    <input 
                        type="hidden" 
                        name="rol_fk" 
                        id="rol_fk" 
                        value="2"
                    >
                </div>
                

            </div>
            <div class="crear-producto-fk">
                <div>
                    <label for="password" class="form-label">Contraseña*</label>
                    <input 
                        class="form-control" 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="Ingresar una contraseña "
                        value="<?= $oldData['password'] ?? null ?>"
                        <?php if(isset($errores['password'])): ?> aria-describedby="error-password" <?php endif; ?>
                    >
                    <?php 
                    if(isset($errores['password'])):
                    ?>
                    <div data-error="form">
                        <p id="error-password" class="form-text"> <?= $errores['password'] ?> </p>
                    </div>
                    <?php 
                    endif;
                    ?>
                </div>
                <div>
                    <label for="password_validate" class="form-label">Repetir contraseña*</label>
                    <input 
                        class="form-control" 
                        type="password" 
                        name="password_validate" 
                        id="password_validate" 
                        placeholder="Ingresar nuevamente la contraseña"
                        value="<?= $oldData['password_validate'] ?? null ?>"
                        <?php if(isset($errores['password_validate'])): ?> aria-describedby="error-password_validate" <?php endif; ?>
                    >
                    <?php 
                    if(isset($errores['password_validate'])):
                    ?>
                    <div data-error="form">
                        <p id="error-password_validate" class="form-text"> <?= $errores['password_validate'] ?> </p>
                    </div>
                    <?php 
                    endif;
                    ?>
                </div>
            </div>
            <div class="crear-producto-fk">
                <div>
                    <label for="telefono" class="form-label">Telefono</label>
                    <input 
                        class="form-control" 
                        type="number" 
                        name="telefono" 
                        id="telefono" 
                        placeholder="Ingresar el telefono del usuario"
                        value="<?= $oldData['telefono'] ?? null ?>"
                        <?php if(isset($errores['telefono'])): ?> aria-describedby="error-telefono" <?php endif; ?>
                    >
                    <?php 
                    if(isset($errores['telefono'])):
                    ?>
                    <div data-error="form">
                        <p id="error-telefono" class="form-text"> <?= $errores['telefono'] ?> </p>
                    </div>
                    <?php 
                    endif;
                    ?>
                </div>
                <div>
                    <label for="empresa" class="form-label">Empresa</label>
                    <input 
                        class="form-control" 
                        type="text" 
                        name="empresa" 
                        id="empresa" 
                        placeholder="Ingresar nombre de su empersa"
                        value="<?= $oldData['empresa'] ?? null ?>"
                        <?php if(isset($errores['empresa'])): ?> aria-describedby="error-empresa" <?php endif; ?>
                    >
                    <?php 
                    if(isset($errores['empresa'])):
                    ?>
                    <div data-error="form">
                        <p id="error-empresa" class="form-text"> <?= $errores['empresa'] ?> </p>
                    </div>
                    <?php 
                    endif;
                    ?>
                </div>
                <div>
                    <label for="cuit_cuil" class="form-label">Cuit/Cuil*</label>
                    <input 
                        class="form-control" 
                        type="number" 
                        name="cuit_cuil" 
                        id="cuit_cuil" 
                        placeholder="Ingresar su cuit/cuil"
                        value="<?= $oldData['cuit_cuil'] ?? null ?>"
                        <?php if(isset($errores['cuit_cuil'])): ?> aria-describedby="error-cuit_cuil" <?php endif; ?>
                    >
                    <?php 
                    if(isset($errores['cuit_cuil'])):
                    ?>
                    <div data-error="form">
                        <p id="error-cuit_cuil" class="form-text"> <?= $errores['cuit_cuil'] ?> </p>
                    </div>
                    <?php 
                    endif;
                    ?>
                </div>
            </div>
        
        
            <div>
                <button class="btn-crear-producto" type="submit">Crear usuario</button>
            </div>

        </form>
    </div>
</section>