<?php
    class articulos{

        public function agregaImagen($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="INSERT INTO imagenes (nombre,ruta,fechaSubida) VALUES (?,?,?)";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("sss",$nombre,$ruta,$fechaSubida);

            $nombre=$datos[0];
            $ruta=$datos[1];
            $fechaSubida=date("Y-m-d");

            $stmt->execute();

            $idInsertado=$stmt->insert_id;

            $stmt->close();
            $conexion->close();

            return $idInsertado;
        }
        public function actualizaImagen($datos) {
            $c = new conectar();
            $conexion = $c->conexion();
                
            $sql = "UPDATE imagenes SET nombre=?,
                                        ruta=?,
                                        fechaSubida=?
                                        WHERE id_imagen=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("ssss",$nombre,$ruta,$fechaSubida,$idImagen);

            $nombre=$datos[1];
            $ruta=$datos[2];
            $fechaSubida = date("Y-m-d");
            $idImagen=$datos[0];

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();
        
            return $result;
        }
        public function insertaArticulo($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="INSERT INTO articulos (id_categoria,id_imagen,id_usuario,nombre,descripcion,cantidad,precio,fechaCaptura) VALUES (?,?,?,?,?,?,?,?)";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("ssssssss",$idCategoria,$idImagen,$idUsuario,$nombre,$descripcion,$cantidad,$precio,$fechaRegistro);

            $idCategoria=$datos[0];
            $idImagen=$datos[1];
            $idUsuario=$datos[2];
            $nombre=$datos[3];
            $descripcion=$datos[4];
            $cantidad=$datos[5];
            $precio=$datos[6];
            $fechaRegistro=date("Y-m-d");

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();

            return $result;
        }
        public function obtieneDatosArticulo($iarticulo){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_producto,
                            id_categoria,
                            nombre,
                            descripcion,
                            cantidad,
                            precio
                            FROM articulos WHERE id_producto=?";

            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idArticulo);

            $idArticulo=$idarticulo;

            $stmt->execute();

            $result=$stmt->get_result();

            $mostrar=$result->fetch_row();

            $datos=array(
                "id_producto" => $mostrar[0],
                "id_categoria" => $mostrar[1],
                "nombre" => $mostrar[2],
                "descripcion" => $mostrar[3],
                "cantidad" => $mostrar[4],
                "precio" => $mostrar[5]
            );

            $stmt->close();
            $conexion->close();

            return $datos;
        }
        public function actualizaArticulo($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="UPDATE articulos SET id_categoria=?,
                                        nombre=?,
                                        descripcion=?,
                                        precio=?
                                        WHERE id_producto=?";

            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("sssss",$idCategoria,$nombre,$descripcion,$precio,$idProducto);

            $idCategoria=$datos[1];
            $nombre=$datos[2];
            $descripcion=$datos[3];
            $precio=$datos[4];
            $idProducto=$datos[0];

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();

            return $result;
        }

        public function eliminaArticulo($idarticulo){
            $c = new conectar();
            $conexion = $c->conexion();
        
            // Llama a obtenerIdImg usando la instancia actual del objeto
            $idImagen = $this->obtenerIdImg($idarticulo);
        
            // En lugar de eliminar físicamente el producto, solo cambiamos su estado a 0 (inactivo)
            $sql = "UPDATE articulos SET estado=0 WHERE id_producto=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $idProducto);
        
            $idProducto = $idarticulo;
            
            $result = $stmt->execute();
        
            // Si se "eliminó" lógicamente el producto, no eliminamos la imagen, solo retornamos éxito.
            if($result){
                $stmt->close();
                $conexion->close();
                return 1; // Operación exitosa, pero sin eliminar la imagen
            }
        
            $stmt->close();
            $conexion->close();
            return 0; // Si falló la operación
        }
        
        
        public function obtenerIdImg($idProducto){
            $c = new conectar();
            $conexion = $c->conexion();
        
            $sql = "SELECT id_imagen FROM articulos WHERE id_producto=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $idProducto);
        
            $idProducto = $idProducto;
        
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            $idImagen = $result->fetch_row()[0];

            $stmt->close();
            $conexion->close();
        
            return $idImagen;
        }
        
        public function obtenerRutaImagen($idImg){
            $c = new conectar();
            $conexion = $c->conexion();
        
            $sql = "SELECT ruta FROM imagenes WHERE id_imagen=?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $idImagen);
        
            $idImagen = $idImg;
        
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            $rutaImagen = $result->fetch_row()[0];

            $stmt->close();
            $conexion->close();
        
            return $rutaImagen;
        }
        

        public function actualizaStock($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="UPDATE articulos set cantidad=?
                                        where id_producto=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("ss",$cantidad,$idProducto);

            $cantidad=$datos[1];
            $idProducto=$datos[0];

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();

            return $result;
        }

        public function obtenerCategorias(){
            $c=new conectar();
            $conexion=$c->conexion();
        
            $sql="SELECT id_categoria, nombreCategoria FROM categorias";
            $stmt=$conexion->prepare($sql);


            $stmt->execute();

            $result=$stmt->get_result();
                
            $categorias = array();
        
            while($mostrar=$result->fetch_row()) {
                $categorias[] = array(
                    'id_categoria' => $mostrar[0],
                    'categoria' => $mostrar[1]
                );
            }

            $stmt->close();
            $conexion->close();
        
            return $categorias;
        }
    }
?>