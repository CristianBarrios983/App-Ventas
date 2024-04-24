<?php
    class usuarios{

        public function registroUsuario($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="INSERT INTO usuarios (rol,nombre,apellido,usuario,email,password,fechaCaptura) VALUES (?,?,?,?,?,?,?)";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("sssssss",$rol,$nombre,$apellido,$usuario,$email,$password,$fecha);

            $rol=$datos[0];
            $nombre=$datos[1];
            $apellido=$datos[2];
            $usuario=$datos[3];
            $email=$datos[4];
            $password=$datos[5];
            $fecha=date('Y-m-d');

            return $stmt->execute();
        }

        public function loginUsuario($datos){
            $c=new conectar();
            $conexion=$c->conexion();
            
            $sql="SELECT * FROM usuarios WHERE (usuario=? OR email=?) AND password=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("sss",$credencial,$credencial,$password);
            $credencial=$datos[0];
            $password=sha1($datos[1]);

            //Ejecuto mi consulta
            $stmt->execute();

            //Obtengo los resultados
            $result=$stmt->get_result();

            if($result->num_rows > 0){
                $datosUsuario = $result->fetch_row();

                $_SESSION['usuario']=$datosUsuario[2]." ".$datosUsuario[3];
                $_SESSION['id_usuario']=self::traerID($datos);
                $_SESSION['rol']=self::traerRoles($_SESSION['id_usuario']);
                
                return 1;
            }else{
                return 0;
            }
        }

        public function traerID($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_usuario from usuarios where (usuario=? OR email=?)
            and password=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("sss",$credencial,$credencial,$password);

            $credencial=$datos[0];
            $password=sha1($datos[1]);

            $stmt->execute();

            $result=$stmt->get_result();

            $idUsuario = $result->fetch_row();

            return $idUsuario[0];
        }

        public function obtenerDatosUsuario($idusuario){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_usuario,nombre,apellido,usuario,email,rol FROM usuarios 
                                        WHERE id_usuario= ? ";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idUsuario);
            $idUsuario=$idusuario;

            $stmt->execute();

            $result=$stmt->get_result();

            $mostrar = $result->fetch_row();

            $datos=array(
                'id_usuario' => $mostrar[0],
                'nombre' => $mostrar[1], 
                'apellido' => $mostrar[2],
                'usuario' => $mostrar[3],
                'email' => $mostrar[4],
                'id_rol' => $mostrar[5]
            );

            return $datos;
        }

        public function actualizaUsuario($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="UPDATE usuarios SET nombre=?,apellido=?,usuario=?,email=?,rol=? WHERE id_usuario=? ";

            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("ssssss",$nombre,$apellido,$usuario,$email,$rol,$id);

            $id=$nombre=$datos[0];
            $nombre=$datos[1];
            $apellido=$datos[2];
            $usuario=$datos[3];
            $email=$datos[4];
            $rol=$datos[5];

            return $stmt->execute();

        }

        public function eliminaUsuario($idusuario){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="DELETE FROM usuarios WHERE id_usuario=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$id);

            $id=$idusuario;

            return $stmt->execute();
        }

        public function traerRoles($iduser){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="SELECT roles.rol from usuarios 
            INNER JOIN roles ON roles.id_rol = usuarios.rol
            where id_usuario= ?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idUsuario);

            $idUsuario=$iduser;

            $stmt->execute();

            $result=$stmt->get_result();

            $rolUsuario = $result->fetch_row();

            return $rolUsuario[0];
        }

        public function obtenerRolesUsuario(){
            $c=new conectar();
            $conexion=$c->conexion();
        
            $sql="SELECT id_rol,rol FROM roles";
            $stmt=$conexion->prepare($sql);
            
            $stmt->execute();
            $result=$stmt->get_result();
        
            $roles = array();
        
            while($mostrar = $result->fetch_row()) {
                $roles[] = array(
                    'id_rol' => $mostrar[0],
                    'rol' => $mostrar[1]
                );
            }
        
            return $roles;
        }        
    }
?>