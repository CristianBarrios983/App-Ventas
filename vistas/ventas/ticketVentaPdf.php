<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    $obj= new ventas();

    $c= new conectar();
    $conexion=$c->conexion();
    $idventa=$_GET['idventa'];

    $sql="SELECT id_venta, fechaCompra, id_cliente FROM ventas
    WHERE id_venta ='$idventa'";

    $result=mysqli_query($conexion,$sql);

    $mostrar=mysqli_fetch_row($result);

    $venta=$mostrar[0];
    $fecha=$mostrar[1];
    $idCliente=$mostrar[2];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de venta</title>
    <style>
        @page {
            margin: 0.3em 0.4em;
        }

        body {
            font-size: xx-small;
        }

        .container {
            max-width: 393px;
            margin: 0 auto;
        }

        table, th, td {
            border: .5px solid gray;
            border-collapse: collapse;
            text-align: center;
            width: 100%;
        }

        .info {
            display: block;
            width: 100%;
            max-width: 393px;
            margin: 0 auto;
            margin-bottom: 5px;
            box-sizing: border-box; /*Incluye el borde y el relleno en el ancho total*/
        }

        .datos-negocio p,
        .datos-venta p {
            margin: 2px 0; /* Define el margen superior e inferior */
            margin: 0 auto; /* Centra horizontalmente los párrafos */
        }

        .datos-negocio{
            margin-bottom: 15px;
        }

        .negocio-nombre {
            text-align: center; /* Alinea el texto del contenido centralizado */
            font-weight: bold;
            margin-bottom: 5px !important;
            border-top: .5px solid gray;
            border-bottom: .5px solid gray;
        }

        .total {
            margin-bottom: 5px;
        }

        .agradecimiento{
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
        <?php
            $sql="SELECT * from negocio_info";
            $result=mysqli_query($conexion,$sql);
            $validar=0;
            if(mysqli_num_rows($result) > 0){
                $validar=1;
            }
        ?>

        <div class="info">
            <?php if($validar > 0): ?>
            <?php
                $sql="SELECT nombre,direccion,telefono from negocio_info";
                $result=mysqli_query($conexion,$sql);
                $datosnegocio=mysqli_fetch_row($result);
            ?>
            <div class="datos-negocio">
                <div class="negocio-nombre">
                    <p><?php echo $datosnegocio[0]; ?></p>
                </div>
                <p>Direccion: <?php echo $datosnegocio[1]; ?></p>
                <p>Telefono: <?php echo $datosnegocio[2]; ?></p>
            </div>
            <?php endif; ?>
            <div class="datos-venta">
                <p>Fecha: <?php echo $fecha; ?></p>
                <p>Nro de venta: <?php echo $venta; ?></p>
                <p>Cliente: <?php echo $obj->nombreCliente($idCliente) ?></p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql="SELECT articulos.nombre, articulos.descripcion, detalles.cantidad, detalles.precio FROM detalles
                        INNER JOIN ventas ON ventas.id_venta = detalles.venta
                        INNER JOIN articulos ON articulos.id_producto = detalles.producto
                        WHERE detalles.venta ='$idventa'";

                        $result=mysqli_query($conexion,$sql);
                        $total=0;
                        while($mostrar=mysqli_fetch_row($result)):
                    ?>
                    <tr>
                        <td><?php echo $mostrar[0]." ".$mostrar[1] ?></td>
                        <td><?php echo $mostrar[2]; ?></td>
                        <td><?php echo "$".$mostrar[3]; ?></td>
                    </tr>
                    <?php
                        $total=$total + $mostrar[3];
                        endwhile;
                    ?>
                </tbody>
            </table>
        </div>

        <div class="total">
            <p>Total: <?php echo "$".$total; ?></p>
        </div>
        <div class="agradecimiento">
            <p>Gracias por su compra :)</p>
        </div>
    </div>
</body>
</html>