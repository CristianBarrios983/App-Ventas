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

    $('#btnAgregaArticulo').click(function(e){

        e.preventDefault(); // Evita el comportamiento predeterminado del botón de enviar

        let esValido=validarFormulario('frmArticulos');

        if (!esValido) {
            return false; // Si la validación falla, no se envía el formulario
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
                // console.log("Respuesta: ", r);
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

                    // Cerrar el modal solo si el registro fue exitoso
                    $('#abremodalRegistroArticulo').modal('hide');
                    // Eliminar el backdrop manualmente
                    $('.modal-backdrop').remove();
                }else{
                    alertify.error("Fallo al agregar el producto");
                }
            }
        });
       
    });
});

// Script para actualizar stock
$(document).ready(function(){
    $('#btnActualizaStock').click(function(e){

        e.preventDefault(); // Evita el comportamiento predeterminado del botón de enviar

        let esValido=validarFormulario('frmStockU');

        if (!esValido) {
            return false; // Si la validación falla, no se envía el formulario
        }

        let datos=$('#frmStockU').serialize();
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

                    // Cerrar el modal solo si el registro fue exitoso
                    $('#abremodalAgregaStock').modal('hide');
                    // Eliminar el backdrop manualmente
                    $('.modal-backdrop').remove();
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
        type: "POST",
        data: "idarticulo=" + idarticulo,
        url: "../procesos/articulos/obtieneDatosArticulo.php",
        success: function(r){
            // Aquí, r ya es un objeto JSON, no hace falta parsearlo
            let dato = r;

            // Llena los campos correspondientes con los datos
            $('input[name="idArticulo"]').val(dato['id_producto']);
            $('#nombreU').val(dato['nombre']);
            $('#descripcionU').val(dato['descripcion']);
            // $('input[name="cantidadU"]').val(dato['cantidad']);
            $('input[name="stock_minimoU"]').val(dato['stock_minimo']);
            $('#precioU').val(dato['precio']);

            let id_categoria = dato['id_categoria'];

            obtenerCategorias(id_categoria);
        }
    });
}

function agregaDatosActualizarStock(idarticulo,stock){
    $('input[name="idArticulo"]').val(idarticulo);
    $('input[name="cantidadU"]').val(stock);
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
    $('#btnActualizaArticulo').click(function(e){

        e.preventDefault(); // Evita el comportamiento predeterminado del botón de enviar

        let esValido=validarFormulario('frmArticulosU');

        if (!esValido) {
            return false; // Si la validación falla, no se envía el formulario
        }

        let formDataU= new FormData(document.getElementById("frmArticulosU"));

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

                    // Cerrar el modal solo si el registro fue exitoso
                    $('#abremodalUpdateArticulo').modal('hide');
                    // Eliminar el backdrop manualmente
                    $('.modal-backdrop').remove();
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

// Script para visualizar imagenes en el modal

document.getElementById('abremodalRegistroArticulo').addEventListener('hidden.bs.modal', function () {
    const imgPreview = document.getElementById('img-preview');
    imgPreview.src = '';  // Limpiar la vista previa de la imagen
    $('#frmArticulos')[0].reset();
  });

document.getElementById('abremodalUpdateArticulo').addEventListener('hidden.bs.modal', function () {
    const imgPreview = document.getElementById('img-preview-update');
    imgPreview.src = '';  // Limpiar la vista previa de la imagen
    $('#frmArticulosU')[0].reset();
  });

  document.getElementById('abremodalAgregaStock').addEventListener('hidden.bs.modal', function () {
    $('#frmStockU')[0].reset();
    });

    const vistaPreliminar = (event) => {

        let imageSelected = new FileReader();
        let contenedorImg = document.getElementById('img-preview');

        imageSelected.onload = () =>{
            if(imageSelected.readyState == 2){
                contenedorImg.src = imageSelected.result;
            }
        }
        
        imageSelected.readAsDataURL(event.target.files[0]);
    }

    const vistaPreliminarEditar = (event) => {
        
        let imageSelected = new FileReader();
        let contenedorImg = document.getElementById('img-preview-update');

        imageSelected.onload = () =>{
            if(imageSelected.readyState == 2){
                contenedorImg.src = imageSelected.result;
            }
        }
        
        imageSelected.readAsDataURL(event.target.files[0]);
    }
