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
        <div class="row">
          <div class="col-lg-8">
            <div class="section-title">
              <h2 class="my-3">Panel de control</h2>
            </div>
          </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 rounded-0 border-info">
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
            <div class="card radius-10 border-start border-0 border-3 rounded-0 border-danger">
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
            <div class="card radius-10 border-start border-0 border-3 rounded-0 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Productos</p>
                        <?php
                                $c= new conectar();
                                $conexion=$c->conexion();

                                $sql = "SELECT COUNT(id_producto) AS total 
                                                                FROM articulos 
                                                                WHERE estado = 1
                                                                ";
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
        <?php if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Supervisor"): ?>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 rounded-0 border-warning">
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
        <?php endif; ?> 
        </div>
        
        <div class="row">
            <?php
                if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Supervisor"):
            ?>
            <div class="col-6">
                <!-- Produtos mas vendidos -->
                <div class="mas-vendidos">
                    <table class="table table-hover">
                        <thead class="table-dark text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Vendidos</th>
                            </tr>
                        </thead>
                        <?php 
                            $c= new conectar();
                            $conexion=$c->conexion();

                            $sql="SELECT articulos.nombre, articulos.descripcion, SUM(detalles.cantidad) AS cantidad
                                    FROM detalles 
                                    JOIN articulos ON detalles.producto = articulos.id_producto
                                    WHERE articulos.estado = 1  -- Solo productos activos
                                    GROUP BY articulos.id_producto
                                    ORDER BY cantidad DESC  -- Ordenar por cantidad de mayor a menor
                                    LIMIT 10;
                                ";

                            $result=mysqli_query($conexion,$sql);
                            $id=0;

                            while($mostrar=mysqli_fetch_row($result)): 
                            $id=$id+1;

                        ?>
                        <tbody class="text-center">
                            <tr>
                                <th scope="row"><?php echo $id; ?></th>
                                <td><?php echo $mostrar[0]." ".$mostrar[1] ?></td>
                                <td><?php echo $mostrar[2]; ?></td>
                            </tr>
                        </tbody>
                        <?php endwhile;?>
                    </table>
                </div>
            </div>
            <?php endif; ?>
    </div>

</body>
</html>

<?php
    }else{
        header("../index.php");
    }
?>