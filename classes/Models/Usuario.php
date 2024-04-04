<?php 
namespace App\Models;
use App\Database\DB;
use PDO;

class Usuario
{
    private     int $usuario_id;
    private     int $rol_fk;
    private     string $email;
    private     string $password;
    private     int $telefono;
    private     string $username;
    private     string $empresa;
    private     int $cuit_cuil;

    private Rol      $rol;



    public function cargarDatosDeArray(array $data): void 
    {
        $this->setUsuarioId($data['usuario_id']);
        $this->setRolFk($data['rol_fk']);
        $this->setEmail($data['email']);
        $this->setTelefono($data['telefono']);
        $this->setUsername($data['username']);
        $this->setEmpresa($data['empresa']);
        $this->setCuitCuil($data['cuit_cuil']);
    }

    public function todos(): array {


        $db = DB::getConexion();
        $query = "SELECT 
                    u. *, 
                    r.nombre AS 'rol'
                FROM usuarios u
                INNER JOIN roles r
                ON 
                    u.rol_fk = r.rol_id";

        $queryParams = [];

        $stmt = $db->prepare($query);
        $stmt->execute($queryParams);

        $usuarios = [];

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)){

            $usuario = new Usuario();
            $usuario->cargarDatosDeArray($registro);

            $rol = new Rol();
            $rol->cargarDatosDeArray([
                'rol_id' => $registro['rol_fk'],
                'nombre' => $registro['rol'],
            ]);
            $usuario->setRol($rol);


            $usuarios[] = $usuario;
        }



        return $usuarios;
        

    }


    public function crear (array $data){
        $db = DB::getConexion();
        $query = "INSERT INTO usuarios (rol_fk, email, password, telefono, username, empresa, cuit_cuil)
            VALUES (:rol_fk, :email, :password, :telefono, :username, :empresa, :cuit_cuil)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'rol_fk'        => $data['rol_fk'],
            'email'         => $data['email'],
            'password'      => $data['password'],
            'telefono'      => $data['telefono'],
            'username'      => $data['username'],
            'empresa'       => $data['empresa'],
            'cuit_cuil'     => $data['cuit_cuil']
        ]);

        $usuarioId = $db->lastInsertId();
        $this->vincularCompra($usuarioId);

    }


    public function vincularCompra ($usuarioId){

        $db = DB::getConexion();
        $query = "INSERT INTO compras (estado_compra_fk, total, usuario_fk)
            VALUES (:estado_compra_fk, :total, :usuario_fk)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'estado_compra_fk'  => 1,
            'total'             => 0,
            'usuario_fk'        => $usuarioId

        ]);
    }

    public function desvincularCompra($usuarioId){

        $db = DB::getConexion();
        $query = "DELETE FROM compras
            WHERE usuario_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$usuarioId]);
    }

    public function desvincularHistorial($usuarioId){

        $db = DB::getConexion();
        $query = "DELETE FROM historiales
            WHERE usuario_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$usuarioId]);
    }

    public function eliminar(int $id)
    {

        $this->desvincularCompra($id);
        $this->desvincularHistorial($id);

        $db = DB::getConexion();
        $query = "DELETE FROM usuarios
                    WHERE usuario_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

    }




    public function porEmail (string $email): ?Usuario
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM usuarios
                WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
        $usuario = $stmt->fetch();

        if(!$usuario) return null;
        return $usuario;
    }

    public function buscarId (string $id): ?Usuario
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM usuarios
                WHERE usuario_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
        $usuario = $stmt->fetch();

        if(!$usuario) return null;


        return $usuario;
    }


    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }
    public function setUsuarioId(int $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }



    public function getRolFk()
    {
        return $this->rol_fk;
    }
    public function setRolFk($rol_fk)
    {
        $this->rol_fk = $rol_fk;
    }

    public function getRol(): Rol
    {
        return $this->rol;
    }
    public function setRol(Rol $rol): void
    {
        $this->rol = $rol;
    }





    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }


    public function getTelefono(): int
    {
        return $this->telefono;
    }
    public function setTelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }



    public function getUsername(): string
    {
        return $this->username;
    }
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword( $password)
    {
        $this->password = $password;
    }



    public function getEmpresa(): string
    {
        return $this->empresa;
    }
    public function setEmpresa(string $empresa): void
    {
        $this->empresa = $empresa;
    }



    public function getCuitCuil(): int
    {
        return $this->cuit_cuil;
    }
    public function setCuitCuil(int $cuit_cuil): void
    {
        $this->cuit_cuil = $cuit_cuil;
    }




}

