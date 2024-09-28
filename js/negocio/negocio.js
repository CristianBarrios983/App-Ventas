// Script para desplegar el form de registro de negocio
$(document).ready(function(){
    $('#registrarNegocio').click(function(){
        esconderInfoNegocio();
        $('#datosNegocio').load('negocio/formRegistroNegocio.php');
        $('#datosNegocio').show();
    });
});

function esconderInfoNegocio(){
    $('#datosNegocio').hide();
}

// Funcion para añadir datos a modal de actualizar
function agregaDatosNegocio(idnegocio){
    $.ajax({
        type:"POST",
        data:"idnegocio=" + idnegocio,
        url:"../procesos/negocio/obtenerDatosNegocio.php",
        success:function(r){
            dato=jQuery.parseJSON(r);

            $('#idnegocioU').val(dato['id_negocio']);
            $('#nombreU').val(dato['nombre']);
            $('#direccionU').val(dato['direccion']);
            $('#telefonoU').val(dato['telefono']);
            $('#fechaU').val(dato['fechaRegistro']);
        }
    });
}

// Funcion para actualizar negocio
$(document).ready(function(){
    $('#actualizarNegocioU').click(function(e){

        e.preventDefault(); // Evita el comportamiento predeterminado del botón de enviar

        let esValido=validarFormulario('frmNegocioU');

        if (!esValido) {
            return false; // Si la validación falla, no se envía el formulario
        }

        datos=$('#frmNegocioU').serialize();

        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/negocio/actualizaNegocio.php",
            success:function(r){
                if(r==1){
                    alertify.success("Negocio actualizado exitosamente");
                    window.location.href="configuracion.php";
                }else{
                    alertify.error("No se pudo actualizar :(");
                }
            }
        });
    })
});

// Funcion para eliminar negocio
function eliminarNegocio(idnegocio){
    alertify.confirm('¿Desea eliminar los datos de este negocio?', function(){ 
        // alertify.success('Ok') 
        $.ajax({
            type:"POST",
            data:"idnegocio=" + idnegocio,
            url:"../procesos/negocio/eliminarNegocio.php",
            success:function(r){
                if(r==1){
                    alertify.success("Eliminado con exito");
                    window.location.href="configuracion.php";
                }else{
                    alertify.error("No se pudo eliminar");
                }
            }
        });
    }, function(){ 
        alertify.error('Cancelado')
    });
}