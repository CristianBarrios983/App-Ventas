<?php
    class clientes{

        public function agregaClientes($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="INSERT INTO clientes (id_usuario,nombre,apellido,direccion,email,telefono) VALUES (?,?,?,?,?,?)";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("ssssss",$idUsuario,$nombre,$apellido,$direccion,$email,$telefono);

            $idUsuario=$_SESSION['id_usuario'];
            $nombre=$datos[0];
            $apellido=$datos[1];
            $direccion=$datos[2];
            $email=$datos[3];
            $telefono=$datos[4];

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();

            return $result;
        }

        public function obtenDatosCliente($idcliente){

            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_cliente,nombre,apellido,direccion,email,telefono FROM clientes WHERE id_cliente = ?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idCliente);

            $idCliente=$idcliente;

            $stmt->execute();
            $result=$stmt->get_result();

            $mostrar=$result->fetch_row();

            $datos=array(
                'id_cliente' => $mostrar[0],
                'nombre' => $mostrar[1],
                'apellido' => $mostrar[2],
                'direccion' => $mostrar[3],
                'email' => $mostrar[4],
                'telefono' => $mostrar[5]
            );

            $stmt->close();
            $conexion->close();

            return $datos;
        }

        public function actualizaCliente($datos){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="UPDATE clientes SET nombre=?,apellido=?,direccion=?,email=?,telefono=? WHERE id_cliente=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("ssssss",$nombre,$apellido,$direccion,$email,$telefono,$idCliente);

            $nombre=$datos[1];
            $apellido=$datos[2];
            $direccion=$datos[3];
            $email=$datos[4];
            $telefono=$datos[5];
            $idCliente=$datos[0];

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();

            return $result;
        }

        public function eliminaCliente($idcliente){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="DELETE from clientes where id_cliente=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idCliente);

            $idCliente=$idcliente;

            $result=$stmt->execute();

            $stmt->close();
            $conexion->close();

            return $result;
        }
    }
?>