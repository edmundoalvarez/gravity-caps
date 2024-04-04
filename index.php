<?php 

use App\Auth\Autenticacion; 



require_once __DIR__ . "/bootstrap/autoload.php";

session_start();

    
    $rutas = [
        '404' => [
            'title' => 'Página no Encontrada',
        ],
        'home' => [
            'title' => 'Página Principal',
        ],
        'productos' => [
            'title' => 'Todos los productos',
        ],
        'productos-genero' => [
            'title' => 'Productos por género',
        ],
        'producto-detalle' => [
            'title' => 'Detalle del producto',
        ],
        'contacto' => [
            'title' => 'Contactanos',
        ],
        'gracias' => [
            'title' => '¡Gracias!',
        ],
        'iniciar-sesion' => [
            'title' => 'Inicio de sesión',
        ],
        'crear-cuenta' => [
            'title' => 'Crear cuenta',
        ],
        'mi-perfil' => [
            'title' => 'Mi Perfil',
            'requiereAutenticacion' => true,

        ],
        'carrito' => [
            'title' => 'Carrito de compras',
            'requiereAutenticacion' => true,
        ],
        'compra-finalizada' => [
            'title' => 'Muchas gracias!',
            'requiereAutenticacion' => true,
        ]
    ];

    $pagina = $_GET['s'] ?? 'home';

    if(!isset($rutas[$pagina])) {

        $pagina = '404';
    }

    $rutaOpciones = $rutas[$pagina];


    $autenticacion = new Autenticacion();
    $requiereAutenticacion = $rutaOpciones['requiereAutenticacion'] ?? false;

    if($requiereAutenticacion && !$autenticacion->estaAutenticado()){
        $_SESSION['mensajeError'] = 'Se requiere iniciar sesión para ver este contenido';
            header('Location: index.php?s=iniciar-sesion');
        exit;
    }

    if($autenticacion->estaAutenticado()){
        
        $id = $autenticacion->getUsuario()->getUsuarioId();


    }




?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <title><?= $rutaOpciones['title'];?> | Parcial 1</title>
</head>
<body>
    <div id="todo">
        <header class="fixed-top">
        <div class="header">
            <h1 class="h1">Gravity Caps</h1>
            <nav class="nav" >
                <ul>
                    <li><a class="nav-a" href="index.php?s=home">Inicio</a></li>
                    <li><a class="nav-a" href="index.php?s=productos">Productos</a></li>
                    <li><a class="nav-a" href="index.php?s=contacto">Contacto</a></li>
                    <?php 
                    if($autenticacion->estaAutenticado()){
                    ?>
                        <li><a class="nav-a" href="index.php?s=mi-perfil&id=<?= $id;?>">Mi perfil</a></li>
                        <li><a class="nav-a" href="index.php?s=carrito&id=<?= $id;?>">Carrito</a></li>
                        <li>
                            <form class="form-cerrar-sesion" action="acciones/cerrar-sesion.php" method="post">
                                <button class="nav-a" type="submit">Cerrar sesión</button>
                            </form>
                        </li>
                    <?php 
                    } else {
                    ?>
                    <li><a class="nav-a" href="index.php?s=iniciar-sesion">Iniciar Sesión</a></li>
                    <li><a class="nav-a" href="index.php?s=crear-cuenta">Crear Cuenta</a></li>
                    <?php 
                    };
                    ?>
                </ul>
            </nav>
        </div>
        </header>
        
        <main>
            
            <?php if(isset($_SESSION['mensajeExito'])): ?>
            <div class="mensaje-creado-exito">
                <p><?= $_SESSION['mensajeExito']; ?></p>
            </div>
            <?php 
                unset($_SESSION['mensajeExito']);
            endif; 
            ?>
            <?php if(isset($_SESSION['mensajeError'])): ?>
            <div class="mensaje-creado-error">
                <p><?= $_SESSION['mensajeError']; ?></p>
            </div>
            <?php 
                unset($_SESSION['mensajeError']);
            endif; 
            ?>



            <?php
                require 'pages/' . $pagina . '.php';
            ?>
        </main>

        <footer>
            <div class="footer">
                <p>©Copyright - Edmundo Alvarez - Escuela Da Vinci</p>
            </div>
        </footer>
    </div>
</body>
</html>