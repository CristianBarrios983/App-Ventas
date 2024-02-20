<?php

    session_start();
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Negocio.php";

    $obj= new negocio();

    $datos=array(
        $_POST['idnegocioU'],
        $_POST['nombreU'],
        $_POST['direccionU'],
        $_POST['telefonoU']
    );
    
    echo $obj->actualizaNegocio($datos);

?>