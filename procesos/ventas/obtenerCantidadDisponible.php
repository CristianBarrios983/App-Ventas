<?php
    session_start();

    if (!isset($_SESSION['tablaComprasTemp'])) {
        $_SESSION['tablaComprasTemp'] = array();
    }

    require_once "../../clases/Conexion.php";
    $c = new conectar();
    $conexion = $c->conexion();

    $sql="SELECT cantidad FROM articulos WHERE id_producto=?";
    $stmt=$conexion->prepare($sql);
    $stmt->bind_param("s",$idProducto);

    $idProducto = $_POST['idproducto'];

    $stmt->execute();

    $result=$stmt->get_result();
    $row=$result->fetch_row();
    $cantidad=$row[0];

    $cantidadRestante = $cantidad;

    // Descuenta la cantidad 
    foreach ($_SESSION['tablaComprasTemp'] as $item) {
        $datos = explode("||", $item);
        $idProductoArray = $datos[0] ?? null;
        
        if ($idProductoArray == $idProducto) {
            $cantidadRestante -= $datos[4] ?? 0; // Resta la cantidad del producto en la sesión temporal
            break; // Sale del bucle después de encontrar el producto
        }
    }

    echo $cantidadRestante;
?>