<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Articulos.php";

    $obj = new articulos();
    $c = new conectar();
    $conexion = $c->conexion();

    if ((isset($_FILES['imagenU'])) && ($_FILES['imagenU']['size'] > 0)) {
        $idArticulo = $_POST['idArticulo'];

        $sql = "SELECT imagenes.id_imagen FROM articulos JOIN imagenes ON articulos.id_imagen=imagenes.id_imagen
        WHERE id_producto='$idArticulo'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_row($result);
        $idimagen = $row[0];

        $nombreImg = $_FILES['imagenU']['name'];
        $rutaAlmacenamiento = $_FILES['imagenU']['tmp_name'];
        $carpeta = '../../archivos/';
        $rutaFinal = $carpeta . $nombreImg;

        // Mueve el archivo y verifica si se realizó correctamente
        $movimientoCorrecto = move_uploaded_file($rutaAlmacenamiento, $rutaFinal);

        if ($movimientoCorrecto) {
            // Si el movimiento fue exitoso, actualiza la imagen y luego el artículo
            $datosImg = array(
                $idimagen, $nombreImg, $rutaFinal
            );

            if ($obj->actualizaImagen($datosImg)) {
                $datos = array(
                    $_POST['idArticulo'],
                    $_POST['categoriaSelectU'],
                    $_POST['nombreU'],
                    $_POST['descripcionU'],
                    $_POST['precioU']
                );
                echo $obj->actualizaArticulo($datos);
            } else {
                // Si hubo un problema al actualizar la imagen
                echo 0;
            }
        } else {
            // Si hubo un problema al mover el archivo
            echo 0;
        }
    } else {
        // Si no se proporcionó una nueva imagen
        $datos = array(
            $_POST['idArticulo'],
            $_POST['categoriaSelectU'],
            $_POST['nombreU'],
            $_POST['descripcionU'],
            $_POST['precioU']
        );

        echo $obj->actualizaArticulo($datos);
    }
?>
