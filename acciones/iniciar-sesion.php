<?php
    use App\Auth\Autenticacion;
    session_start();


    require_once __DIR__ . '/../bootstrap/autoload.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    $autenticacion = new Autenticacion();


    try {
        if((new Autenticacion)->iniciarSesionVisit($email , $password )){
            $_SESSION['mensajeExito'] = "¡Bienvenido nuevamente!";

            header("Location: ../index.php?s=carrito&id=". $autenticacion->getUsuario()->getUsuarioId());
            exit;

        }

        $_SESSION['oldData'] = $_POST;
        $_SESSION['mensajeError'] = 'Los datos ingresados no coinciden con ningún registro de nuestro sistema.';
        header("Location: ../index.php?s=iniciar-sesion");
        exit;

    } catch (Exception $e) {
        $_SESSION['mensajeError'] = 'Ocurrió un problema inesperado. Por favor, probá de nuevo mas tarde.';
        header("Location: ../index.php?s=iniciar-sesion");
        exit;
    
    };