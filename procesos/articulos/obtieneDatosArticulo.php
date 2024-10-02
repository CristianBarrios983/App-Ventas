<?php

    require_once "../../clases/Conexion.php";
    require_once "../../clases/Articulos.php";

    $obj= new articulos();

    $idarticulo=$_POST['idarticulo'];

    header('Content-Type: application/json');
    echo json_encode($obj->obtieneDatosArticulo($idarticulo));

?>