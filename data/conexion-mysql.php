<?php 

$db_host = 'localhost:8889';
$db_user = 'root';
$db_pass = 'root';
$db_name = 'dw3_alvarez_edmundo';

$db_dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8mb4';


try{

    $db = new PDO($db_dsn, $db_user, $db_pass);


} catch(Exception $e){
    echo "Error al conectar con mysql </br>";
    echo "El error ocurrido es: " . $e->getMessage();

}