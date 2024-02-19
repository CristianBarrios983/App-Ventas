<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Negocio.php";

    $obj= new negocio();

    echo json_encode($obj->obtenDatosNegocio($_POST['idnegocio']));
?>