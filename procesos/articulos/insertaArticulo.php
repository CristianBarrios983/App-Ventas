<?php
    session_start();
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Articulos.php";

    $obj= new articulos();

    $idusuario=$_SESSION['id_usuario'];

    $datos=array();

    $nombreImg=$_FILES['imagen']['name'];
    $rutaAlmacenamiento=$_FILES['imagen']['tmp_name'];
    $carpeta='../../archivos/';
    $rutaFinal=$carpeta.$nombreImg;

        if(move_uploaded_file($rutaAlmacenamiento, $rutaFinal)){

            $datosImg=array(
                $nombreImg, $rutaFinal
            );

            $idimagen=$obj->agregaImagen($datosImg);

            if($idimagen > 0){
                $datos[0]=$_POST['categoriaSelect'];
                $datos[1]=$idimagen;
                $datos[2]=$idusuario;
                $datos[3]=$_POST['nombre'];
                $datos[4]=$_POST['descripcion'];
                $datos[5]=$_POST['cantidad'];
                $datos[6]=$_POST['precio'];
                
                echo $obj->insertaArticulo($datos);
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
?>