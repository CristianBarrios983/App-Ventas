<?php
    session_start();
    if(isset($_SESSION['usuario'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    <div class="container">
        <h2>Administrar usuarios</h2>
        <div class="row">
             <div class="col-sm-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Registrar usuario</h5>
                    <form id="frmRegistro">
                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombre" id="nombre">
                        <label>Apellido</label>
                        <input type="text" class="form-control input-sm" name="apellido" id="apellido">
                        <label>Usuario</label>
                        <input type="text" class="form-control input-sm" name="usuario" id="usuario">
                        <label>Password</label>
                        <input type="text" class="form-control input-sm" name="password" id="password">
                        <p></p>
                        <span class="btn btn-primary" id="registro">Registrar</span>
                    </form>
                  </div>
                </div>
              </div>
            <div class="col-sm-7">
                <div id="tablaUsuariosLoad"></div>
            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="actualizaUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualiza usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmRegistroU">
            <input type="text" hidden="" id="idUsuario" name="idUsuario">
            <label>Nombre</label>
            <input type="text" class="form-control input-sm" name="nombreU" id="nombreU">
            <label>Apellido</label>
            <input type="text" class="form-control input-sm" name="apellidoU" id="apellidoU">
            <label>Usuario</label>
            <input type="text" class="form-control input-sm" name="usuarioU" id="usuarioU">
        </form>
      </div>
      <div class="modal-footer">
        <button id="btnActualizaUsuario" type="button" class="btn btn-warning" data-dismiss="modal">Actualizar</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<!-- Editar registros -->
<script>
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
                $('#usuarioU').val(dato['email']);
            }
        });
    }

    function eliminarUsuario(idusuario){
        alertify.confirm('¿Desea eliminar este usuario?', function(){ 
            // alertify.success('Ok') 
            $.ajax({
                type:"POST",
                data:"idusuario=" + idusuario,
                url:"../procesos/usuarios/eliminarUsuario.php",
                success:function(r){
                    if(r==1){
                        $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');
                        alertify.success("Eliminado con exito");
                    }else{
                        alertify.error("No se pudo eliminar");
                    }
                }
            });
        }, function(){ 
            alertify.error('Cancelar')});
    }
</script>

<!-- Actualiza usuario -->
<script>
    $(document).ready(function(){
        $('#btnActualizaUsuario').click(function(){
            datos=$('#frmRegistroU').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/usuarios/actualizaUsuario.php",
                success:function(r){
                    if(r==1){
                        $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');
                        alertify.success("Se actualizo con exito");
                    }else{
                        alertify.error("No se pudo actualizar");
                    }
                }
            });
        });
    });
</script>

<!-- Validar campos vacios y agregar registros -->
<script>
    $(document).ready(function(){

        $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');

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
                        $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php');
                        alertify.success("Registrado con exito!");
                    }else{
                        alertify.error("Hubo un error");
                    }
                }
            });
        });
    });
</script>

<?php
    }else{
        header("location:../index.php");
    }
?>