<?php 
use App\Auth\Autenticacion;
?>

<section class="error-404">

    <article class="error-404-texto">
        <h2>¿No encontrás la página que buscabas?</h2>
        <?php if(!(new Autenticacion)->estaAutenticado()){ ?>
        <p>No te preocupes, en el siguiente enlace podrás iniciar sesión.</p>
        <?php } else{ ?>
        <p>No te preocupes, en el siguiente enlace podrás volver al tablero de productos.</p>
        <?php } ?>
        
    </article>
    <div class="error-404-btns">
        <?php if(!(new Autenticacion)->estaAutenticado()){ ?>
        <a class="error-404-btn-a" href="index.php?s=iniciar-sesion">Iniciar Sesión</a>
        <?php } else{ ?>
            <a class="error-404-btn-a" href="index.php?s=productos">Productos</a>
        <?php } ?>
    </div>

</section>