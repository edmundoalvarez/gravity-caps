<?php 

use App\Auth\Autenticacion;

require_once __DIR__ . "/../bootstrap/autoload.php";
session_start();

    
$rutas = [
    '404' => [
        'title' => 'Página no Encontrada',
    ],
    'dashboard' => [
        'title' => 'Tablero de Administracion',
        'requiereAutenticacion' => true,
    ],
    'productos' => [
        'title' => 'Administracion de Productos',
        'requiereAutenticacion' => true,
    ],
    'producto-crear' => [
        'title' => 'Crear un Producto',
        'requiereAutenticacion' => true,
    ],
    'producto-editar' => [
        'title' => 'Editar un Producto',
        'requiereAutenticacion' => true,
    ],
    'producto-eliminar' => [
        'title' => 'Eliminar un Producto',
        'requiereAutenticacion' => true,
    ],
    'usuarios' => [
        'title' => 'Administracion de Usuarios',
        'requiereAutenticacion' => true,
    ],
    'usuario-crear' => [
        'title' => 'Crear Usuario',
        'requiereAutenticacion' => true,
    ],
    'usuario-eliminar' => [
        'title' => 'Eliminar Usuario',
        'requiereAutenticacion' => true,
    ],
    'usuario-ver-compras' => [
        'title' => 'Compras de Usuario',
        'requiereAutenticacion' => true,
    ],
    'iniciar-sesion' => [
        'title' => 'Ingreso al Panel de Administrción',
    ]
];

$pagina = $_GET['s'] ?? 'dashboard';

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


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/style.css">
    <title><?= $rutaOpciones['title'];?> | Parcial 1</title>
</head>
<body>
    <div id="todo">
        <header class="fixed-top">
        <div class="header">
            <h1 class="h1">Gravity Caps</h1>
            <nav class="nav" >
            <?php 
                if($autenticacion->estaAutenticado()):
            ?>
                <ul>
                    <li><a class="nav-a" href="index.php?s=dashboard">Tablero</a></li>
                    <li><a class="nav-a" href="index.php?s=productos">Productos</a></li>
                    <li><a class="nav-a" href="index.php?s=usuarios">Usuarios</a></li>
                    <li>
                        <form class="form-cerrar-sesion" action="acciones/cerrar-sesion.php" method="post">
                            <button class="nav-a" type="submit"><?= $autenticacion->getUsuario()->getUsername(); ?> (Cerrar Sesión)</button>
                        </form>
                    </li>
                </ul>
            <?php 
                endif;
            ?>
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