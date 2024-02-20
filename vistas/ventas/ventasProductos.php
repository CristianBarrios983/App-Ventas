<?php
<<<<<<< HEAD
    // session_start();
=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
    require_once "../../clases/Conexion.php";
    $c= new conectar();
    $conexion=$c->conexion();
?>
<h4>Vender</h4>
<div class="row">
<<<<<<< HEAD
     <div class="col-sm-4" id="formVenta">
=======
     <div class="col-sm-4">
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Vender</h5>
            <form id="frmVentasProductos">
                <label for="">Seleccione cliente</label>
                <select class="form-control input-sm" id="clienteVenta" name="clienteVenta">
<<<<<<< HEAD
                    <option value="">Selecciona</option>
=======
                    <option value="A">Selecciona</option>
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
                    <option value="0">Sin cliente</option>
                    <?php 
                        $sql="SELECT id_cliente,nombre,apellido from clientes";
                        $result=mysqli_query($conexion,$sql);
                        while($cliente=mysqli_fetch_row($result)):
                    ?>
                    <option value="<?php echo $cliente[0] ?>"><?php echo $cliente[2]."".$cliente[1] ?></option>
                    <?php endwhile; ?>
                </select>
                <label for="">Producto</label>
                <select class="form-control input-sm" id="productoVenta" name="productoVenta">
                    <option value="A">Selecciona producto</option>
                    <?php 
                        $sql="SELECT id_producto,nombre from articulos";
                        $result=mysqli_query($conexion,$sql);

                        while($producto=mysqli_fetch_row($result)):
                    ?>
                    <option value="<?php echo $producto[0] ?>"><?php echo $producto[1] ?></option>
                    <?php endwhile; ?>
                </select>
<<<<<<< HEAD
                <label for="descripcionV">Descripcion</label>
                <textarea readonly="" name="descripcionV" id="descripcionV" class="form-control input-sm"></textarea>
                <p class="text-danger" id="cantidadV" name="cantidadV" style="font-weight: bold;"></p>
                <!-- <label for="">Cantidad</label> -->
                <input readonly="" hidden="" type="text" class="form-control input-sm" id="cantidad" name="cantidad">
                <label for="precioV">Precio</label>
=======
                <label for="">Descripcion</label>
                <textarea readonly="" name="descripcionV" id="descripcionV" class="form-control input-sm"></textarea>
                <label for="">Cantidad</label>
                <input readonly="" type="text" class="form-control input-sm" id="cantidadV" name="cantidadV">
                <label for="">Precio</label>
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
                <input readonly="" type="text" class="form-control input-sm" id="precioV" name="precioV">
                <p></p>
                <span class="btn btn-primary" id="btnAgregaVenta">Agregar</span>
                <span class="btn btn-danger" id="btnVaciarVentas">Vaciar ventas</span>
<<<<<<< HEAD
                <p class="text-danger" id="message" style="font-weight: bold;"></p>
=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
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
<<<<<<< HEAD
                    
                        $('#descripcionV').val(dato['descripcion']);
                        // $('#cantidadV').text('Disponibles: '+ dato['cantidad']);
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
=======

                    $('#descripcionV').val(dato['descripcion']);
                    $('#cantidadV').val(dato['cantidad']);
                    $('#precioV').val(dato['precio']);

                    $('#imgProducto').prepend('<img width="100" height="100" class="img-thumbnail" id="imgp" src=" ' + dato['ruta'] + '" />');
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
                }
            });
        });

<<<<<<< HEAD
        function obtenerCantidadDisponible(idProducto) {
            $.ajax({
                type: "POST",
                data: "idproducto=" + idProducto,
                url: "../procesos/ventas/obtenerCantidadDisponible.php",
                success: function(cantidadDisponible) {
                    // console.log("Cantidad disponible obtenida: " + cantidadDisponible);
                    $('#cantidadV').text('Disponibles: ' + cantidadDisponible);
                }
            });
        }

=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
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
<<<<<<< HEAD
                    // console.log(r);
                    if(r==1){
                        $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                        obtenerCantidadDisponible($('#productoVenta').val());
                    }else{
                        obtenerCantidadDisponible($('#productoVenta').val());
                        // $('#cantidadV').text('Disponibles: '+ dato['cantidad']);
                        $('label[for="descripcionV"]').hide();
                        $('#descripcionV').hide();
                        $('label[for="precioV"]').hide();
                        $('#precioV').hide();
                        $('#btnAgregaVenta').hide(); //Oculta el boton
                        $('#message').text('¡No hay stock disponible!');
                    }
=======
                    $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
                }
            });
        });

        $('#btnVaciarVentas').click(function(){
        $.ajax({
            url:"../procesos/ventas/vaciarTemp.php",
            success:function(r){
                $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
<<<<<<< HEAD
                obtenerCantidadDisponible($('#productoVenta').val());
=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
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
<<<<<<< HEAD
                    $('#nombreclienteVenta').load("ventas/tablaVentasTemp.php");
=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
                    alertify.alert("Venta creada con exito. Consulte la informacion de esta en ventas hechas");
                }else if(r==0){
                    alertify.alert("No hay lista de venta");
                }else{
                    alertify.error("No se pudo crear la venta");
                }
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#clienteVenta').select2();
        $('#productoVenta').select2();
    });
</script>