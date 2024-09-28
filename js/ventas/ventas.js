// Script para rellenar los datos del producto en el formulario
$(document).ready(function() {

    $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
    $('label[for="cantidad"]').hide();
    $('#cantidad').hide();
   
    $('#productoBuscar').keyup(function() {
        let nombreProducto = $(this).val();

        if (nombreProducto.length >= 1) { // Buscar productos si hay al menos 2 caracteres
            $.ajax({
                type: "POST",
                url: "../procesos/ventas/buscarProductoPorNombre.php", //
                data: { nombreProducto: nombreProducto },
                success: function(response) {
                    console.log("Respuesta del servidor:", response); // Aquí puedes ver el objeto
                    
                    let productos = response; 
                    let sugerencias = '';
                
                    if (productos.length > 0) {
                        productos.forEach(function(producto) {
                            sugerencias += `<div class="producto-sugerido" data-id="${producto.id_producto}">${producto.nombre}</div>`;
                        });
                    } else {
                        sugerencias = '<div>No se encontraron productos</div>';
                    }
                
                    $('#sugerenciasProductos').html(sugerencias);
                }
            });
        } else {
            $('#sugerenciasProductos').empty();
        }
    });


    // Al hacer clic en un producto sugerido, llenar el formulario
    $(document).on('click', '.producto-sugerido', function() {
        let idProducto = $(this).data('id');
        let nombreProducto = $(this).text();

        $('#productoVenta').val(idProducto);  // Guarda el ID del producto
        $('#productoBuscar').val(nombreProducto);  // Muestra el nombre en el input

        $('#sugerenciasProductos').empty();  // Oculta las sugerencias

        // Realiza la petición para llenar los otros datos del producto (como antes)
        $.ajax({
            type: "POST",
            data: { idproducto: idProducto },
            url: "../procesos/ventas/llenarFormProducto.php",
            success: function(response) {
                let dato = JSON.parse(response);
                $('#descripcionV').val(dato['descripcion']);
                obtenerCantidadDisponible(idProducto);
                $('#stock').val(dato['cantidad']);
                $('#precioV').val(dato['precio']);
                $('#precioP').text('Precio: $' + dato['precio']);

                $('#descripcionV').show();
                $('label[for="cantidad"]').show();
                $('#cantidad').show();
                $('#btnAgregaVenta').show(); // Muestra el botón
                $('#message').text('');
            }
        });
    });


    // Funcion para obtener la cantidad disponible del producto
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

    // En este script se agrega la venta
    $('#btnAgregaVenta').click(function(e){

        // Validaciones de los campos para evitar datos incorrectos
        let esValido=validarFormulario('frmVentasProductos');

        if (!esValido) {
            return false; // Si la validación falla, no se envía el formulario
        }

        let cantidad = parseInt($('#cantidad').val());
        let stockDisponible = parseInt($('#stock').val());

        if (Math.sign(cantidad) === 0) {
            alertify.alert("La cantidad debe ser mayor que cero");
            return false;
        }

        if (Math.sign(cantidad) === -1) {
            alertify.alert("La cantidad no puede ser negativo");
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


    // Script para vaciar el carrito y formulario de venta
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

// Funcion para quitar producto del carrito de venta
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

// Funcion para realizar la venta
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

// Funcion para actualizar la cantidad del producto añadido en el carrito
function actualizarCantidad(indice, nuevaCantidad, idProducto) {

    // Validaciones del input
    if (Math.sign(nuevaCantidad) === 0) {
        alertify.alert("La cantidad debe ser mayor que cero");
        return false;
    }

    if (Math.sign(nuevaCantidad) === -1) {
        alertify.alert("La cantidad no debe ser negativa");
        return false;
    }

    $.ajax({
        type: "POST",
        data: { indice: indice, nuevaCantidad: nuevaCantidad, idProducto: idProducto },
        url: "../procesos/ventas/actualizarCantidad.php",
        success: function(r) {

            console.log(r);

            if(r==1){
                // Recargar la tabla de ventas después de la actualización
                $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                alertify.success("Se modifico la cantidad correctamente");
            }else if(r==0){
                $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                alertify.alert("La cantidad supera el stock disponible");
            }else{
                $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                alertify.error("No se pudo modificar la cantidad");
            }
        }
    });
}

