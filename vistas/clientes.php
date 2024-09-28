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
            <button id="btnAgregaCliente" type="submit" class="btn btn-primary rounded-0">Registrar cliente</button>
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
            <button id="btnAgregarClienteU" type="submit" class="btn btn-primary rounded-0">Actualizar</button>
        </div>
        </div>
    </div>
    </div>
</body>
</html>

<script src="../js/clientes/clientes.js"></script>
<script src="../js/funciones.js"></script>

<?php
    }else{
        header("location:../index.php");
    }
?>