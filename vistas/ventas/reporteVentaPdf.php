<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    $obj= new ventas();

    $c= new conectar();
    $conexion=$c->conexion();
    $idventa=$_GET['idventa'];

    $sql="SELECT ve.id_venta,
                    ve.fechaCompra,
                    ve.id_cliente,
                    art.nombre,
                    art.precio,
                    art.descripcion 
                    from ventas as ve
                    inner join articulos as art
                    on ve.id_producto=art.id_producto and ve.id_venta='$idventa'";

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
    .titulo{
        font-size: 20px;
        text-align: center;
        font-weight: bold;
    }
    .table, p {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    .table td, .table th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    .table th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: black;
      color: white;
    }
    </style>
<body>
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
    <p class="titulo">Datos del negocio</p>
    <p><b>Nombre</b><?php echo $datosnegocio[0]; ?></p>
    <p><b>Direccion:</b> <?php echo $datosnegocio[1]; ?></p>
    <p><b>Telefono:</b> <?php echo $datosnegocio[2]; ?></p>
    <br>
    <?php endif; ?>
    <p class="titulo">Datos de compra</p>
    <p><b>Fecha:</b> <?php echo $fecha; ?></p>
    <p><b>Nro venta:</b> <?php echo $venta; ?></p>
    <p><b>Cliente:</b> <?php echo $obj->nombreCliente($idCliente) ?></p>
    <br>
    <table class="table">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio</th>
            </tr>
        <?php 
            $sql="SELECT ve.id_venta,
                    ve.fechaCompra,
                    ve.id_cliente,
                    art.nombre,
                    art.precio,
                    art.descripcion 
                    from ventas as ve
                    inner join articulos as art
                    on ve.id_producto=art.id_producto and ve.id_venta='$idventa'";

            $result=mysqli_query($conexion,$sql);
            $total=0;
            while($mostrar=mysqli_fetch_row($result)):
        ?>
            <tr>
                <td><?php echo $mostrar[3]; ?></td>
                <td><?php echo $mostrar[5]; ?></td>
                <td>1</td>
                <td><?php echo "$".$mostrar[4]; ?></td>
            </tr>
        <?php
            $total=$total + $mostrar[4]; 
            endwhile; 
        ?>

        <p><b>Total =</b> <?php echo "$".$total; ?> </p>
    </table>
</body>
</html>