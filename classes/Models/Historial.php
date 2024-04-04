<?php 

namespace App\Models;

use App\Database\DB;
use PDO;


class Historial
{
    private int     $historial_id;
    private int     $usuario_fk;
    private string  $fecha;
    private string  $total;

    public function cargarDatosDeArray(array $data): void
    {
        $this->setHistorialId($data['historial_id']);
        $this->setUsuarioFk($data['usuario_fk']);
        $this->setFecha($data['fecha']);
        $this->setTotal($data['total']);
    }

    /**
     * @return array|Historial
     */
    public function todos(): array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM historiales";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Historial::class);
        return $stmt->fetchAll();
    }

    public function agregarCompra(array $data)
    {
        $db = DB::getConexion();
        $query = "INSERT INTO historiales (usuario_fk, fecha, total)
                VALUES (:usuario_fk, :fecha, :total)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'usuario_fk'    => $data['usuario_fk'],
            'fecha'         => $data['fecha'],
            'total'         => $data['total']
        ]);
    }

    public function getHistorialId (): int
    {
        return $this->historial_id;
    }
    public function setHistorialId (int $historial_id): void
    {
        $this->historial_id = $historial_id;
    }
    
    public function getUsuarioFk (): int
    {
        return $this->usuario_fk;
    }
    public function setUsuarioFk (int $usuario_fk): void
    {
        $this->usuario_fk = $usuario_fk;
    }


    public function getFecha ()
    {
        return $this->fecha;
    }
    public function setFecha ($fecha)
    {
        $this->fecha = $fecha;
    }


    public function getTotal ()
    {
        return $this->total;
    }
    public function setTotal ($total)
    {
        $this->total = $total;
    }
}


