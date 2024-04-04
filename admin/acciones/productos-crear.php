<?php 
use App\Auth\Autenticacion;
use App\Models\Producto;
use Intervention\Image\ImageManagerStatic as Image;


session_start();

require_once __DIR__ . "/../../bootstrap/autoload.php";

if(!(new Autenticacion)->estaAutenticado()){
    $_SESSION['mensajeError'] = 'Se requiere iniciar sesión para ver este contenido';
    header('Location: ../index.php?s=iniciar-sesion');
    exit;
}

$nombre                 = $_POST['nombre'];
$descripcion            = $_POST['descripcion'];
$imagen_descripcion     = $_POST['imagen_descripcion'];
$imagen_grande_01       = $_FILES['imagen_grande_01'];
$precio                 = $_POST['precio'];
$stock                  = $_POST['stock'];
$estado_publicacion_fk  = $_POST['estado_publicacion_fk'];
$categoria_fk           = $_POST['categoria_fk'];
$subcategoria_fk        = $_POST['subcategoria_fk'];
$talle_fk               = $_POST['talle_fk'];
$colores_fks            = $_POST['color_fk'] ?? [];


$errores = [];
if(empty($nombre)){
    $errores['nombre'] = "El producto debe tener un nombre.";
}
if(empty($descripcion)){
    $errores['descripcion'] = "El producto debe tener una descripción.";
}
if(empty($imagen_descripcion)){
    $errores['imagen_descripcion'] = "La imagen del producto debe tener una descripción.";
}
if(empty($imagen_grande_01['tmp_name'])){
    $errores['imagen_grande_01'] = "El producto debe tener una imagen.";
}

if(empty($precio)){
    $errores['precio'] = "Se debe indicar el precio del producto.";
}
if(empty($stock)){
    $errores['stock'] = "Se debe indicar el stock del producto.";
}
if(empty($estado_publicacion_fk)){
    $errores['estado_publicacion_fk'] = "Se debe indicar el estado de publicación del producto.";
}
if(empty($categoria_fk)){
    $errores['categoria_fk'] = "Se debe indicar la categoría del producto.";
}
if(empty($subcategoria_fk)){
    $errores['subcategoria_fk'] = "Se debe indicar la subcategoría del producto.";
}
if(empty($talle_fk)){
    $errores['talle_fk'] = "Se debe indicar el talle del producto.";
}
if(empty($colores_fks)){
    $errores['colores_fks'] = "Se debe indicar al menos 1 color";
}

if(count($errores) > 0){

    $_SESSION['errores'] = $errores;

    $_SESSION['oldData'] = $_POST;

    header("Location: ../index.php?s=producto-crear");
    exit;
}


if(!empty($imagen_grande_01['tmp_name'])){
    $nombreImgGrande01 = date('YmdHis') . "_" . $imagen_grande_01['name'];
    
    $imgGrande = Image::make($imagen_grande_01['tmp_name'])
        ->resize(450, 392, function($constraint){
            $constraint->aspectRatio();
        })
        ->save(__DIR__ . '/../../styles/img/editadas/big-' . $nombreImgGrande01);


    $imgGrande = Image::make($imagen_grande_01['tmp_name'])
        ->resize(110, 80, function($constraint){
            $constraint->aspectRatio();
        })
        ->save(__DIR__ . '/../../styles/img/editadas/lit-' . $nombreImgGrande01);


    $imgGrande = Image::make($imagen_grande_01['tmp_name'])
        ->resize(280, 245, function($constraint){
            $constraint->aspectRatio();
        })
        ->save(__DIR__ . '/../../styles/img/editadas/med-' . $nombreImgGrande01);

}

try {
    (new Producto)->crear([
        'nombre'                =>$nombre,
        'descripcion'           =>$descripcion,
        'imagen_grande_01'      =>$nombreImgGrande01 ?? null,
        'imagen_descripcion'    =>$imagen_descripcion,
        'precio'                =>$precio,
        'stock'                 =>$stock,
        'categoria_fk'          =>$categoria_fk,
        'subcategoria_fk'       =>$subcategoria_fk,
        'talle_fk'              =>$talle_fk,
        'estado_publicacion_fk' =>$estado_publicacion_fk,
        'colores_fks'           =>$colores_fks,

    ]);
    
    $_SESSION['mensajeExito'] = "El producto <b>" . $nombre . "</b> fue creado con éxito.";
    //Redireccionamos la pagina
    header("Location: ../index.php?s=productos");
    exit;

} catch(Exception $e) {

    $_SESSION['mensajeError'] = 'Ocurrió un problema inesperado al tratar de publicar el producto. Probá de nuevo mas tarde. Si el problema persiste, comunicate con nosotros.' . $e->getMessage();
    $_SESSION['oldData'] = $_POST;    
    
    header("Location: ../index.php?s=producto-crear");
    exit;

} 