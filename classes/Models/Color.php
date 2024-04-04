<?php 

namespace App\Models;

use App\Database\DB;

class Color
{
    private int $color_id;
    private string $nombre;

    public function cargarDatosDeArray(array $data): void
    {
        $this->setColorId($data['color_id']);
        $this->setNombre($data['nombre']);
    }

    /**
     * @return array|Color
     */
    public function todos(): array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM colores";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Color::class);
        return $stmt->fetchAll();

    }


    public function getColorId (): int
    {
        return $this->color_id;
    }
    public function setColorId (int $color_id): void
    {
        $this->color_id = $color_id;
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


