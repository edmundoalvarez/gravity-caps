<?php 

namespace App\Models;

use App\Database\DB;

class Talle
{
    private int $talle_id;
    private string $nombre;

    public function cargarDatosDeArray(array $data): void
    {
        $this->setTalleId($data['talle_id']);
        $this->setNombre($data['nombre']);
    }

    /**
     * @return array|Talle
     */
    public function todos(): array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM talles";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Talle::class);
        return $stmt->fetchAll();
    }


    public function getTalleId (): int
    {
        return $this->talle_id;
    }
    public function setTalleId (int $talle_id): void
    {
        $this->talle_id = $talle_id;
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


