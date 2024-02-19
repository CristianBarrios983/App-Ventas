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
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcionV'];
    $precio = $_POST['precioV'];
    
    $cantidadRestante = $cantidad;
    
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
        $ncliente = $c[1] . " " . $c[0];
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
    
    if ($cantidadRestante > 0) {
        // Verificar si el producto ya está en el array
        $productoExiste = false;
        $_SESSION['idcliente'] = $idcliente;
        $_SESSION['cliente'] = $ncliente;
        $_SESSION['disponibles'] = $cantidadRestante;
    
        foreach ($_SESSION['tablaComprasTemp'] as &$item) {
            $datos = explode("||", $item);
            $idProductoArray = $datos[0];
    
            if ($idProductoArray == $idproducto) {
                // El producto ya existe, actualiza la cantidad
                $datos[4] += 1; // Suma 1 a la cantidad existente
                $datos[3] = ($datos[3] / ($datos[4] - 1)) * $datos[4]; // Modificar precio por cantidad
                $item = implode("||", $datos);
                $productoExiste = true;
                break;
            }
        }
    
        if (!$productoExiste) {
            // El producto no existe, agrega uno nuevo con cantidad 1
            $cantidad = 1;
            $articulo = $idproducto . "||" .
                $nombreproducto . "||" .
                $descripcion . "||" .
                $precio . "||" .
                $cantidad . "||" .
                $imagen;
    
            $_SESSION['tablaComprasTemp'][] = $articulo;
        }
    
        echo 1;
        
    } else {

        echo 0;
    }
    
?>