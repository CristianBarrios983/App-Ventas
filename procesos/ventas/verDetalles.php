<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    $obj= new ventas();

    $idVenta=$_POST['idVenta'];

    // Devolver los detalles de la venta en formato JSON
    echo json_encode($obj->verDetalles($idVenta));
    exit;
?>