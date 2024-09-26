<?php
    class ventas{
        public function buscarProductoPorNombre($nombreProducto) {
            $c = new conectar();
            $conexion = $c->conexion();
        
            $sqlProducto = "SELECT id_producto, nombre, descripcion FROM articulos WHERE nombre LIKE ?";
            $stmt = $conexion->prepare($sqlProducto);
            $likeNombre = "%" . $nombreProducto . "%";
            $stmt->bind_param("s", $likeNombre);
            $stmt->execute();
            $resultProducto = $stmt->get_result();
        
            $productos = array();
        
            while ($producto = $resultProducto->fetch_assoc()) {
                $productos[] = $producto;
            }
            
            return $productos;
        }
        

        public function obtenDatosProducto($idproducto){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="SELECT art.nombre,
                            art.descripcion,
                            art.cantidad,
                            img.ruta,
                            art.precio 
                            FROM articulos AS art 
                            INNER JOIN imagenes AS img 
                            ON art.id_imagen=img.id_imagen
                            AND art.id_producto=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idProducto);

            $idProducto=$idproducto;

            $stmt->execute();

            $result=$stmt->get_result();
            $mostrar=$result->fetch_row();

            $d=explode('/', $mostrar[3]);
            $img=$d[1].'/'.$d[2].'/'.$d[3];

            $datos=array(
                'nombre' => $mostrar[0],
                'descripcion' => $mostrar[1],
                'cantidad' => $mostrar[2],
                'ruta' => $img,
                'precio' => $mostrar[4]
            );

            $stmt->close();
            $conexion->close();

            return $datos;
        }

        public function crearVenta(){
            $c= new conectar();
            $conexion=$c->conexion();

            $datos=$_SESSION['tablaComprasTemp'];
            
            $r=0;

            // Calcular el total de la venta
            $totalVenta = 0;
            for ($i = 0; $i < count($datos); $i++) {
                $d = explode("||", $datos[$i]);
                $totalVenta += $d[3]; // Precio * Cantidad
            }

            $sqlVentas = "INSERT INTO ventas (id_cliente,id_usuario,total,fechaCompra) 
                    VALUES (?,?,?,?)";
            $stmt=$conexion->prepare($sqlVentas);
            $stmt->bind_param("ssss",$idCliente,$idUsuario,$totalVenta,$fechaVenta);

            $idCliente = $_SESSION['idcliente'];
            $idUsuario= $_SESSION['id_usuario'];
            $totalVenta=$totalVenta;
            $fechaVenta=date('Y-m-d');

            $resultVentas = $stmt->execute();

            if($resultVentas){

                $idventa = $stmt->insert_id;

                for ($i=0; $i < count($datos) ; $i++){
                    $d=explode("||", $datos[$i]);
    
                    $sqlDetalles="INSERT INTO detalles (venta,
                                                producto,
                                                cantidad,
                                                precio)
                                        VALUES (?,?,?,?)";
                    $stmt2=$conexion->prepare($sqlDetalles);
                    $stmt2->bind_param("ssss",$idVenta,$producto,$cantidad,$precio);

                    $idVenta=$idventa;
                    $producto=$d[0];
                    $cantidad=$d[4];
                    $precio=$d[3];

                    $resultDetalles=$stmt2->execute();

                    if($resultDetalles){
                        self::descuentaCantidad($producto,$cantidad);
                        $r++;
                    }else{
                        $stmt->close();
                        $stmt2->close();
                        $conexion->close();
                        echo "Error al registrar detalle" . mysqli_error($conexion);
                    }
                }
            
            }else{
                $stmt->close();
                $conexion->close();
                echo "Error al insertar la venta" . mysqli_error($conexion);
            }

            unset($_SESSION['idcliente']);
            unset($_SESSION['cliente']);

            $stmt->close();
            $stmt2->close();
            $conexion->close();

            return $r;
        }

        public function nombreCliente($idCliente){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT nombre,apellido FROM clientes WHERE id_cliente=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idCliente);

            $idCliente=$idCliente;

            $stmt->execute();

            $result=$stmt->get_result();

            $mostrar=$result->fetch_row();

            if(!$mostrar==null){

                $stmt->close();
                $conexion->close();
                return $mostrar[0]." ".$mostrar[1];

            }else{

                $stmt->close();
                $conexion->close();
                return " ";

            }
        }

        public function obtenerTotal($idventa){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT total FROM ventas WHERE id_venta=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idVenta);

            $idVenta=$idventa;

            $stmt->execute();

            $result=$stmt->get_result();

            $total=0;

            while($mostrar=$result->fetch_row()){
                $total=$total + $mostrar[0];
            }

            $stmt->close();
            $conexion->close();

            return $total;
        }


        public function descuentaCantidad($idproducto,$cantidad){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT cantidad from articulos where id_producto=?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idProducto);

            $idProducto=$idproducto;

            $stmt->execute();

            $result=$stmt->get_result();

            $cantidad1=$result->fetch_row()[0];


            $sql2="UPDATE articulos set cantidad=? where id_producto=?";
            $stmt2=$conexion->prepare($sql2);
            $stmt2->bind_param("ss",$cantidadNueva,$idProducto);

            $cantidadNueva=abs($cantidad - $cantidad1);
            $idProducto=$idproducto;

            $stmt2->execute();
        }


        public function verDetalles($idVenta){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="SELECT articulos.nombre, detalles.cantidad, detalles.precio, ventas.total FROM detalles
            INNER JOIN ventas ON ventas.id_venta = detalles.venta
            INNER JOIN articulos ON articulos.id_producto = detalles.producto
            WHERE detalles.venta =?";
            $stmt=$conexion->prepare($sql);
            $stmt->bind_param("s",$idVenta);

            $idVenta=$idVenta;

            $stmt->execute();

            $result=$stmt->get_result();

            $detalles = array();

            while ($fila = $result->fetch_assoc()) {

                $detalle = array(
                    'nombreProducto' => $fila['nombre'],
                    'cantidad' => $fila['cantidad'],
                    'precio' => $fila['precio'],
                    'total' => $fila['total'],
                );

                $detalles[] = $detalle;
            }

            $stmt->close();
            $conexion->close();

            return $detalles;
        }
    }
?>