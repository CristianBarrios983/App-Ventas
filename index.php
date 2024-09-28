<?php
    session_start();
    // require_once "vistas/dependencias.php";
    require_once "Clases/Conexion.php";
    $obj= new conectar();
    $conexion=$obj->conexion();

    $sql="SELECT * FROM usuarios WHERE id_usuario=1";
    $result=mysqli_query($conexion,$sql);
    $validar=0;
    if(mysqli_num_rows($result) > 0){
        $validar=1;
    }

    if(!isset($_SESSION['usuario'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="librerias/bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" href="librerias/alertifyjs/css/themes/default.css">
    <script src="librerias/jquery-3.6.1.min.js"></script>
    <script src="js/funciones.js"></script>
</head>
<body class="m-0 bg-dark">
    <div class="container d-flex justify-content-center align-items-center vh-100">
      <div class="login">
        <form id="frmLogin" style="width: 18rem;" class="bg-white p-3">
          <div class="mb-3">
            <h3>Acceder</h3>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="credencial" id="credencial" placeholder="Usuario o correo" required>
          </div>
          <div class="mb-3">
            <input type="password" class="form-control form-control-lg fs-6 rounded-0" name="password" id="password" placeholder="Contraseña" required>
          </div>
          <div>
            <button type="button" id="ingresarSistema" class="btn btn-primary rounded-0 d-block w-100">Entrar</button>
          </div>
          <?php if(!$validar): ?>
          <div class="mt-3">
            <a href="registro.php" class="btn btn-success rounded-0 d-block w-100">Registrarse</a>
          </div>
          <?php endif; ?>
        </form>
      </div>
    </div>
</body>
</html>

<script src="librerias/alertifyjs/alertify.js"></script>

<script type="text/javascript"> 
    $(document).ready(function() {
        $('#ingresarSistema').click(function() {
            // Llamar a la función de validación para el formulario
            let esValido = validarFormulario('frmLogin'); 

            if (!esValido) {
                return false; // Si la validación falla, no se envía el formulario
            }

            let datos = $('#frmLogin').serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "procesos/regLogin/login.php",
                success: function(r) {
                    if (r == 1) {
                        window.location = "vistas/inicio.php";
                    } else {
                        alertify.alert("No se pudo acceder :(");
                    }
                }
            });
        });
    });
</script>


<?php
    }else{
      header("Location: vistas/inicio.php");
    }
?>