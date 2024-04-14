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
    <link rel="stylesheet" href="librerias/bootstrap-5.3.3-dist/css/bootstrap.css">
    <script src="librerias/jquery-3.6.1.min.js"></script>
    <script src="js/funciones.js"></script>
</head>
<body class="m-0 bg-dark">
    <div class="container d-flex justify-content-center align-items-center vh-100">
      <div class="login">
        <form id="frmRegistro" style="width: 18rem;" class="bg-white p-3">
          <div class="mb-3">
            <h3>Registro</h3>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="nombre" id="nombre" placeholder="Nombre" required>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="apellido" id="apellido" placeholder="Apellido" required>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="usuario" id="usuario" placeholder="Usuario" required>
          </div>
          <div class="mb-3">
            <input type="email" class="form-control form-control-lg fs-6 rounded-0" name="email" id="email" placeholder="Correo electronico" required>
          </div>
          <div class="mb-3">
            <input type="password" class="form-control form-control-lg fs-6 rounded-0" name="password" id="password" placeholder="Contraseña" required>
          </div>
          <div class="mb-3">
            <label for="" class="fs-6 text-success">Rol de Administrador</label>
            <input hidden id="rol" name="rol" value="1">
          </div>
          <div>
            <button type="button" id="registro" class="btn btn-primary rounded-0 d-block w-100">Registrarme</button>
          </div>
          <div class="mt-3">
            <a href="index.php" class="btn btn-danger rounded-0 d-block w-100">Volver</a>
          </div>
        </form>
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