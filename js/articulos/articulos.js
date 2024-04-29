// Cargando datatables apenas inicia la pagina
document.addEventListener("DOMContentLoaded", function() {
    $('#tablaArticulosLoad').load("articulos/tablaArticulos.php", function() {
        // Inicializar DataTables después de cargar la tabla
        let dataTable = new DataTable("#tablaProductos", {
            perPageSelect: [10,20,30,40,50,75,100],
            // Para cambiar idioma
            labels: {
                        placeholder: "Buscar...",
                        perPage: "{select} Registros por pagina",
                        noRows: "Registro no encontrado",
                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                    }
        });
    });
});

// Script para agregar producto
$(document).ready(function(){

    $('#btnAgregaArticulo').click(function(){

        vacios=validarFormVacio('frmArticulos');

        if(vacios > 0){
            alertify.alert("Los campos no deben estar vacios");
            return false;
        }

        var formData= new FormData(document.getElementById("frmArticulos"));

        $.ajax({
            url: "../procesos/articulos/insertaArticulo.php",
            type: "POST",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            success:function(r){
                if(r == 1){
                    $('#frmArticulos')[0].reset();
                    $("#tablaArticulosLoad").load("articulos/tablaArticulos.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaProductos", {
                            perPageSelect: [10,20,30,40,50,75,100],
                            // Para cambiar idioma
                            labels: {
                                        placeholder: "Buscar...",
                                        perPage: "{select} Registros por pagina",
                                        noRows: "Registro no encontrado",
                                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                                    }
                        });
                    });
                    alertify.success("Agregado con exito");
                }else{
                    alertify.error("Fallo al agregar el producto");
                }
            }
        });
       
    });
});

// Script para actualizar stock
$(document).ready(function(){
    $('#btnActualizaStock').click(function(){
        datos=$('#frmStockU').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/articulos/agregaStock.php",
            success:function(r){
                if(r==1){
                    $('#frmStockU')[0].reset();
                    $("#tablaArticulosLoad").load("articulos/tablaArticulos.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaProductos", {
                            perPageSelect: [10,20,30,40,50,75,100],
                            // Para cambiar idioma
                            labels: {
                                        placeholder: "Buscar...",
                                        perPage: "{select} Registros por pagina",
                                        noRows: "Registro no encontrado",
                                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                                    }
                        });
                    });
                    alertify.success("Se agrego al stock actual con exito");
                }else{
                    alertify.error("No se pudo agregar al stock");
                }
            }
        });
    });
});

// Funcion que agrega datos del producto en el formulario de actualizar
function agregaDatosArticulo(idarticulo){
    $.ajax({
        type:"POST",
        data:"idart=" + idarticulo,
        url:"../procesos/articulos/obtieneDatosArticulo.php",
        success:function(r){
            dato=jQuery.parseJSON(r);

            $('input[name="idArticulo"]').val(dato['id_producto']);
            $('#nombreU').val(dato['nombre']);
            $('#descripcionU').val(dato['descripcion']);
            $('input[name="cantidadU"]').val(dato['cantidad']);
            $('#precioU').val(dato['precio']);

            let id_categoria = dato['id_categoria'];

            obtenerCategorias(id_categoria);
        }
    });
}

// Funcion para obtener las categorias y añadirlos en un select
function obtenerCategorias (id_categoria) {
    $.ajax({
        type: "GET",
        url: "../procesos/articulos/obtenerCategorias.php",
        success: function(r) {
            let categorias = jQuery.parseJSON(r);
            
            // Limpiar el select antes de agregar los roles
            $('#categoriaSelectU').empty();

            // Iterar sobre los roles y agregar cada uno como una opción en el select
            categorias.forEach(function(categoria) {
                var option = $('<option></option>').attr('value', categoria.id_categoria).text(categoria.categoria);

                // Si el rol es el mismo que el del usuario, lo seleccionamos
                if (categoria.id_categoria === id_categoria) {
                    option.attr('selected', 'selected');
                }

                // Agregar la opción al select
                $('#categoriaSelectU').append(option);
            });
        }
    });
}

// Script para actualizar producto
$(document).ready(function(){
    $('#btnActualizaArticulo').click(function(){

        var formDataU= new FormData(document.getElementById("frmArticulosU"));

        $.ajax({
            type:"POST",
            data: formDataU,
            cache: false,
            contentType: false,
            processData: false,
            url:"../procesos/articulos/actualizaArticulos.php",
            success:function(r){
                if(r==1){
                    $("#tablaArticulosLoad").load("articulos/tablaArticulos.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaProductos", {
                            perPageSelect: [10,20,30,40,50,75,100],
                            // Para cambiar idioma
                            labels: {
                                        placeholder: "Buscar...",
                                        perPage: "{select} Registros por pagina",
                                        noRows: "Registro no encontrado",
                                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                                    }
                        });
                    });
                    alertify.success("Se actualizo con exito");
                }else{
                    alertify.error("No se pudo actualizar");
                }
            }
        });
    });
});

// Funcion para eliminar producto
function eliminaArticulo(idArticulo){
    alertify.confirm('¿Desea eliminar esta articulo?', function(){ 

        $.ajax({
            type:"POST",
            data:"idarticulo=" + idArticulo,
            url:"../procesos/articulos/eliminarArticulo.php",
            success:function(r){
                if(r==1){
                    $("#tablaArticulosLoad").load("articulos/tablaArticulos.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaProductos", {
                            perPageSelect: [10,20,30,40,50,75,100],
                            // Para cambiar idioma
                            labels: {
                                        placeholder: "Buscar...",
                                        perPage: "{select} Registros por pagina",
                                        noRows: "Registro no encontrado",
                                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                                    }
                        });
                    });
                    alertify.success("Eliminado con exito");
                }else{
                    alertify.error("No se pudo eliminar");
                }
            }
        });
    }, function(){ 
        alertify.error('Cancelar')});
}