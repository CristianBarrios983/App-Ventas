<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // // Agrega mensajes de depuración
    // echo "VerDetalles.php está siendo ejecutado";


    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    $obj= new ventas();

    $idVenta=$_POST['idVenta'];

    // Devolver los detalles de la venta en formato JSON
    //  header('Content-Type: application/json');
    echo json_encode($obj->verDetalles($idVenta));
    exit;
?>