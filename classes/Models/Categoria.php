<?php 

namespace App\Models;

use App\Database\DB;

class Categoria
{
    private int $categoria_id;
    private string $nombre;

    public function cargarDatosDeArray(array $data): void
    {
        $this->setCategoriaId($data['categoria_id']);
        $this->setNombre($data['nombre']);
    }

    /**
     * @return array|Categoria
     */
    public function todos(): array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM categorias";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Categoria::class);
        return $stmt->fetchAll();

    }


    public function getCategoriaId (): int
    {
        return $this->categoria_id;
    }
    public function setCategoriaId (int $categoria_id): void
    {
        $this->categoria_id = $categoria_id;
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


