<?php
    require_once "../../clases/Conexion.php";
    $c= new conectar();
    $conexion=$c->conexion();
?>
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
                        <input readonly hidden="" type="text" class="form-control form-control-lg fs-6 rounded-0" id="cantidad" name="cantidad">
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control form-control-lg fs-6 rounded-0" id="precioV" name="precioV" readonly>
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
    <div class="col-sm-3">
        <div id="imgProducto"></div>
    </div>
    <div class="col-sm-4">
        <div id="tablaVentasTempLoad"></div>
    </div>
</div>

<!-- Rellena datos de productos en formulario -->
<script>
    $(document).ready(function(){

        $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
        $('#productoVenta').change(function(){

            $.ajax({
                type:"POST",
                data:"idproducto=" + $('#productoVenta').val(),
                url:"../procesos/ventas/llenarFormProducto.php",
                success:function(r){
                    dato=jQuery.parseJSON(r);
                    
                        $('#descripcionV').val(dato['descripcion']);
                        obtenerCantidadDisponible($('#productoVenta').val());
                        $('#cantidad').val(dato['cantidad']);
                        $('#precioV').val(dato['precio']);

                        $('label[for="descripcionV"]').show();
                        $('#descripcionV').show();
                        $('label[for="precioV"]').show();
                        $('#precioV').show();
                        $('#btnAgregaVenta').show(); //Oculta el boton
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

            vacios=validarFormVacio('frmVentasProductos');

            if(vacios > 0){
                alertify.alert("Los campos no deben estar vacios");
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
                    }else{
                        obtenerCantidadDisponible($('#productoVenta').val());
                        $('label[for="descripcionV"]').hide();
                        $('#descripcionV').hide();
                        $('label[for="precioV"]').hide();
                        $('#precioV').hide();
                        $('#btnAgregaVenta').hide(); //Oculta el boton
                        $('#message').text('¡No hay stock disponible!');
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