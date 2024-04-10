<?php
    session_start();
    if(isset($_SESSION['usuario'])){
      if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Supervisor"){

        require_once "../clases/Conexion.php"; 
        $c= new conectar();
        $conexion=$c->conexion();
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
        <div class="row">
          <div class="col-lg-8">
            <div class="section-title">
              <h2 class="my-3">Usuarios</h2>
            </div>
          </div>
        </div>
        <div class="row mb-3">
            <?php if($_SESSION['rol'] == "Administrador"): ?>
            <div class="col-lg-8">
                <button type="button" class="btn btn-primary rounded-0 w-auto d-inline-block" data-bs-toggle="modal" data-bs-target="#registraUsuarioModal">Registrar usuario</button>
            </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="tablaUsuariosLoad"></div>
            </div>
        </div>
    </div>

<!-- Modal Registra Usuario -->
<div class="modal fade" id="registraUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
          <form id="frmRegistro">
              <div class="mb-3">
                <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="nombre" id="nombre" placeholder="Nombre">
              </div>
              <div class="mb-3">
                <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="apellido" id="apellido" placeholder="Apellido">
              </div>
              <div class="mb-3">
                <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="usuario" id="usuario" placeholder="Usuario">
              </div>
              <div class="mb-3">
                  <select class="form-select form-select-lg fs-6 rounded-0" name="rol" id="rol">
                      <option value="">Seleccione rol</option>
                      <?php
                          $sql="SELECT id_rol,rol from roles";
                          $result=mysqli_query($conexion,$sql);
                      ?>
                      <?php while($mostrar=mysqli_fetch_row($result)): ?>
                          <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
                      <?php endwhile; ?>
                  </select>
              </div>
              <div>
                <input type="password" class="form-control form-control-lg fs-6 rounded-0" name="password" id="password" placeholder="Contraseña">
              </div>
          </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="registro" type="button" class="btn btn-primary rounded-0" data-bs-dismiss="modal">Registrar usuario</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Actualiza Usuario -->
<div class="modal fade" id="actualizaUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form id="frmRegistroU">
          <div class="mb-3">
            <input type="text" hidden="" id="idUsuario" name="idUsuario">
          </div>
          <div class="mb-3">
            <label for="" class="form-label text-secondary fs-6">Nombre</label>
            <input type="text" name="nombreU" id="nombreU" class="form-control form-control-lg fs-6 rounded-0">
          </div>
          <div class="mb-3">
            <label for="" class="form-label text-secondary fs-6">Apellido</label>
            <input type="text" name="apellidoU" id="apellidoU" class="form-control form-control-lg fs-6 rounded-0">
          </div>
          <div class="mb-3">
            <label for="" class="form-label text-secondary fs-6">Usuario</label>
            <input type="text" name="usuarioU" id="usuarioU" class="form-control form-control-lg fs-6 rounded-0">
          </div>
          <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Cambiar rol</label>
                <select class="form-select form-select-lg fs-6 rounded-0" name="rolSelectU" id="rolSelectU">
                <option value="">Seleccione rol</option>
                    <?php 
                        $sql="SELECT id_rol,rol from roles";
                        $result=mysqli_query($conexion,$sql);
                    ?>
                    <?php while($mostrar=mysqli_fetch_row($result)): ?>
                        <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="btnActualizaUsuario" type="button" class="btn btn-primary rounded-0" data-bs-dismiss="modal">Actualizar</button>
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
                      $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php', function() {
                            // Inicializar DataTables después de cargar la tabla
                            let dataTable = new DataTable("#tablaUsuarios", {
                                perPage: 3,
                                perPageSelect: [3,5,10],
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
                      $('#tablaUsuariosLoad').load('usuarios/tablaUsuarios.php', function() {
                            // Inicializar DataTables después de cargar la tabla
                            let dataTable = new DataTable("#tablaUsuarios", {
                                perPage: 3,
                                perPageSelect: [3,5,10],
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
</script>

<!-- Validar campos vacios y agregar registros -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
        $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php", function() {
            // Inicializar DataTables después de cargar la tabla
            let dataTable = new DataTable("#tablaUsuarios", {
                perPage: 3,
                perPageSelect: [3,5,10],
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
                                perPage: 3,
                                perPageSelect: [3,5,10],
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
</script>


<?php
        }else{
          header("location:inicio.php");
        }
    }else{
        header("location:../index.php");
    }
?>