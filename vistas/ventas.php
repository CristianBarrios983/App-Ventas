<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Vendedor"){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 my-3">
                <span class="btn btn-success rounded-0" id="venderProductosBtn">Vender</span>
                <span class="btn btn-warning rounded-0" id="ventasHechasBtn">Ventas hechas</span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="ventaProductos"></div>
                <div id="ventasHechas"></div>
            </div>
        </div>
    </div>

</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $('#venderProductosBtn').click(function(){
            esconderSeccionVenta();
            $('#ventaProductos').load('ventas/ventasProductos.php');
            $('#ventaProductos').show();
        });
        $('#ventasHechasBtn').click(function(){
            esconderSeccionVenta();
            $('#ventasHechas').load('ventas/ventasHechasyReportes.php');
            $('#ventasHechas').show();
        });
    });

    function esconderSeccionVenta(){
        $('#ventaProductos').hide();
        $('#ventasHechas').hide();
    }
</script>

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