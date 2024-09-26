<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    header('Content-Type: application/json'); // Establece el encabezado de tipo de contenido a JSON

    $obj = new ventas();
    echo json_encode($obj->buscarProductoPorNombre($_POST['nombreProducto']));
?>
