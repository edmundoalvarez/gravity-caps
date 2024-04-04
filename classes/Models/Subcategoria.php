<?php 

namespace App\Models;

use App\Database\DB;

class Subcategoria
{
    private int $subcategoria_id;
    private int $categoria_fk;
    private string $nombre;

    public function cargarDatosDeArray(array $data): void
    {
        $this->setSubcategoriaId($data['subcategoria_id']);
        $this->setNombre($data['nombre']);
    }

    /**
     * @return array|Subcategoria
     */
    public function todos(): array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM subcategorias";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Subcategoria::class);
        return $stmt->fetchAll();
    }


    public function getSubcategoriaId (): int
    {
        return $this->subcategoria_id;
    }
    public function setSubcategoriaId (int $subcategoria_id): void
    {
        $this->subcategoria_id = $subcategoria_id;
    }

    
    public function getCategoriaFk (): int
    {
        return $this->categoria_fk;
    }
    public function setCategoriaFk (int $categoria_fk): void
    {
        $this->categoria_fk = $categoria_fk;
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


