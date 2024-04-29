// Cargando datatables apenas inicia la pagina
document.addEventListener("DOMContentLoaded", function() {
    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php", function() {
        // Inicializar DataTables después de cargar la tabla
        let dataTable = new DataTable("#tablaCategorias", {
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

// Script para agregar categoria
$(document).ready(function(){
    $('#btnAgregaCategoria').click(function(){
        vacios=validarFormVacio('frmCategorias');

        if(vacios > 0){
            alertify.alert("Los campos no deben estar vacios");
            return false;
        }
        
        datos=$('#frmCategorias').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/categorias/agregaCategoria.php",
            success:function(r){
                if(r==1){
                    //Esta linea permite limpiar los registros
                    $('#frmCategorias')[0].reset();
                    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaCategorias", {
                            perPageSelect: [10,20,30,40,50,75,100],
                            labels: {
                                        placeholder: "Buscar...",
                                        perPage: "{select} Registros por pagina",
                                        noRows: "Registro no encontrado",
                                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                                    }
                        });
                    });
                    alertify.success("Categoria agregada exitosamente");
                }else{
                    alertify.error("No se pudo agregar la categoria :(");
                }
            }
        });
    });
});

// Funcion para agregar los datos al formulario de actualizar
function agregaDato(idCategoria,categoria){
    $('#idcategoria').val(idCategoria);
    $('#categoriaU').val(categoria);
}


// Script para actualizar categoria
$(document).ready(function(){
    $('#btnActualizaCategoria').click(function(){
        datos=$('#frmCategoriaU').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/categorias/actualizaCategoria.php",
            success:function(r){
                if(r==1){
                    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaCategorias", {
                            perPageSelect: [10,20,30,40,50,75,100],
                            labels: {
                                        placeholder: "Buscar...",
                                        perPage: "{select} Registros por pagina",
                                        noRows: "Registro no encontrado",
                                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                                    }
                        });
                    });
                    alertify.success("Actualizado con exito");
                }else{
                    alertify.error("No se pudo actualizar")
                }
            }
        });
    });
})


// Funcion para eliminar categoria
function eliminaCategoria(idcategoria){
    alertify.confirm('¿Desea eliminar esta categoria?', function(){ 
        // alertify.success('Ok') 
        $.ajax({
            type:"POST",
            data:"idcategoria=" + idcategoria,
            url:"../procesos/categorias/eliminarCategoria.php",
            success:function(r){
                if(r==1){
                    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php", function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaCategorias", {
                            perPageSelect: [10,20,30,40,50,75,100],
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