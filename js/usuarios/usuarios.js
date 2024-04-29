// Cargando datatables apenas inicia la pagina
document.addEventListener("DOMContentLoaded", function() {
    $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php", function() {
        // Inicializar DataTables después de cargar la tabla
        let dataTable = new DataTable("#tablaUsuarios", {
            // perPage: 10, // Paginas por defecto
            perPageSelect: [10,20,30,40,50,75,100],
            //stateSave: true, //Guarda el estado de la tabla
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

// Script para registrar un usuario
$(document).ready(function(){

    $('#registro').click(function(){

        vacios=validarFormVacio('frmRegistro');

        if(vacios > 0){
            alertify.alert("Los campos no deben estar vacios");
            return false;
        }

        datos=$('#frmRegistro').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/regLogin/registrarUsuario.php",
            success:function(r){

                if(r==1){
                    $('#frmRegistro')[0].reset();
                    $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php', function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaUsuarios", {
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
                    alertify.success("Registrado con exito!");
                }else{
                    alertify.error("Hubo un error");
                }
            }
        });
    });
});

// Funcion para agregar datos del usuario en el formulario de actualizar
function agregaDatosUsuario(idusuario){
    $.ajax({
        type:"POST",
        data:"idusuario=" + idusuario,
        url:"../procesos/usuarios/obtenerDatosUsuario.php",
        success:function(r){
            dato=jQuery.parseJSON(r);

            $('#idUsuario').val(dato['id_usuario']);
            $('#nombreU').val(dato['nombre']);
            $('#apellidoU').val(dato['apellido']);
            $('#usuarioU').val(dato['usuario']);
            $('#emailU').val(dato['email']);

            console.log("id:"+dato['id_usuario']+" "+"nombre:"+dato['nombre']+" "+"apellido:"+dato['apellido']+" "+"usuario:"+dato['usuario']+" "+"email:"+dato['email']+" "+"rol:"+dato['id_rol']);

            // Rol del usuario
            let id_rol = dato['id_rol'];

            obtenerRoles(id_rol);
        }
    });
}

// Funcion pára obtener roles y mostrarlos en un select
function obtenerRoles (id_rol) {
    $.ajax({
        type: "GET",
        url: "../procesos/usuarios/obtenerRoles.php",
        success: function(r) {
            let roles = jQuery.parseJSON(r);
                
            // Limpiar el select antes de agregar los roles
            $('#rolSelectU').empty();

            // Iterar sobre los roles y agregar cada uno como una opción en el select
            roles.forEach(function(rol) {
                var option = $('<option></option>').attr('value', rol.id_rol).text(rol.rol);

                // Si el rol es el mismo que el del usuario, lo seleccionamos
                if (rol.id_rol === id_rol) {
                    option.attr('selected', 'selected');
                }

                // Agregar la opción al select
                $('#rolSelectU').append(option);
            });
        }
    });
}

// Script para actualizar usuario
$(document).ready(function(){
    $('#btnActualizaUsuario').click(function(){
        datos=$('#frmRegistroU').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/usuarios/actualizaUsuario.php",
            success:function(r){
                if(r==1){
                  $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php', function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaUsuarios", {
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


// Funcion para eliminar usuario
function eliminarUsuario(idusuario){
    alertify.confirm('¿Desea eliminar este usuario?', function(){ 
        // alertify.success('Ok') 
        $.ajax({
            type:"POST",
            data:"idusuario=" + idusuario,
            url:"../procesos/usuarios/eliminarUsuario.php",
            success:function(r){
                if(r==1){
                  $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php', function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaUsuarios", {
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