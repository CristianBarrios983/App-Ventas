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
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="DELETE FROM categorias WHERE id_categoria=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idCategoria);
            
            $idCategoria=$idcategoria;

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();

            return $result;
        }
    }
?>