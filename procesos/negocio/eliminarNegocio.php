<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Negocio.php";

    $obj= new negocio();

    echo $obj->eliminaNegocio();

?>