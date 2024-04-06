<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Vendedor"){
            require_once "../clases/Conexion.php";
            require_once "../clases/Ventas.php";

            $c= new conectar();
            $conexion=$c->conexion();
        
            $obj= new ventas();
        
            $sql="SELECT id_venta,fechaCompra,id_cliente from ventas group by id_venta";
            $result=mysqli_query($conexion,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas realizadas</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    
<div class="container">
    <!-- Modal detalles de venta -->
    <div class="modal fade" id="abremodalDetalles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles de venta</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            

                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Detalles aqui -->
                    </tbody>
                </table>
                    
                <p>Cantidad de productos: <span id="cantidadProductos" class="fw-bold"></span></p>
                <p>Total de venta: <span id="totalVenta" class="fw-bold"></span></p>

        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
        <div class="section-title">
            <h2 class="my-3">Reportes y ventas</h2>
        </div>
        </div>
    </div>
    <table class="table table-hover">
    <thead class="table-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Fecha</th>
        <th scope="col">Cliente</th>
        <th scope="col">Total</th>
        <th scope="col" colspan="3">Acciones</th>
        </tr>
    </thead>
    <?php while($mostrar=mysqli_fetch_row($result)): ?>
    <tbody>
        <tr>
        <th scope="row"><?php echo $mostrar[0]; ?></th>
        <td><?php echo $mostrar[1]; ?></td>
        <td>
            <?php
                if($obj->nombreCliente($mostrar[2])==" "){
                    echo "Sin cliente";
                }else{
                    echo $obj->nombreCliente($mostrar[2]);
                }
            ?>
        </td>
        <td>
            <?php
                echo '<label class="fw-bold text-success">$</label>'.$obj->obtenerTotal($mostrar[0]);
            ?>
        </td>
        <td><a href="../procesos/ventas/crearTicketPdf.php?idventa=<?php echo $mostrar[0] ?>" class="btn btn-danger btn-xs rounded-0">
                                <span class="bi bi-ticket-detailed"></span>
                            </a></td> 
        <td><a href="../procesos/ventas/crearReportePdf.php?idventa=<?php echo $mostrar[0] ?>" class="btn btn-primary btn-xs rounded-0">
                                <span class="bi bi-filetype-pdf"></span>
                            </a>   </td>
        <!-- Detalles de venta -->
        <td><a data-bs-toggle="modal" data-bs-target="#abremodalDetalles" class="btn btn-success btn-xs rounded-0" onclick="verDetalles(<?php echo $mostrar[0] ?>)">
            <span class="bi bi-card-list"></span>
        </a>   </td>
        </tr>
    </tbody>
    <?php endwhile;?>
    </table>
</div>

<script>
    function verDetalles(idVenta){
        $.ajax({
            type:"POST",
            data:"idVenta=" + idVenta,
            url:"../procesos/ventas/verDetalles.php",
            success:function(r){
                 let detallesVenta = jQuery.parseJSON(r);
                console.log(detallesVenta)
                 // Limpiar la tabla de detalles antes de agregar nuevos datos
                 $('#abremodalDetalles tbody').empty();

                 // Iterar sobre los detalles y agregar filas a la tabla
                 let i = 0;
                 let total = 0;
                 $.each(detallesVenta, function(index, detalle) {
                    i++;
                    total = detalle.total;
                      var fila = '<tr>' +
                          '<td>' + detalle.nombreProducto + '</td>' +
                          '<td>' + detalle.cantidad + '</td>' +
                          '<td>' + '$' + detalle.precio + '</td>' +
                          '</tr>';
                      $('#abremodalDetalles tbody').append(fila);
                      console.log(detalle.nombreProducto, detalle.cantidad, detalle.precio);
                 });

                 console.log(i,total);
                 $('#abremodalDetalles #cantidadProductos').text(`${i}`);
                 $('#abremodalDetalles #totalVenta').text(`$${total}`);

                }
        });
    }
</script>



<?php
        }else{
            header("location:inicio.php");
        }
    }else{
        header("location:../index.php");
    }
?>