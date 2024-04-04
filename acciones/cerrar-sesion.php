<?php
use App\Auth\Autenticacion;

session_start();
require_once __DIR__ . "/../bootstrap/autoload.php";


(new Autenticacion)->cerrarSesion();

$_SESSION['mensajeExito'] = "La sesión se cerró correctamente. Te esperamos de vuelta pronto.";

header('Location: ../index.php?s=iniciar-sesion');
exit;