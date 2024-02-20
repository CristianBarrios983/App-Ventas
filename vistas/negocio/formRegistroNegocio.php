<h5>Registrar Datos del Negocio</h5>
<form id="frmNegocio">
	<label>Nombre del negocio:</label>
	<input type="text" class="form-control input-sm" name="nombreNegocio" id="nombreNegocio">
	<label>Direccion:</label>
	<input type="text" class="form-control input-sm" name="direccionNegocio" id="direccionNegocio">
	<label>Telefono:</label>
	<input type="number" class="form-control input-sm" name="telefonoNegocio" id="telefonoNegocio">
	<button type="button" class="btn btn-primary px-4" id="registroNegocio">Registrar Datos</button>
</form>

<script>
    $(document).ready(function(){
        $('#registroNegocio').click(function(){

            vacios=validarFormVacio('frmNegocio');

            if(vacios > 0){
                alert("Los campos no deben estar vacios");
                return false;
            }

            datos=$('#frmNegocio').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/negocio/registrarNegocio.php",
                success:function(r){
                    if(r==1){
                        window.location.href="inicio.php";
                        alertify.success("Registrado exitosamente");
                    }else{
                        alertify.error("Hubo un error :(");
                    }
                }
            });
        });
    });
</script>