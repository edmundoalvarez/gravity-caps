<?php 

namespace App\Models;

use App\Database\DB;

class EstadoCompra
{
    private int $estado_compra_id;
    private string $nombre;

    public function cargarDatosDeArray(array $data): void
    {
        $this->setEstadoCompraId($data['estado_compra_id']);
        $this->setNombre($data['nombre']);
    }

    /**
     * @return array|EstadoCompra
     */
    public function todos(): array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM estados_compra";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, EstadoCompra::class);
        return $stmt->fetchAll();

    }


    public function getEstadoCompraId (): int
    {
        return $this->estado_compra_id;
    }
    public function setEstadoCompraId (int $estado_compra_id): void
    {
        $this->estado_compra_id = $estado_compra_id;
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


