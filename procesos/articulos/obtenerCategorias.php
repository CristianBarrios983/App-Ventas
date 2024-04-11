<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Articulos.php";

    $obj= new articulos;

    echo json_encode($obj->obtenerCategorias());
?>