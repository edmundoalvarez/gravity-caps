<?php 
namespace App\Models;
use App\Database\DB;
use PDO;


class Producto {

    private int                 $producto_id;
    private string              $nombre;
    private float               $precio;
    private string              $descripcion;
    private ?string             $imagen_grande_01;
    private string              $imagen_descripcion;
    private int                 $stock;
    private int                 $estado_publicacion_fk;
    private int                 $categoria_fk;
    private int                 $subcategoria_fk;
    private int                 $talle_fk;
    private int                 $cantidad;
    private float               $subtotal;


    private EstadoPublicacion   $estado_publicacion;
    private Categoria           $categoria;
    private Subcategoria        $subcategoria;
    private Talle               $talle;

    /** @var Color[] */
    private array $colores = [];

    public function cargarDatosDeArray(array $data): void 
    {
        $this->setProductoId($data['producto_id']);
        $this->setNombre($data['nombre']);
        $this->setPrecio($data['precio']);
        $this->setDescripcion($data['descripcion']);
        $this->setImgGrande1($data['imagen_grande_01']);
        $this->setImgAlt($data['imagen_descripcion']);
        $this->setTalleFk($data['talle_fk']);
        $this->setStock($data['stock']);
        $this->setEstadoPublicacionFk($data['estado_publicacion_fk']);
        $this->setCategoriaFk($data['categoria_fk']);
        $this->setSubcategoriaFk($data['subcategoria_fk']);
    }

    public function todos(array $busqueda = []): array {


        $db = DB::getConexion();
        $query = "SELECT 
                    p. *, 
                    ep.nombre AS 'estado_publicacion',
                    c.nombre AS 'categoria',
                    sc.nombre AS 'subcategoria',
                    t.nombre AS 'talle'
                FROM productos p
                INNER JOIN estados_publicacion ep
                INNER JOIN categorias c
                INNER JOIN subcategorias sc
                INNER JOIN talles t
                ON 
                    p.estado_publicacion_fk = ep.estado_publicacion_id 
                    AND p.categoria_fk = c.categoria_id
                    AND p.subcategoria_fk = sc.subcategoria_id
                    AND p.talle_fk = t.talle_id";

        $queryParams = [];
        if(count($busqueda) > 0){

            $whereConditions = [];
            foreach($busqueda as $busquedDatos){

                $whereConditions[] = $busquedDatos[0] . ' ' . $busquedDatos[1] . ' ?';

                $queryParams[] = $busquedDatos[2];
            }

            $query .= " WHERE " . implode(' AND ', $whereConditions);

        };

        $stmt = $db->prepare($query);
        $stmt->execute($queryParams);

        $productos = [];

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)){

            $producto = new Producto();
            $producto->cargarDatosDeArray($registro);

            $estado = new EstadoPublicacion();
            $estado->cargarDatosDeArray([
                'estado_publicacion_id' => $registro['estado_publicacion_fk'],
                'nombre' => $registro['estado_publicacion'],
            ]);

            $producto->setEstadoPublicacion($estado);


            $categoria = new Categoria();
            $categoria->cargarDatosDeArray([
                'categoria_id' => $registro['categoria_fk'],
                'nombre' => $registro['categoria'],
            ]);

            $producto->setCategoria($categoria);


            $subcategoria = new Subcategoria();
            $subcategoria->cargarDatosDeArray([
                'subcategoria_id' => $registro['subcategoria_fk'],
                'nombre' => $registro['subcategoria'],
            ]);

            $producto->setSubcategoria($subcategoria);

            $talle = new Talle();
            $talle->cargarDatosDeArray([
                'talle_id' => $registro['talle_fk'],
                'nombre' => $registro['talle'],
            ]);

            $producto->setTalle($talle);

            $producto->ejecutarQueryParaTraerColores();


            $productos[] = $producto;
        }



        return $productos;
        

    }


    public function buscarId(int $id): ?Producto
    {
    

        $db = DB::getConexion();
        $query = "SELECT * FROM productos
                WHERE producto_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Producto::class);

        $producto = $stmt->fetch();

        if(!$producto) return null;

        $producto->ejecutarQueryParaTraerColores();

        return $producto;

    }

    public function ejecutarQueryParaTraerColores()
    {
        $db = DB::getConexion();
        $query = "SELECT 
                    c.* 
                FROM productos_tienen_colores ptc
                INNER JOIN colores c
                    ON ptc.color_fk = c.color_id
                WHERE ptc.producto_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->getProductoId()]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Color::class);
        $this->colores = $stmt->fetchAll();
    }


    public function buscarGenero(int $subcategoria_fk): ?array
    {


        $productosGenero = [];

        $db = DB::getConexion();
        $query = "SELECT * FROM productos
                WHERE subcategoria_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$subcategoria_fk]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Producto::class);


        while($producto = $stmt->fetch()){

            if(!$producto) return null;

            $productosGenero[] = $producto;

            
        }
        
        return $productosGenero;


    }

    public function crear(array $data)
    {
        $db = DB::getConexion();
        $query = "INSERT INTO productos (nombre,categoria_fk,subcategoria_fk,talle_fk,descripcion,imagen_descripcion,imagen_grande_01,precio,stock, estado_publicacion_fk)
            VALUES (:nombre, :categoria_fk, :subcategoria_fk, :talle_fk, :descripcion, :imagen_descripcion, :imagen_grande_01, :precio, :stock, :estado_publicacion_fk)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'nombre'                => $data['nombre'],
            'descripcion'           => $data['descripcion'],
            'imagen_descripcion'    => $data['imagen_descripcion'],
            //'imagen_miniatura'      => $data['imagen_miniatura'],
            'imagen_grande_01'      => $data['imagen_grande_01'],
            //'imagen_chica_01'       => $data['imagen_chica_01'],
            'precio'                => $data['precio'],
            'stock'                 => $data['stock'],
            'estado_publicacion_fk' => $data['estado_publicacion_fk'],
            'categoria_fk'          => $data['categoria_fk'],
            'subcategoria_fk'       => $data['subcategoria_fk'],
            'talle_fk'              => $data['talle_fk']

        ]);
        $productoId = $db->lastInsertId();

        $this->vincularColores($productoId, $data['colores_fks']);

    }

    public function vincularColores(int $productoId, array $coloresFks)
    {

        if(count($coloresFks) > 0) {
            $valueList = [];
            $holderValues = [];

            foreach($coloresFks as $colorFk) {
                $valueList[] = '(?, ?)';
                $holderValues[] = $productoId;
                $holderValues[] = $colorFk;
            }

            $db = DB::getConexion();
            $query = "INSERT INTO productos_tienen_colores (producto_fk, color_fk)
                    VALUES " . implode(', ', $valueList);
            $stmt = $db->prepare($query);
            $stmt->execute($holderValues);
        }
    }


    public function editar(int $id, array $data)
    {
        $db = DB::getConexion();
        $query = "UPDATE productos 
                SET nombre                  = :nombre,
                    descripcion             = :descripcion,
                    imagen_descripcion      = :imagen_descripcion,
                    imagen_grande_01        = :imagen_grande_01,
                    precio                  = :precio,
                    stock                   = :stock,
                    estado_publicacion_fk   = :estado_publicacion_fk,
                    categoria_fk            = :categoria_fk,
                    subcategoria_fk         = :subcategoria_fk,
                    talle_fk                = :talle_fk
                WHERE producto_id = :producto_id";

        $stmt = $db->prepare($query);
        $stmt->execute([
            'nombre'                => $data['nombre'],
            'descripcion'           => $data['descripcion'],
            'imagen_descripcion'    => $data['imagen_descripcion'],
            'imagen_grande_01'      => $data['imagen_grande_01'],
            'precio'                => $data['precio'],
            'stock'                 => $data['stock'],
            'producto_id'           => $id,
            'estado_publicacion_fk' => $data['estado_publicacion_fk'],    
            'categoria_fk'          => $data['categoria_fk'],    
            'subcategoria_fk'       => $data['subcategoria_fk'],    
            'talle_fk'              => $data['talle_fk']    

        ]);

        $this->desvincularColores($id);
        $this->vincularColores($id, $data['colores_fks']);


    }

    public function eliminar(int $id)
    {
        $this->desvincularColores($id);


        $db = DB::getConexion();
        $query = "DELETE FROM productos
                    WHERE producto_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

    }

    public function desvincularColores(int $id): void
    {
        $db = DB::getConexion();
        $query = "DELETE FROM productos_tienen_colores
                WHERE producto_fk = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
    }


    public function getProductoId()
    {
        return $this->producto_id;
    }
    public function setProductoId($producto_id)
    {
        $this->producto_id = $producto_id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getPrecio()
    {
        return $this->precio;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getImgGrande1()
    {
        return $this->imagen_grande_01;
    }
    public function setImgGrande1(?string $imagen_grande_01):void
    {
        $this->imagen_grande_01 = $imagen_grande_01;
    }

    public function getImgAlt()
    {
        return $this->imagen_descripcion;
    }
    public function setImgAlt($imagen_descripcion)
    {
        $this->imagen_descripcion = $imagen_descripcion;
    }

    public function getStock()
    {
        return $this->stock;
    }
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getSubtotal()
    {
        return $this->subtotal;
    }
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }

    public function getEstadoPublicacionFk()
    {
        return $this->estado_publicacion_fk;
    }
    public function setEstadoPublicacionFk($estado_publicacion_fk)
    {
        $this->estado_publicacion_fk = $estado_publicacion_fk;
    }

    public function getEstadoPublicacion(): EstadoPublicacion
    {
        return $this->estado_publicacion;
    }
    public function setEstadoPublicacion(EstadoPublicacion $estado_publicacion): void
    {
        $this->estado_publicacion = $estado_publicacion;
    }

    public function getCategoriaFk()
    {
        return $this->categoria_fk;
    }
    public function setCategoriaFk($categoria_fk)
    {
        $this->categoria_fk = $categoria_fk;
    }

    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }
    public function setCategoria(Categoria $categoria): void
    {
        $this->categoria = $categoria;
    }


    public function getSubcategoriaFk()
    {
        return $this->subcategoria_fk;
    }
    public function setSubcategoriaFk($subcategoria_fk)
    {
        $this->subcategoria_fk = $subcategoria_fk;
    }

    public function getSubcategoria(): Subcategoria
    {
        return $this->subcategoria;
    }
    public function setSubcategoria(Subcategoria $subcategoria): void
    {
        $this->subcategoria = $subcategoria;
    }


    public function getTalleFk()
    {
        return $this->talle_fk;
    }
    public function setTalleFk($talle_fk)
    {
        $this->talle_fk = $talle_fk;
    }

    public function getTalle(): Talle
    {
        return $this->talle;
    }
    public function setTalle(Talle $talle): void
    {
        $this->talle = $talle;
    }

    public function getColores(): array
    {
        return $this->colores;
    }

    public function setColores(array $colores): void
    {
        $this->colores = $colores;
    }

}

?>
