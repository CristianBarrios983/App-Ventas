<?php
    session_start();
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Usuarios.php";

    $obj= new usuarios();

    $datos=array(
        $_POST['credencial'],
        $_POST['password']
    );

    echo $obj->loginUsuario($datos);
?>