<?php
session_start();
require_once "../../clases/Conexion.php";

if (!isset($_SESSION['tablaComprasTemp'])) {
    $_SESSION['tablaComprasTemp'] = array();
}

$c = new conectar();
$conexion = $c->conexion();

$idcliente = $_POST['clienteVenta'];
$idproducto = $_POST['productoVenta'];
$stock = $_POST['stock'];
$cantidad = $_POST['cantidad'];
$descripcion = $_POST['descripcionV'];
$precio = $_POST['precioV'];

$cantidadRestante = $stock;

foreach ($_SESSION['tablaComprasTemp'] as $item) {
    $datos = explode("||", $item);
    $idProductoArray = $datos[0] ?? null;

    if ($idProductoArray == $idproducto) {
        $cantidadRestante -= $datos[4] ?? 0; // Resta la cantidad del producto en la sesión temporal
        break; // Sale del bucle después de encontrar el producto
    }
}

if ($idcliente != 0) {
    $sql = "SELECT nombre,apellido from clientes where id_cliente='$idcliente'";
    $result = mysqli_query($conexion, $sql);
    $c = mysqli_fetch_row($result);
    $ncliente = $c[0] . " " . $c[1];
} else {
    // Lógica específica cuando se selecciona "Sin cliente"
    $ncliente = " ";
}

$sqlArt = "SELECT articulos.nombre, articulos.id_imagen, imagenes.ruta from articulos
INNER JOIN imagenes ON articulos.id_imagen = imagenes.id_imagen
WHERE articulos.id_producto ='$idproducto'";
$resultArt = mysqli_query($conexion, $sqlArt);
$row = mysqli_fetch_row($resultArt);
$nombreproducto = $row[0];
$imagen = $row[2];

if ($cantidadRestante > 0 && $cantidadRestante >= $cantidad) {
    // Verificar si el producto ya está en el array
    $productoExiste = false;
    $_SESSION['idcliente'] = $idcliente;
    $_SESSION['cliente'] = $ncliente;
    $_SESSION['disponibles'] = $cantidadRestante;

    foreach ($_SESSION['tablaComprasTemp'] as &$item) {
        $datos = explode("||", $item);
        $idProductoArray = $datos[0];

        if ($idProductoArray == $idproducto) {
            // El producto ya existe, actualiza la cantidad y la cantidad restante
            $cantidadTotal = $datos[4] + $cantidad;
            $precioTotal = $precio * $cantidadTotal;
            $item = $datos[0] . "||" . $datos[1] . "||" . $datos[2] . "||" . $precioTotal . "||" . $cantidadTotal . "||" . $datos[5]; // Actualiza la cantidad
            $cantidadRestante -= $cantidad; // Resta la cantidad ingresada de la cantidad restante disponible
            $productoExiste = true;
            break;
        }
    }

    if (!$productoExiste) {
        // El producto no existe, agrega uno nuevo con cantidad 1
        $precioTotal = $precio * $cantidad;
        $articulo = $idproducto . "||" . $nombreproducto . "||" . $descripcion . "||" . $precioTotal . "||" . $cantidad . "||" . $imagen;
        $_SESSION['tablaComprasTemp'][] = $articulo;
    }

    echo 1;

} else {

    echo 0;
}
?>
