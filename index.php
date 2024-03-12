<?php
    session_start();
    require_once "vistas/dependencias.php";
    require_once "Clases/Conexion.php";
    $obj= new conectar();
    $conexion=$obj->conexion();

    $sql="SELECT * from usuarios where id_usuario=1";
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
    <title>Login de usuario</title>
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
    <script src="librerias/jquery-3.6.1.min.js"></script>
    <script src="js/funciones.js"></script>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <br>
    <br>
    <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <div class="card-body">
              <h1>Login</h1>
              <p>Ingrese a su cuenta</p>
            <form id="frmLogin">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Contraseña" name="password" id="password">
              </div>
              <div class="row">
                <div class="col-6">
                  <button type="button" class="btn btn-primary px-4" id="ingresarSistema">Entrar</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
            <?php if(!$validar): ?>
                <h2>Registrar</h2>
                <label>¿Es la primera vez que ingresa? Registrese con el boton de abajo</label>
                <a type="button" class="btn btn-success active mt-3" href="registro.php">Registrese</a>
            <?php endif; ?>
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

<script type="text/javascript">
    $(document).ready(function(){
        $('#ingresarSistema').click(function(){

            vacios=validarFormVacio('frmLogin');

                if(vacios > 0){
                    alert("Los campos no deben estar vacios");
                    return false;
                }

            datos=$('#frmLogin').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"procesos/regLogin/login.php",
                success:function(r){
                    if(r==1){
                        window.location="vistas/inicio.php";
                    }else{
                        alert("No se pudo acceder :(");
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