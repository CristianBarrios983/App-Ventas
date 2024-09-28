<form id="frmNegocio" class="p-4">
    <div class="mb-3">
        <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="nombreNegocio" id="nombreNegocio" placeholder="Nombre del negocio">
    </div>
    <div class="mb-3">
        <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="direccionNegocio" id="direccionNegocio" placeholder="Direccion">
    </div>
    <div class="mb-3">
	    <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="telefonoNegocio" id="telefonoNegocio" placeholder="Telefono">
    </div>
    <div>
	    <button type="button" class="btn btn-primary px-4 rounded-0 d-block w-100" id="registroNegocio">Registrar</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $('#registroNegocio').click(function(e){

            e.preventDefault(); // Evita el comportamiento predeterminado del botón de enviar

            let esValido=validarFormulario('frmNegocio');

            if (!esValido) {
                return false; // Si la validación falla, no se envía el formulario
            }

            datos=$('#frmNegocio').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/negocio/registrarNegocio.php",
                success:function(r){
                    if(r==1){
                        alertify.success("Registrado exitosamente");
                        window.location.href="configuracion.php";
                    }else{
                        alertify.error("Hubo un error :(");
                    }
                }
            });
        });
    });
</script>