<?php
    session_start();
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Negocio.php";

    $obj= new negocio();

    $fecha=date('Y-m-d');

    $datos=array(
        $_POST['nombreNegocio'],
        $_POST['direccionNegocio'],
        $_POST['telefonoNegocio'],
        $fecha
        );

    echo $obj->registroNegocio($datos);
?>