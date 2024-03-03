<?php
    require_once "../clases/Conexion.php";
    session_start();
    if(isset($_SESSION['usuario'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" type="text/css" href="../css/cards.css">
    <?php require_once "menu.php"; ?>
</head>
<body>
    <div class="container">
        <h2>Panel de control</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
       <div class="col">
         <div class="card radius-10 border-start border-0 border-3 border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Ventas</p>
                        <?php
                            $c= new conectar();
                            $conexion=$c->conexion();

                            $sql = "SELECT COUNT(DISTINCT id_venta) total FROM ventas ";
                            $result = mysqli_query($conexion,$sql);
                            $ventas = mysqli_fetch_assoc($result);
                          ?>
                        <h4 class="my-1 text-info"><?php echo $ventas['total'];?></h4>
                        <p class="mb-0 font-13">Total de ventas</p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class="bi bi-bag-fill"></i>
                    </div>
                </div>
            </div>
         </div>
       </div>
       <div class="col">
        <div class="card radius-10 border-start border-0 border-3 border-danger">
           <div class="card-body">
               <div class="d-flex align-items-center">
                   <div>
                       <p class="mb-0 text-secondary">Clientes</p>
                       <?php
                            $c= new conectar();
                            $conexion=$c->conexion();

                            $sql = "SELECT COUNT(id_cliente) total FROM clientes";
                            $result = mysqli_query($conexion,$sql);
                            $clientes = mysqli_fetch_assoc($result);
                          ?>
                       <h4 class="my-1 text-danger"><?php echo $clientes['total'];?></h4>
                       <p class="mb-0 font-13">Total de clientes</p>
                   </div>
                   <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class="bi bi-person-fill"></i>
                   </div>
               </div>
           </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10 border-start border-0 border-3 border-success">
           <div class="card-body">
               <div class="d-flex align-items-center">
                   <div>
                       <p class="mb-0 text-secondary">Productos</p>
                       <?php
                            $c= new conectar();
                            $conexion=$c->conexion();

                            $sql = "SELECT COUNT(id_producto) total FROM articulos";
                            $result = mysqli_query($conexion,$sql);
                            $productos = mysqli_fetch_assoc($result);
                          ?>
                       <h4 class="my-1 text-success"><?php echo $productos['total'];?></h4>
                       <p class="mb-0 font-13">Total de clientes</p>
                   </div>
                   <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="bi bi-box-fill"></i>
                   </div>
               </div>
           </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10 border-start border-0 border-3 border-warning">
           <div class="card-body">
               <div class="d-flex align-items-center">
                   <div>
                       <p class="mb-0 text-secondary">Total hoy</p>
                       <?php
                        $c= new conectar();
                        $conexion=$c->conexion();
                        $fechaActual=date("Y-m-d");
                        
                        $sql = "SELECT SUM(total) ingresos FROM ventas WHERE fechaCompra='$fechaActual'";
                        $result = mysqli_query($conexion,$sql);
                        $totalingresos = mysqli_fetch_assoc($result);
                      ?>
                       <h4 class="my-1 text-warning">
                            <?php 
                                if($totalingresos['ingresos']==NULL){
                                    echo '$0';
                                }else{
                                    echo '$'.$totalingresos['ingresos'];
                                }
                            ?>
                        </h4>
                       <p class="mb-0 font-13">Total generado</p>
                   </div>
                   <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class="bi bi-currency-dollar"></i>
                   </div>
               </div>
           </div>
        </div>
      </div> 
    </div>
    <div class="row">
    <?php
    if($_SESSION['id_usuario']==1):
    ?>
    <div class="col">
        <h5>Productos mas vendidos</h5>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Producto</th>
                <th scope="col">Unidades vendidas</th>
            </tr>
        </thead>
        <?php 
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT articulos.nombre, articulos.descripcion, SUM(detalles.cantidad) as cantidad
                FROM detalles JOIN articulos ON detalles.producto = articulos.id_producto
                GROUP BY articulos.id_producto
                ORDER BY COUNT(detalles.producto) DESC LIMIT 5;";

            $result=mysqli_query($conexion,$sql);
            $id=0;

            while($mostrar=mysqli_fetch_row($result)): 
            $id=$id+1;

        ?>
        <tbody>
            <tr>
                <th><?php echo $id; ?></th>
                <td><?php echo $mostrar[0]." ".$mostrar[1] ?></td>
                <td><?php echo $mostrar[2]; ?></td>
            </tr>
        </tbody>
        <?php endwhile;?>
    </table>
    </div>
    
    <div class="card col" style="width: 18rem;">
        <div class="card-body" id="datosNegocio">
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
            <h5 class="card-title">Datos del negocio</h5>
            <?php if(!$validar): ?>
                <p class="card-text">No hay datos de su negocio.</p>
                <a href="#" class="btn btn-primary" id="registrarNegocio">Añadir datos</a>
            <?php endif; ?>

            <?php if($validar > 0): ?>
            <?php
                require_once "../Clases/Conexion.php";
                $obj= new conectar();
                $conexion=$obj->conexion();

                $sql="SELECT id_negocio,nombre,direccion,telefono,fechaRegistro from negocio_info";
                $result=mysqli_query($conexion,$sql);
                $datos=mysqli_fetch_assoc($result);
            ?>
            <h6 class="card-subtitle mb-2 text-muted">Nombre: <span class="text-primary"><?php echo $datos['nombre'] ?></span></h6>
            <br>
            <h6 class="card-subtitle mb-2 text-muted">Direccion: <span class="text-primary"><?php echo $datos['direccion'] ?></span></h6>
            <br>
            <h6 class="card-subtitle mb-2 text-muted">Telefono: <span class="text-primary"><?php echo $datos['telefono'] ?></span></h6>
            <br>
            <h6 class="card-subtitle mb-2 text-muted">Fecha de registro: <span class="text-primary"><?php echo $datos['fechaRegistro'] ?></span></h6>
            <br>
            <a class="btn btn-primary" data-toggle="modal" data-target="#actualizaNegocioModal" onclick="agregaDatosNegocio('<?php echo $datos['id_negocio']; ?>')">Actualizar datos</a>
            <a class="btn btn-danger" id="eliminarNegocio" onclick="eliminarNegocio()">Eliminar datos</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    </div>
</div>

<!-- Modal -->
    <div class="modal fade" id="actualizaNegocioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar negocio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" id="frmNegocioU">
                    <input type="text" hidden="" id="idnegocioU" name="idnegocioU">
                    <label for="">Nombre</label>
                    <input type="text" class="form-control input-sm" name="nombreU" id="nombreU">
                    <label for="">Direccion</label>
                    <input type="text" class="form-control input-sm" name="direccionU" id="direccionU">
                    <label for="">Telefono</label>
                    <input type="text" class="form-control input-sm" name="telefonoU" id="telefonoU">
                    <label for="">Fecha de Registro</label>
                    <input type="text" class="form-control input-sm" name="fechaU" id="fechaU" readonly="readonly">
            </form>
        </div>
        <div class="modal-footer">
            <button id="actualizarNegocioU" type="button" class="btn btn-primary" data-dismiss="modal">Actualizar</button>
        </div>
        </div>
    </div>
    </div>

</body>
</html>

<!-- Script para desplegar el form de registro de negocio -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#registrarNegocio').click(function(){
            esconderInfoNegocio();
            $('#datosNegocio').load('negocio/formRegistroNegocio.php');
            $('#datosNegocio').show();
        });
    });

    function esconderInfoNegocio(){
        $('#datosNegocio').hide();
    }
</script>

<!-- Añadir datos a modal y eliminar negocio -->
<script>
    function agregaDatosNegocio(idnegocio){
        $.ajax({
            type:"POST",
            data:"idnegocio=" + idnegocio,
            url:"../procesos/negocio/obtenerDatosNegocio.php",
            success:function(r){
                dato=jQuery.parseJSON(r);

                $('#idnegocioU').val(dato['id_negocio']);
                $('#nombreU').val(dato['nombre']);
                $('#direccionU').val(dato['direccion']);
                $('#telefonoU').val(dato['telefono']);
                $('#fechaU').val(dato['fechaRegistro']);
            }
        });
    }

    function eliminarNegocio(idnegocio){
        alertify.confirm('¿Desea eliminar los datos de este negocio?', function(){ 
            // alertify.success('Ok') 
            $.ajax({
                type:"POST",
                data:"idnegocio=" + idnegocio,
                url:"../procesos/negocio/eliminarNegocio.php",
                success:function(r){
                    if(r==1){
                        window.location.href="inicio.php";
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

<!-- Actualiza negocio -->
<script>
    $(document).ready(function(){
        $('#actualizarNegocioU').click(function(){
            datos=$('#frmNegocioU').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/negocio/actualizaNegocio.php",
                success:function(r){
                    if(r==1){
                        window.location.href="inicio.php";
                        alertify.success("Negocio actualizado exitosamente");
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
        header("../index.php");
    }
?>