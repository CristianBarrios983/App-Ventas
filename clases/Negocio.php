<?php
	class negocio{
        
		public function registroNegocio($datos){
            $c=new conectar();
            $conexion=$c->conexion();


            $sql="INSERT INTO negocio_info (nombre,direccion,telefono,fechaRegistro) VALUES (?,?,?,?)";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("ssss",$nombre,$direccion,$telefono,$fechaRegistro);

            $nombre=$datos[0];
            $direccion=$datos[1];
            $telefono=$datos[2];
            $fechaRegistro=$datos[3];
                        
            return $stmt->execute();
        }

        public function obtenDatosNegocio($idnegocio){

            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_negocio,nombre,direccion,telefono,fechaRegistro FROM negocio_info WHERE id_negocio = ?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idNegocio);

            $idNegocio=$idnegocio;

            $stmt->execute();

            $result=$stmt->get_result();
            
            $mostrar=$result->fetch_row();

            $datos=array(
                'id_negocio' => $mostrar[0],
                'nombre' => $mostrar[1],
                'direccion' => $mostrar[2],
                'telefono' => $mostrar[3],
                'fechaRegistro' => $mostrar[4]
            );
            return $datos;
        }

        public function actualizaNegocio($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="UPDATE negocio_info SET nombre=?,direccion=?,telefono=? WHERE id_negocio=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("ssss",$nombre,$direccion,$telefono,$idNegocio);

            $nombre=$datos[1];
            $direccion=$datos[2];
            $telefono=$datos[3];
            $idNegocio=$datos[0];

            return $stmt->execute();
        }

        public function eliminaNegocio(){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="DELETE FROM negocio_info";
            $stmt=$conexion->prepare($sql);

            return $stmt->execute();
        }
	}

?>