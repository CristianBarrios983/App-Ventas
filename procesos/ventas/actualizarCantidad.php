<?php
    session_start();
    require_once "../../clases/Conexion.php";
    
    if (isset($_POST['indice']) && isset($_POST['nuevaCantidad']) && isset($_POST['idProducto'])) {
        $indice = $_POST['indice'];
        $nuevaCantidad = $_POST['nuevaCantidad'];
        $idProducto = $_POST['idProducto'];

        // Consulta para obtener la cantidad del producto
        $c = new conectar();
        $conexion = $c->conexion();

        $sql = "SELECT cantidad, precio FROM articulos WHERE id_producto = '$idProducto'";
        $result = mysqli_query($conexion, $sql);
        $datosP = mysqli_fetch_row($result);

        $stock = $datosP[0];
        $precio = $datosP[1];


        // Se actualiza la cantidad del carrito
        if ($nuevaCantidad > 0 && $stock >= $nuevaCantidad) {
            // Verifica el producto en el array para cambiar la cantidad
            foreach ($_SESSION['tablaComprasTemp'] as &$item) {
                $datos = explode("||", $item);
                $idProductoArray = $datos[0];
        
                if ($idProductoArray == $idProducto) {
                    // El producto ya existe, actualiza la cantidad y la cantidad restante
                    $cantidadTotal = $nuevaCantidad;
                    $precioTotal = $precio * $cantidadTotal;
                    $item = $datos[0] . "||" . $datos[1] . "||" . $datos[2] . "||" . $precioTotal . "||" . $cantidadTotal . "||" . $datos[5]; // Actualiza la cantidad
                    break;
                }
            }

            echo 1;
        }else{
            echo 0;
        } 
    } else {
        echo 2;
    }
?>
