<?php 

namespace App\Models;

use App\Database\DB;

class Rol
{
    private int $rol_id;
    private string $nombre;

    public function cargarDatosDeArray(array $data): void
    {
        $this->setRolId($data['rol_id']);
        $this->setNombre($data['nombre']);
    }

    /**
     * @return array|Rol
     */
    public function todos(): array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM roles";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Rol::class);
        return $stmt->fetchAll();

    }


    public function getRolId (): int
    {
        return $this->rol_id;
    }
    public function setRolId (int $rol_id): void
    {
        $this->rol_id = $rol_id;
    }

    public function getNombre (): string
    {
        return $this->nombre;
    }
    public function setNombre (string $nombre): void
    {
        $this->nombre = $nombre;
    }
}


