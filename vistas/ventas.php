<?php
    session_start();
    if(isset($_SESSION['usuario'])){
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
        <h2>Venta de productos</h2>
        <div class="row">
            <div class="col-sm-12">
                <span class="btn btn-success" id="venderProductosBtn">Vender</span>
                <span class="btn btn-warning" id="ventasHechasBtn">Ventas hechas</span>
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

<?php
    }else{
        header("location:../index.php");
    }
?>