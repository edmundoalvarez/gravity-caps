<?php 
namespace App\Database;
use PDO;
use Exception;

class DB
{
    protected static string $host = 'sql309.infinityfree.com';
    protected static string $user = 'if0_36306311';
    protected static string $pass = 'Checho12345';
    protected static string $name = 'if0_36306311_gravitycaps';

    /** @var PDO|null Contenedor de la conexión de la base de datos  */
    protected static ?PDO $db = null; 

    public static function getConexion(): PDO
    {
        if(self::$db === null){
            $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$name . ';charset=utf8mb4';

            try{
                self::$db = new PDO($dsn, self::$user, self::$pass);
            } catch(Exception $e){
                echo "Error al conectar con mysql </br>";
                echo "El error ocurrido es: " . $e->getMessage();
                exit; 
            }
        }

        return self::$db;
    }
}