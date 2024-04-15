<?php
    class usuarios{
        public function registroUsuario($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $fecha=date('Y-m-d');

            $sql="INSERT into usuarios (rol,
                                nombre,
                                apellido,
                                usuario,
                                email,
                                password,
                                fechaCaptura)
                        values ('$datos[0]',
                                '$datos[1]',
                                '$datos[2]',
                                '$datos[3]',
                                '$datos[4]',
                                '$datos[5]',
                                '$fecha')";
            return mysqli_query($conexion,$sql);
        }
        public function loginUsuario($datos){
            $c=new conectar();
            $conexion=$c->conexion();
            $password=sha1($datos[1]);


            $sql="SELECT * FROM usuarios WHERE (usuario='$datos[0]' OR email='$datos[0]') AND password='$password'";
            $result=mysqli_query($conexion,$sql);

            if(mysqli_num_rows($result) > 0){
                $datosUsuario = mysqli_fetch_row($result);

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

            $password=sha1($datos[1]);

            $sql="SELECT id_usuario from usuarios where (usuario='$datos[0]' OR email='$datos[0]')
            and password='$password'";

            $result=mysqli_query($conexion,$sql);
            return mysqli_fetch_row($result)[0];
        }
        public function obtenerDatosUsuario($idusuario){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_usuario,nombre,apellido,usuario,email,rol from usuarios 
                                        where id_usuario='$idusuario'";

            $result=mysqli_query($conexion,$sql);

            $mostrar=mysqli_fetch_row($result);

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

            $sql="UPDATE usuarios set nombre='$datos[1]',
                                        apellido='$datos[2]',
                                        usuario='$datos[3]',
                                        email='$datos[4]',
                                        rol='$datos[5]'
                                        where id_usuario='$datos[0]' ";
            return mysqli_query($conexion,$sql);

        }
        public function eliminaUsuario($idusuario){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="DELETE from usuarios where id_usuario='$idusuario'";

            return mysqli_query($conexion,$sql);
        }
        public function traerRoles($iduser){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="SELECT roles.rol from usuarios 
            INNER JOIN roles ON roles.id_rol = usuarios.rol
            where id_usuario='$iduser'";
            $result=mysqli_query($conexion,$sql);

            return mysqli_fetch_row($result)[0];
        }

        public function obtenerRolesUsuario(){
            $c=new conectar();
            $conexion=$c->conexion();
        
            $sql="SELECT id_rol,rol FROM roles";
        
            $result=mysqli_query($conexion,$sql);
        
            $roles = array();
        
            while($mostrar=mysqli_fetch_row($result)) {
                $roles[] = array(
                    'id_rol' => $mostrar[0],
                    'rol' => $mostrar[1]
                );
            }
        
            return $roles;
        }        
    }
?>