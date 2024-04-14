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
        <div class="row">
          <div class="col-lg-8">
            <div class="section-title">
              <h2 class="my-3">Clientes</h2>
            </div>
          </div>
        </div>
        <div class="row mb-3">
            <?php if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Vendedor"): ?>
            <div class="col-lg-8">
                <button type="button" class="btn btn-primary rounded-0 w-auto d-inline-block" data-bs-toggle="modal" data-bs-target="#registraClienteModal">Registrar cliente</button>
            </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="tablaClientesLoad"></div>
            </div>
        </div>
    </div>


    <!-- Modal Registra Cliente -->
    <div class="modal fade" id="registraClienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar cliente</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" id="frmClientes">
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="nombre" id="nombre" placeholder="Nombre">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="apellidos" id="apellidos" placeholder="Apellido">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="direccion" id="direccion" placeholder="Direccion">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="email" id="email" placeholder="Correo electronico">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="telefono" id="telefono" placeholder="Telefono">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
            <button id="btnAgregaCliente" type="button" class="btn btn-primary rounded-0" data-bs-dismiss="modal">Registrar cliente</button>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal Actualiza Cliente -->
    <div class="modal fade" id="abremodalClientesUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar datos</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <form action="" id="frmClientesU">
                    <div class="mb-3">
                        <input type="text" hidden="" id="idclienteU" name="idclienteU">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label text-secondary fs-6">Nombre</label>
                        <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="nombreU" id="nombreU">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label text-secondary fs-6">Apellido</label>
                        <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="apellidosU" id="apellidosU">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label text-secondary fs-6">Direccion</label>
                        <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="direccionU" id="direccionU">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label text-secondary fs-6">Email</label>
                        <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="emailU" id="emailU">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label text-secondary fs-6">Telefono</label>
                        <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="telefonoU" id="telefonoU">
                    </div>
                </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
            <button id="btnAgregarClienteU" type="button" class="btn btn-primary rounded-0" data-bs-dismiss="modal">Actualizar</button>
        </div>
        </div>
    </div>
    </div>
</body>
</html>

<!-- Script para agregar clientes -->
<script type="text/javascript">
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

    $(document).ready(function(){
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