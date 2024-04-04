<?php 

if(isset($_SESSION['mensajeError'])){
    $errores = $_SESSION['mensajeError'];
    unset($_SESSION['mensajeError']);
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

<section class="iniciar-sesion-completa">
    <div class="iniciar-sesion-div">
        <h2>Iniciar sesión</h2>
        <p>Ingresá con tu usuario y contraseña si es que ya te registraste o creá tu cuenta para poder hacerlo.</p>
            <form action="acciones/iniciar-sesion.php" method="post">
                <div>
                    <label  for="email">Email</label>
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        placeholder="Ingresar email"
                        value="<?= $oldData['email'] ?? null ?>"
                        >
                </div>
                <div>
                    <label for="password">Contraseña</label>
                    <input  
                        class="form-control"  
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Ingesar contraseña"
                        value="<?= $oldData['password'] ?? null ?>"
                    >
                </div>
                <div>
                    <button type="submit">Iniciar Sesión</button>
                </div>
            </form>
    </div>
</section>

