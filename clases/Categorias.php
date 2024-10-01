<?php
    class categorias{
        public function agregaCategoria($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="INSERT INTO categorias(id_usuario,nombreCategoria,fechaCaptura) VALUES (?,?,?)";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("sss",$idUsuario,$nombre,$fechaRegistro);

            $idUsuario=$datos[0];
            $nombre=$datos[1];
            $fechaRegistro=$datos[2];

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();

            return $result;
        }

        public function actualizaCategoria($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="UPDATE categorias SET nombreCategoria=? WHERE id_categoria=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("ss",$nombreCategoria,$id);

            $nombreCategoria=$datos[1];
            $id=$datos[0];

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();

            return $result;
        }

        public function eliminaCategoria($idcategoria){
            $c = new conectar();
            $conexion = $c->conexion();
        
            // Primero reasignamos los productos a una categoría por defecto, como "Sin categoría"
            // Asegúrate de que existe una categoría con el nombre 'Sin categoría'
            $sqlUpdateProductos = "UPDATE articulos 
                                   SET id_categoria = (SELECT id_categoria FROM categorias WHERE nombreCategoria = 'Sin categoría') 
                                   WHERE id_categoria = ?";
            $stmtUpdate = $conexion->prepare($sqlUpdateProductos);
            $stmtUpdate->bind_param("s", $idCategoria);
            $idCategoria = $idcategoria;
            $stmtUpdate->execute();
            $stmtUpdate->close();
        
            // Después eliminamos la categoría
            $sqlDeleteCategoria = "DELETE FROM categorias WHERE id_categoria = ?";
            $stmtDelete = $conexion->prepare($sqlDeleteCategoria);
            $stmtDelete->bind_param("s", $idCategoria);
            $result = $stmtDelete->execute();
        
            $stmtDelete->close();
            $conexion->close();
        
            return $result;
        }
        
    }
?>