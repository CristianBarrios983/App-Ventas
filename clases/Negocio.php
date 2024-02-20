<?php
	class negocio{
		public function registroNegocio($datos){
            $c=new conectar();
            $conexion=$c->conexion();


            $sql="INSERT into negocio_info (nombre,
                                direccion,
                                telefono,
                                fechaRegistro)
                        values ('$datos[0]',
                                '$datos[1]',
                                '$datos[2]',
                                '$datos[3]')";
                        
            return mysqli_query($conexion,$sql);
        }

        public function obtenDatosNegocio($idnegocio){

            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_negocio,nombre,direccion,telefono,fechaRegistro from negocio_info where                                                         id_negocio = '$idnegocio'";
            $result=mysqli_query($conexion,$sql);

            $mostrar=mysqli_fetch_row($result);

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

            $sql="UPDATE negocio_info set nombre='$datos[1]',
                                        direccion='$datos[2]',
                                        telefono='$datos[3]'
                                        where id_negocio='$datos[0]'";
            return mysqli_query($conexion,$sql);
        }

        public function eliminaNegocio(){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="TRUNCATE negocio_info";

            return mysqli_query($conexion,$sql);
        }
	}

?>