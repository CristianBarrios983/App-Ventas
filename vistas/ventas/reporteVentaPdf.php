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
    <title>Reporte de venta</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Estilos para contenedor */
        .container {
            max-width: 800px; /* Ajusta según sea necesario */
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Estilos para título */
        .titulo {
            font-size: 20px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .negrita{
            font-weight: bold;
        }

        /* Estilos para tabla */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: black;
            color: white;
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

        <?php if($validar > 0): ?>
            <?php 
                $sql="SELECT nombre,direccion,telefono from negocio_info";
                $result=mysqli_query($conexion,$sql);
                $datosnegocio=mysqli_fetch_row($result);
            ?>
            <div class="datos-negocio">
                <p class="titulo">Datos del negocio</p>
                <p><span class="negrita">Nombre:</span> <?php echo $datosnegocio[0]; ?></p>
                <p><span class="negrita">Direccion:</span> <?php echo $datosnegocio[1]; ?></p>
                <p><span class="negrita">Telefono:</span> <?php echo $datosnegocio[2]; ?></p>
            </div>
        <?php endif; ?>

        <div class="datos-venta">
            <p class="titulo">Datos de compra</p>
            <p><span class="negrita">Fecha:</span> <?php echo $fecha; ?></p>
            <p><span class="negrita">Nro venta:</span> <?php echo $venta; ?></p>
            <p><span class="negrita">Cliente:</span> <?php echo $obj->nombreCliente($idCliente) ?></p>
        </div>
        
        <div class="tabla-ventas">
            <table class="table">
                <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                </tr>
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
                    <td><?php echo $mostrar[0]; ?></td>
                    <td><?php echo $mostrar[1]; ?></td>
                    <td><?php echo $mostrar[2]; ?></td>
                    <td><?php echo "$".$mostrar[3]; ?></td>
                </tr>
                <?php
                    $total=$total + $mostrar[3]; 
                    endwhile; 
                ?>
                <tr>
                    <td colspan="3"><b>Total:</b></td>
                    <td><?php echo "$".$total; ?></td>
                </tr>
            </table>
</body>
</html>