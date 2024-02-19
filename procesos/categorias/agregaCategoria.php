<?php
    session_start();
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Categorias.php";

    $fecha=date("Y-m-d");
    $idusuario=$_SESSION['id_usuario'];
    $categoria=$_POST['categoria'];

    $datos=array(
        $idusuario,
        $categoria,
        $fecha
                );

    $obj= new categorias();

    //Llamamos el metodo correspondiente y enviamos los datos

    echo $obj->agregaCategoria($datos);
?>