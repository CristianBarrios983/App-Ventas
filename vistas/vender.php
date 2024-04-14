<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Vendedor"){
            require_once "../clases/Conexion.php";
            $c= new conectar();
            $conexion=$c->conexion();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vender</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    
<div class="container">
    <div class="row">
        <div class="col-lg-8">
        <div class="section-title">
            <h2 class="my-3">Venta</h2>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4" id="formVenta">
            <div class="card rounded-0">
            <div class="card-body p-4">
                <form id="frmVentasProductos">
                        <div class="mb-3">
                            <select class="form-select form-select-lg fs-6 rounded-0" id="clienteVenta" name="clienteVenta">
                                <option value="" selected>Seleccione cliente</option>
                                <option value="0">Sin cliente</option>
                                <?php 
                                    // Consulta clientes
                                    $sqlCliente="SELECT id_cliente,nombre,apellido from clientes";
                                    $resultCliente=mysqli_query($conexion,$sqlCliente);
                                ?>
                                <?php while($cliente=mysqli_fetch_row($resultCliente)): ?>
                                    <option value="<?php echo $cliente[0] ?>"><?php echo $cliente[2]." ".$cliente[1] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select class="form-select form-select-lg fs-6 rounded-0" id="productoVenta" name="productoVenta">
                                <option value="" selected>Seleccione producto</option>
                                <?php
                                    // Consulta productos
                                    $sqlProducto="SELECT id_producto,nombre from articulos";
                                    $resultProducto=mysqli_query($conexion,$sqlProducto);
                                ?>
                                <?php while($producto=mysqli_fetch_row($resultProducto)): ?>
                                    <option value="<?php echo $producto[0] ?>"><?php echo $producto[1] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <textarea name="descripcionV" id="descripcionV" class="form-control form-control-lg fs-6 rounded-0" readonly></textarea>
                        </div>

                        <div class="mb-3">
                            <p class="text-danger fs-5" id="cantidadV" name="cantidadV"></p>
                            <input readonly hidden="" type="text" class="form-control form-control-lg fs-6 rounded-0" id="stock" name="stock">
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg fs-6 rounded-0" id="precioV" name="precioV" hidden>
                            <p class="text-success fs-5" id="precioP" name="precioP"></p>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" class="form-control form-control-lg fs-6 rounded-0" id="cantidad" name="cantidad" min="1" max="20">
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-primary rounded-0 d-block w-100" id="btnAgregaVenta">Agregar</button>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-danger rounded-0 d-block w-100" id="btnVaciarVentas">Vaciar todo</button>
                        </div>
                    
                        <div>
                            <p class="text-danger fs-5" id="message"></p>
                        </div>
                </form>
            </div>
            </div>
        </div>
        <!-- <div class="col-sm-3">
            <div id="imgProducto"></div>
        </div> -->
        <div class="col-sm-8">
            <div id="tablaVentasTempLoad"></div>
        </div>
    </div>
</div>

<!-- Rellena datos de productos en formulario -->
<script>
    $(document).ready(function(){

        $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
        $('label[for="cantidad"]').hide();
        $('#cantidad').hide();
        $('#productoVenta').change(function(){

            $.ajax({
                type:"POST",
                data:"idproducto=" + $('#productoVenta').val(),
                url:"../procesos/ventas/llenarFormProducto.php",
                success:function(r){
                    dato=jQuery.parseJSON(r);
                    
                        $('#descripcionV').val(dato['descripcion']);
                        obtenerCantidadDisponible($('#productoVenta').val());
                        $('#stock').val(dato['cantidad']);
                        $('#precioV').val(dato['precio']);
                        $('#precioP').text('Precio: $' + dato['precio']);

                        $('#descripcionV').show();
                        $('label[for="cantidad"]').show();
                        $('#cantidad').show();
                        $('#btnAgregaVenta').show(); //Muestra el boton
                        $('#message').text('');


                    // $('#imgProducto').prepend('<img width="100" height="100" class="img-thumbnail" id="imgp" src=" ' + dato['ruta'] + '" />');
                }
            });
        });

        function obtenerCantidadDisponible(idProducto) {
            $.ajax({
                type: "POST",
                data: "idproducto=" + idProducto,
                url: "../procesos/ventas/obtenerCantidadDisponible.php",
                success: function(cantidadDisponible) {
                    $('#cantidadV').text('Disponibles: ' + cantidadDisponible);
                }
            });
        }

        $('#btnAgregaVenta').click(function(){

            vacios = validarFormVacio('frmVentasProductos');

            if (vacios > 0) {
                alertify.alert("Los campos no deben estar vacios");
                return false;
            }

            let cantidad = parseInt($('#cantidad').val());
            let stockDisponible = parseInt($('#stock').val());

            if (cantidad <= 0) {
                alertify.alert("La cantidad debe ser mayor que cero");
                return false;
            }

            if (cantidad > stockDisponible) {
                alertify.alert("La cantidad ingresada supera el stock disponible");
                return false;
            }

        datos=$('#frmVentasProductos').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/ventas/agregaProductoTemp.php",
            success:function(r){
                if(r==1){
                    $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                    obtenerCantidadDisponible($('#productoVenta').val());
                } else {
                    //Si no hay suficiente stock, no se agrega el producto al carrito
                    obtenerCantidadDisponible($('#productoVenta').val());
                    $('#btnAgregaVenta').hide(); // Oculta el boton
                    // $('#message').text('¡No hay suficiente stock disponible!');
                    alertify.alert("La cantidad ingresada supera el stock disponible");
                    return false;
                }
                }
            });
        });


        $('#btnVaciarVentas').click(function(){
        $.ajax({
            url:"../procesos/ventas/vaciarTemp.php",
            success:function(){
                $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                $('#frmVentasProductos')[0].reset();
                $('#cantidadV').text('');
                $('#precioP').text('');
                $('#cantidad').text('');
                $('label[for="cantidad"]').hide();
                $('#cantidad').hide();
                $('#message').text('');
            }
        });
    });

    });
</script>

<script>
    function quitarP(index){
        $.ajax({
            type:"POST",
            data:"ind=" + index,
            url:"../procesos/ventas/quitarproducto.php",
            success:function(r){
                $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                alertify.success("Se quito el producto de la lista");
            }
        });
    }

    function crearVenta(){
        $.ajax({
            url:"../procesos/ventas/crearVenta.php",
            success:function(r){
                if(r > 0){
                    $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                    $('#frmVentasProductos')[0].reset();
                    $('#cantidadV').text('');
                    $('#precioP').text('');
                    $('#nombreclienteVenta').load("ventas/tablaVentasTemp.php");
                    alertify.alert("Venta creada con exito");
                }else if(r==0){
                    alertify.alert("No hay lista de venta");
                }else{
                    alertify.error("No se pudo crear la venta");
                }
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