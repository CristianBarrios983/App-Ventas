<?php
    require_once "Clases/Conexion.php";
    $obj= new conectar();
    $conexion=$obj->conexion();

    $sql="SELECT * from usuarios where id_usuario=1";
    $result=mysqli_query($conexion,$sql);
    $validar=0;
    if(mysqli_num_rows($result) > 0){
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
    <script src="librerias/jquery-3.6.1.min.js"></script>
    <script src="js/funciones.js"></script>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <br>
    <br>
    <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <div class="card-body">
              <h1>Registro</h1>
              <p class="text-muted">Registre su cuenta</p>
            <form id="frmRegistro">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre">
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Apellido" name="apellido" id="apellido">
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario">
              </div>
              <div class="input-group mb-4">
                <input type="password" class="form-control" placeholder="Contraseña" name="password" id="password">
              </div>
              <div class="row">
                <div class="col-6">
                  <button type="button" class="btn btn-primary px-4" id="registro">Registrar</button>
                </div>
                <div class="col-6">
                  <a type="button" class="btn btn-danger px-4" href="index.php">Regresar</a>
                </div>
              </div>
            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>Dato</h2>
                <p>Al registrarse por primera vez se le asignara el rol de admin</p>
              </div>
          </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<script>
    $(document).ready(function(){
        $('#registro').click(function(){

            vacios=validarFormVacio('frmRegistro');

            if(vacios > 0){
                alert("Los campos no deben estar vacios");
                return false;
            }

            datos=$('#frmRegistro').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"procesos/regLogin/registrarUsuario.php",
                success:function(r){

                    if(r==1){
                        window.location.href="index.php";
                        alert("Registrado con exito!");
                    }else{
                        alert("Hubo un error");
                    }
                }
            });
        });
    });
</script>