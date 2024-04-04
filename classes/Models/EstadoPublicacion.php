<?php 

namespace App\Models;

use App\Database\DB;

class EstadoPublicacion
{
    private int $estado_publicacion_id;
    private string $nombre;

    public function cargarDatosDeArray(array $data): void
    {
        $this->setEstadoPublicacionId($data['estado_publicacion_id']);
        $this->setNombre($data['nombre']);
    }

    /**
     * @return array|EstadoPublicacion
     */
    public function todos(): array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM estados_publicacion";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, EstadoPublicacion::class);
        return $stmt->fetchAll();

    }


    public function getEstadoPublicacionId (): int
    {
        return $this->estado_publicacion_id;
    }
    public function setEstadoPublicacionId (int $estado_publicacion_id): void
    {
        $this->estado_publicacion_id = $estado_publicacion_id;
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


