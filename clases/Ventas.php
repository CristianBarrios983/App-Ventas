<?php
    class ventas{
        public function obtenDatosProducto($idproducto){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="SELECT art.nombre,
                            art.descripcion,
                            art.cantidad,
                            img.ruta,
                            art.precio 
                            from articulos as art 
                            inner join imagenes as img 
                            on art.id_imagen=img.id_imagen
                            and art.id_producto='$idproducto'";
            $result=mysqli_query($conexion,$sql);
            $mostrar=mysqli_fetch_row($result);

            $d=explode('/', $mostrar[3]);
            $img=$d[1].'/'.$d[2].'/'.$d[3];

            $datos=array(
                'nombre' => $mostrar[0],
                'descripcion' => $mostrar[1],
                'cantidad' => $mostrar[2],
                'ruta' => $img,
                'precio' => $mostrar[4]
            );
            return $datos;
        }

        public function crearVenta(){
            $c= new conectar();
            $conexion=$c->conexion();

            $fecha=date('Y-m-d');
            $idventa=self::crearFolio();
            $datos=$_SESSION['tablaComprasTemp'];
            $idusuario=$_SESSION['id_usuario'];
<<<<<<< HEAD
            $idCliente = $_SESSION['idcliente'];
            $r=0;

            // Calcular el total de la venta
            $totalVenta = 0;
            for ($i = 0; $i < count($datos); $i++) {
                $d = explode("||", $datos[$i]);
                $totalVenta += $d[3]; // Precio * Cantidad
            }

            $sqlVentas = "INSERT INTO ventas (id_venta,id_cliente,id_usuario,total,fechaCompra) 
                    VALUES ('$idventa','$idCliente','$idusuario','$totalVenta','$fecha')";
            $resultVentas = mysqli_query($conexion,$sqlVentas);

            if($resultVentas){

                for ($i=0; $i < count($datos) ; $i++){
                    $d=explode("||", $datos[$i]);
    
                    $sqlDetalles="INSERT into detalles (venta,
                                                producto,
                                                cantidad,
                                                precio)
                                        VALUES ('$idventa',
                                                '$d[0]',
                                                '$d[4]',
                                                '$d[3]')";
                    $resultDetalles=mysqli_query($conexion,$sqlDetalles);

                    if($resultDetalles){
                        self::descuentaCantidad($d[0],$d[4]);
                        $r++;
                    }else{
                        echo "Error al registrar detalle" . mysqli_error($conexion);
                    }
                }
            
            }else{
                echo "Erro al insertar la venta" . mysqli_error($conexion);
            }

            unset($_SESSION['idcliente']);
            unset($_SESSION['cliente']);

=======
            $r=0;

            for ($i=0; $i < count($datos) ; $i++){
                $d=explode("||", $datos[$i]);

                $sql="INSERT into ventas (id_venta,
                                            id_cliente,
                                            id_producto,
                                            id_usuario,
                                            precio,
                                            fechaCompra)
                                    values ('$idventa',
                                            '$d[5]',
                                            '$d[0]',
                                            '$idusuario',
                                            '$d[3]',
                                            '$fecha')";
                $r=$r + $result=mysqli_query($conexion,$sql);
                self::descuentaCantidad($d[0],1);
            }
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
            return $r;
        }

        public function crearFolio(){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_venta from ventas group by id_venta desc";

            $result=mysqli_query($conexion,$sql);
            $id=mysqli_fetch_row($result)[0];

            if($id=="" or $id==null or $id==0){
                return 1;
            }else{
                return $id + 1;
            }
        }

        public function nombreCliente($idCliente){
            $c= new conectar();
            $conexion=$c->conexion();

<<<<<<< HEAD
            $sql="SELECT nombre,apellido from clientes where id_cliente='$idCliente'";
=======
            $sql="SELECT apellido,nombre from clientes where id_cliente='$idCliente'";
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
            $result=mysqli_query($conexion,$sql);

            $mostrar=mysqli_fetch_row($result);

<<<<<<< HEAD
            if(!$mostrar==null){
                return $mostrar[0]." ".$mostrar[1];
            }else{
                return " ";
            }
=======
            return $mostrar[0]." ".$mostrar[1];
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
        }

        public function obtenerTotal($idventa){
            $c= new conectar();
            $conexion=$c->conexion();

<<<<<<< HEAD
            $sql="SELECT total from ventas where id_venta='$idventa'";
=======
            $sql="SELECT precio from ventas where id_venta='$idventa'";
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
            $result=mysqli_query($conexion,$sql);

            $total=0;

            while($mostrar=mysqli_fetch_row($result)){
                $total=$total + $mostrar[0];
            }

            return $total;
        }


        public function descuentaCantidad($idproducto,$cantidad){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT cantidad from articulos where id_producto='$idproducto'";
            $result=mysqli_query($conexion,$sql);

            $cantidad1=mysqli_fetch_row($result)[0];

            $cantidadNueva=abs($cantidad - $cantidad1);

            $sql="UPDATE articulos set cantidad='$cantidadNueva' where id_producto='$idproducto'";

            mysqli_query($conexion,$sql);
        }
    }
?>