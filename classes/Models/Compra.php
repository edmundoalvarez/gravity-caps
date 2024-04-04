<?php 

namespace App\Models;

use App\Database\DB;
use PDO;


class Compra
{
    private int     $compra_id;
    private int     $estado_compra_fk;
    private int     $usuario_fk;
    private float   $total;

    private EstadoCompra   $estado_compra;

    /** @var Producto[] */
    private array $productos = [];

    public function cargarDatosDeArray(array $data): void
    {
        $this->setCompraId($data['compra_id']);
        $this->setEstadoCompraFk($data['estado_compra_fk']);
        $this->setUsuarioFk($data['usuario_fk']);
        $this->setTotal($data['total']);
    }

    /**
     * @return array|Compra
     */
    public function todas(): array
    {
        $db = (new DB())->getConexion();
        $query = "SELECT 
                    c.*, 
                    ec.nombre AS 'estado_compra'
                    FROM compras c
                    INNER JOIN estados_compra ec
                    ON
                    c.estado_compra_fk = ec.estado_compra_id";
                    
        $queryParams = [];

        $stmt = $db->prepare($query);
        $stmt->execute($queryParams);

        $compras = [];

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)){

            $compra = new Compra();
            $compra->cargarDatosDeArray($registro);

            $estado = new EstadoCompra();
            $estado->cargarDatosDeArray([
                'estado_compra_id' => $registro['estado_compra_fk'],
                'nombre' => $registro['estado_compra'],
            ]);

            $compra->setEstadoCompra($estado);

            $compra->ejecutarQueryParaTraerProductos();


            $compras[] = $compra;
        }



        return $compras;
    }

    public function todasConGroupBy(): array
    {
        $db = DB::getConexion();
        $query = "SELECT 
                        c.*, 
                        ec.nombre AS 'estado_compra',
                        GROUP_CONCAT(CONCAT(p.producto_id, ' :: ', p.nombre, ' :: ' , p.imagen_grande_01, ' :: ' , p.imagen_descripcion, ' :: ' , p.precio, ' :: ', ptc.cantidad) SEPARATOR ' - ') AS productos_en_carrito
                    FROM compras c
                    INNER JOIN estados_compra ec
                        ON c.estado_compra_fk = ec.estado_compra_id
                    INNER JOIN productos_tienen_compras ptc
                        ON c.compra_id = ptc.compra_fk
                    INNER JOIN productos p
                        ON p.producto_id = ptc.producto_fk";
        $queryParams = [];

        $query .= " GROUP BY c.compra_id";
        $stmt = $db->prepare($query);
        $stmt->execute($queryParams);

        $compras = [];

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)){

            $compra = new Compra();
            $compra->cargarDatosDeArray($registro);

            $estado = new EstadoCompra();
            $estado->cargarDatosDeArray([
                'estado_compra_id' => $registro['estado_compra_fk'],
                'nombre' => $registro['estado_compra'],
            ]);

            $compra->setEstadoCompra($estado);

            $compra->parsearProductosDeCompra($registro['productos_en_carrito']);


            $compras[] = $compra;
        }



        return $compras;
    }

    public function crear(array $data)
    {
        $db = DB::getConexion();
        $query = "INSERT INTO compras (estado_compra_fk, usuario_fk, total)
                VALUES (:estado_compra_fk, :usuario_fk, :total)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'estado_compra_fk'  => $data['estado_compra_fk'],
            'usuario_fk'        => $data['usuario_fk'],
            'total'             => $data['total']
        ]);
    }

    public function parsearProductosDeCompra(string $productos): void
    {
        $arrayProductos = explode('- ', $productos);

        $productosCompra = [];

        foreach($arrayProductos as $dataProducto){
            
            [$id, $nombre, $imagen, $imagen_descripcion, $precio, $cantidad] = explode(' :: ', $dataProducto);

            $producto = new Producto();
            $producto->setProductoId($id);
            $producto->setNombre($nombre);
            $producto->setImgGrande1($imagen);
            $producto->setImgAlt($imagen_descripcion);
            $producto->setPrecio($precio);
            $producto->setCantidad($cantidad);
            $producto->setSubtotal($cantidad * $precio);


            $productosCompra[] = $producto;

            
        }
        $this->setProductos($productosCompra);

    }
    
    public function buscarId(int $id): ?Compra
    {
    

        $db = DB::getConexion();
        $query = "SELECT * FROM compras
                WHERE compra_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Compra::class);

        $compras = $stmt->fetch();

        if(!$compras) return null;

        $compras->ejecutarQueryParaTraerProductos();

        return $compras;

    }


    public function ejecutarQueryParaTraerProductos()
    {
        $db = DB::getConexion();
        $query = "SELECT 
                    p.* 
                FROM productos_tienen_compras ptc
                INNER JOIN productos p
                    ON ptc.producto_fk = p.producto_id
                WHERE ptc.compra_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->getCompraId()]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Producto::class);
        $this->productos = $stmt->fetchAll();
    }

    public function vincularProducto (array $data) 
    {
            $db = DB::getConexion();
            $query = "INSERT INTO productos_tienen_compras (producto_fk, compra_fk, cantidad, precio, subtotal)
                    VALUES (:producto_fk, :compra_fk, :cantidad, :precio, :subtotal)";
            $stmt = $db->prepare($query);
            $stmt->execute([
                'producto_fk'    => $data['producto_fk'],
                'compra_fk'      => $data['compra_fk'],
                'cantidad'       => $data['cantidad'],
                'precio'         => $data['precio'],
                'subtotal'       => $data['subtotal']

            ]);
            $this->actualizarTotal($data['compra_fk']);

    }

    public function actualizarTotal ($compraId){
        $db = DB::getConexion();
        $query = "UPDATE compras c 
                    JOIN productos_tienen_compras ptc
                    SET c.total = (SELECT SUM(productos_tienen_compras.subtotal) FROM productos_tienen_compras WHERE compra_fk = c.compra_id) 
                    WHERE c.compra_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$compraId]);

    }

    public function desvincularProducto($productoId, $compraId): void
    {
        $db = DB::getConexion();
        $query = "DELETE FROM productos_tienen_compras
                WHERE producto_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$productoId]);
        $this->actualizarTotal($compraId);
    }

    public function sumarProductos($productoId, $compraId): void
    {
        $db = DB::getConexion();
        $query = "UPDATE productos_tienen_compras ptc
                    SET ptc.cantidad = ptc.cantidad+1,
                        ptc.subtotal = ptc.precio * ptc.cantidad
                    WHERE ptc.producto_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$productoId]);
        $this->actualizarTotal($compraId);
        
    }

    public function restarProductos($productoId, $compraId): void
    {
        $db = DB::getConexion();
        $query = "UPDATE productos_tienen_compras ptc
                    SET ptc.cantidad = ptc.cantidad-1,
                        ptc.subtotal = ptc.precio * ptc.cantidad
                    WHERE ptc.cantidad > 1 AND ptc.producto_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$productoId]);
        $this->actualizarTotal($compraId);

    }

    public function vaciarProductosCompra($compraId)
    {
        $db = DB::getConexion();
        $query = "DELETE FROM productos_tienen_compras
                WHERE compra_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$compraId]);
        $this->actualizarTotal($compraId);
    }

    public function vaciarCompra($compraId)
    {
        $db = DB::getConexion();
        $query = "UPDATE compras c
                    SET c.total = 0
                    WHERE c.compra_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$compraId]);
    }


    public function editar(array $data)
    {
        $db = DB::getConexion();
        $query = "UPDATE compras 
                SET estado_compra_fk = :estado_compra_fk
                WHERE compra_id = :compra_id";

        $stmt = $db->prepare($query);
        $stmt->execute([
            'estado_compra_fk'  => $data['estado_compra_fk']
        ]);

    }

    public function eliminar(int $compraId)
    {

        $db = DB::getConexion();
        $query = "DELETE FROM compras
                    WHERE compra_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$compraId]);

    }



    public function getCompraId (): int
    {
        return $this->compra_id;
    }
    public function setCompraId (int $compra_id): void
    {
        $this->compra_id = $compra_id;
    }

    public function getEstadoCompraFk (): int
    {
        return $this->estado_compra_fk;
    }
    public function setEstadoCompraFk (int $estado_compra_fk): void
    {
        $this->estado_compra_fk = $estado_compra_fk;
    }

    public function getUsuarioFk (): int
    {
        return $this->usuario_fk;
    }
    public function setUsuarioFk (int $usuario_fk): void
    {
        $this->usuario_fk = $usuario_fk;
    }


    public function getTotal ()
    {
        return $this->total;
    }
    public function setTotal ($total)
    {
        $this->total = $total;
    }



    public function getEstadoCompra(): EstadoCompra
    {
        return $this->estado_compra;
    }
    public function setEstadoCompra(EstadoCompra $estado_compra): void
    {
        $this->estado_compra = $estado_compra;
    }


    public function getProductos(): array
    {
        return $this->productos;
    }

    public function setProductos(array $productos): void
    {
        $this->productos = $productos;
    }
}


