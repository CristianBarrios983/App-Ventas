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
    <title>Clientes</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    <div class="container">
        <h2>Clientes</h2>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Registro cliente</h5>
                    <form action="" id="frmClientes">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombre" id="nombre">
                        <label for="">Apellido</label>
                        <input type="text" class="form-control input-sm" name="apellidos" id="apellidos">
                        <label for="">Direccion</label>
                        <input type="text" class="form-control input-sm" name="direccion" id="direccion">
                        <label for="">Email</label>
                        <input type="text" class="form-control input-sm" name="email" id="email">
                        <label for="">Telefono</label>
                        <input type="text" class="form-control input-sm" name="telefono" id="telefono">
                        <p></p>
                        <span class="btn btn-primary" id="btnAgregaCliente">Agregar</span>
                    </form>
                  </div>
                </div>
              </div>
            <div class="col-sm-6">
                <div id="tablaClientesLoad"></div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    

    <!-- Modal -->
    <div class="modal fade" id="abremodalClientesUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" id="frmClientesU">
                    <input type="text" hidden="" id="idclienteU" name="idclienteU">
                    <label for="">Nombre</label>
                    <input type="text" class="form-control input-sm" name="nombreU" id="nombreU">
                    <label for="">Apellido</label>
                    <input type="text" class="form-control input-sm" name="apellidosU" id="apellidosU">
                    <label for="">Direccion</label>
                    <input type="text" class="form-control input-sm" name="direccionU" id="direccionU">
                    <label for="">Email</label>
                    <input type="text" class="form-control input-sm" name="emailU" id="emailU">
                    <label for="">Telefono</label>
                    <input type="text" class="form-control input-sm" name="telefonoU" id="telefonoU">
                </form>
        </div>
        <div class="modal-footer">
            <button id="btnAgregarClienteU" type="button" class="btn btn-primary" data-dismiss="modal">Actualizar</button>
        </div>
        </div>
    </div>
    </div>
</body>
</html>

<!-- Script para agregar clientes -->
<script type="text/javascript">
    $(document).ready(function(){

        $('#tablaClientesLoad').load("clientes/tablaClientes.php");
        $('#btnAgregaCliente').click(function(){

            vacios=validarFormVacio('frmClientes');

            if(vacios > 0){
                alertify.alert("Los campos no deben estar vacios");
                return false;
            }
            
        datos=$('#frmClientes').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/clientes/agregaCliente.php",
                success:function(r){
                    if(r==1){
                        $('#frmClientes')[0].reset();
                        $('#tablaClientesLoad').load("clientes/tablaClientes.php");
                        alertify.success("Cliente agregado exitosamente");
                    }else{
                        alertify.error("No se pudo agregar el cliente :(");
                    }
                }
            });
        });
    })
</script>

<!-- Agrega datos a la modal -->
<script>
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

    function eliminarCliente(idcliente){
        alertify.confirm('¿Desea eliminar este cliente?', function(){ 
            // alertify.success('Ok') 
            $.ajax({
                type:"POST",
                data:"idcliente=" + idcliente,
                url:"../procesos/clientes/eliminarCliente.php",
                success:function(r){
                    if(r==1){
                        $('#tablaClientesLoad').load('clientes/tablaClientes.php');
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
</script>

<!-- Actualiza clientes -->
<script>
    $(document).ready(function(){
        $('#btnAgregarClienteU').click(function(){
            datos=$('#frmClientesU').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/clientes/actualizaCliente.php",
                success:function(r){
                    if(r==1){
                        $('#frmClientes')[0].reset();
                        $('#tablaClientesLoad').load("clientes/tablaClientes.php");
                        alertify.success("Cliente actualizado exitosamente");
                    }else{
                        alertify.error("No se pudo actualizar :(");
                    }
                }
            });
        })
    })
</script>

<?php
    }else{
        header("location:../index.php");
    }
?>