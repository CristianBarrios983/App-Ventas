<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Articulos.php";

    $obj= new articulos();

    $cant = $_POST['cantidadU'] + $_POST['cantidadA'];

    $datos=array(
        $_POST['idArticulo'],
        $cant
    );

    echo $obj->actualizaStock($datos);

?>