// Cargando datatables apenas inicia la pagina
document.addEventListener("DOMContentLoaded", function() {
    $('#tablaClientesLoad').load("clientes/tablaClientes.php", function() {
        // Inicializar DataTables después de cargar la tabla
        let dataTable = new DataTable("#tablaClientes", {
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

// Script para agregar clientes
$(document).ready(function(){
    $('#btnAgregaCliente').click(function(e){

        e.preventDefault(); // Evita el comportamiento predeterminado del botón de enviar

        let esValido=validarFormulario('frmClientes');

        if (!esValido) {
            return false; // Si la validación falla, no se envía el formulario
        }
        
    datos=$('#frmClientes').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/clientes/agregaCliente.php",
            success:function(r){
                if(r==1){
                    $('#frmClientes')[0].reset();
                    $('#tablaClientesLoad').load("clientes/tablaClientes.php",function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaClientes", {
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
                    alertify.success("Cliente agregado exitosamente");

                    // Cerrar el modal solo si el registro fue exitoso
                    $('#registraClienteModal').modal('hide');
                    // Eliminar el backdrop manualmente
                    $('.modal-backdrop').remove();
                }else{
                    alertify.error("No se pudo agregar el cliente :(");
                }
            }
        });
    });
});

// Funcion que agrega datos del cliente en el formulario de actualizar
function agregaDatosCliente(idcliente){
    $.ajax({
        type:"POST",
        data:"idcliente=" + idcliente,
        url:"../procesos/clientes/obtenerDatosCliente.php",
        success:function(r){
            dato=jQuery.parseJSON(r);
            $('#idclienteU').val(dato['id_cliente']);
            $('#nombreU').val(dato['nombre']);
            $('#apellidosU').val(dato['apellido']);
            $('#direccionU').val(dato['direccion']);
            $('#emailU').val(dato['email']);
            $('#telefonoU').val(dato['telefono']);
        }
    });
}

// Script para actualizar cliente
$(document).ready(function(){
    $('#btnAgregarClienteU').click(function(e){

        e.preventDefault(); // Evita el comportamiento predeterminado del botón de enviar

        let esValido=validarFormulario('frmClientesU');

        if (!esValido) {
            return false; // Si la validación falla, no se envía el formulario
        }

        datos=$('#frmClientesU').serialize();

        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/clientes/actualizaCliente.php",
            success:function(r){
                if(r==1){
                    $('#frmClientes')[0].reset();
                    $('#tablaClientesLoad').load("clientes/tablaClientes.php",function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaClientes", {
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
                    alertify.success("Cliente actualizado exitosamente");

                    // Cerrar el modal solo si el registro fue exitoso
                    $('#abremodalClientesUpdate').modal('hide');
                    // Eliminar el backdrop manualmente
                    $('.modal-backdrop').remove();
                }else{
                    alertify.error("No se pudo actualizar :(");
                }
            }
        });
    })
});

// Funcion para eliminar cliente
function eliminarCliente(idcliente){
    alertify.confirm('¿Desea eliminar este cliente?', function(){ 
        // alertify.success('Ok') 
        $.ajax({
            type:"POST",
            data:"idcliente=" + idcliente,
            url:"../procesos/clientes/eliminarCliente.php",
            success:function(r){
                if(r==1){
                    $('#tablaClientesLoad').load("clientes/tablaClientes.php",function() {
                        // Inicializar DataTables después de cargar la tabla
                        let dataTable = new DataTable("#tablaClientes", {
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
        alertify.error('Cancelar')
    });
}


document.getElementById('registraClienteModal').addEventListener('hidden.bs.modal', function () {
    $('#frmClientes')[0].reset();
});