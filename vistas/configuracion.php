<?php
    session_start();
    if(isset($_SESSION['usuario'])){
      if($_SESSION['rol'] == "Administrador"){

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
    <title>Configuracion</title>
    <?php require_once "menu.php"; ?>
</head>
<body>

    <div class="d-flex justify-content-center align-items-center my-5">
            <!-- Datos del negocio -->
            <div class="col-6">
                <div class="card text-center rounded-0" id="datosNegocio">
                    <div class="card-header">
                        Datos del negocio
                    </div>
                    <div class="card-body">
                        <?php
                            require_once "../Clases/Conexion.php";
                            $obj= new conectar();
                            $conexion=$obj->conexion();

                            $sql="SELECT * from negocio_info";
                            $result=mysqli_query($conexion,$sql);
                            $validar=0;
                            if(mysqli_num_rows($result) > 0){
                                $validar=1;
                            }
                        ?>

                        <!-- Validar si existen datos del negocio -->
                        <?php if(!$validar): ?>
                            <p class="card-text">No hay datos del negocio</p>
                            <?php if($_SESSION['rol'] == "Administrador"): ?>
                                <a href="#" class="btn btn-primary rounded-0 d-block w-100" id="registrarNegocio">Añadir negocio</a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php
                            require_once "../Clases/Conexion.php";
                            $obj= new conectar();
                            $conexion=$obj->conexion();

                            $sql="SELECT id_negocio,nombre,direccion,telefono,fechaRegistro from negocio_info";
                            $result=mysqli_query($conexion,$sql);
                            $datos=mysqli_fetch_assoc($result);
                        ?>
                        <?php if($validar > 0): ?>
                            <p class="card-text">Nombre: <span class="text-primary"><?php echo $datos['nombre'] ?></span></p>
                            <p class="card-text">Direccion: <span class="text-primary"><?php echo $datos['direccion'] ?></span></p>
                            <p class="card-text">Telefono: <span class="text-primary"><?php echo $datos['telefono'] ?></span></p>
                            <?php if($_SESSION['rol'] == "Administrador"): ?>
                                <a href="#" class="btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#actualizaNegocioModal" onclick="agregaDatosNegocio('<?php echo $datos['id_negocio']; ?>')">Actualizar</a>
                                <a href="#" class="btn btn-danger rounded-0" id="eliminarNegocio" onclick="eliminarNegocio()">Eliminar</a>
                            <?php endif; ?>
                    </div>
                    <div class="card-footer text-body-secondary">
                        Fue registrado el <?php echo $datos['fechaRegistro'] ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

    </div>
            


            <!-- Modal Bootstrap 5.3.3 -->
    <div class="modal fade" id="actualizaNegocioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="" id="frmNegocioU">
                    <div class="mb-3">
                        <input type="text" hidden="" id="idnegocioU" name="idnegocioU">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label text-secondary fs-6">Nombre</label>
                        <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="nombreU" id="nombreU">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label text-secondary fs-6">Direccion</label>
                        <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="direccionU" id="direccionU">
                    </div>
                    <div class="">
                        <label for="" class="form-label text-secondary fs-6">Telefono</label>
                        <input type="number" class="form-control form-control-lg fs-6 rounded-0" name="telefonoU" id="telefonoU">
                    </div>
            </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="actualizarNegocioU" type="submit" class="btn btn-primary rounded-0">Actualizar</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<script src="../js/negocio/negocio.js"></script>
<script src="../js/funciones.js"></script>


<?php
        }else{
          header("location:inicio.php");
        }
    }else{
        header("location:../index.php");
    }
?>