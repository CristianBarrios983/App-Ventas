<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Vendedor"){
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
    <title>Vender</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    
<div class="container">
    <div class="row">
        <div class="col-lg-8">
        <div class="section-title">
            <h2 class="my-3">Venta</h2>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4" id="formVenta">
            <div class="card rounded-0">
            <div class="card-body p-4">
                <form id="frmVentasProductos">
                        <div class="mb-3">
                            <select class="form-select form-select-lg fs-6 rounded-0" id="clienteVenta" name="clienteVenta">
                                <option value="" selected>Seleccione cliente</option>
                                <option value="0">Sin cliente</option>
                                <?php 
                                    // Consulta clientes
                                    $sqlCliente="SELECT id_cliente,nombre,apellido from clientes";
                                    $resultCliente=mysqli_query($conexion,$sqlCliente);
                                ?>
                                <?php while($cliente=mysqli_fetch_row($resultCliente)): ?>
                                    <option value="<?php echo $cliente[0] ?>"><?php echo $cliente[2]." ".$cliente[1] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Busqueda de producto -->
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg fs-6 rounded-0" id="productoBuscar" name="productoBuscar" placeholder="Buscar producto por nombre">
                            <input type="hidden" id="productoVenta" name="productoVenta"> <!-- Guarda el ID del producto seleccionado -->
                            <div id="sugerenciasProductos"></div> <!-- Aquí se mostrarán las sugerencias de productos -->
                        </div>



                        <div class="mb-3">
                            <textarea name="descripcionV" id="descripcionV" class="form-control form-control-lg fs-6 rounded-0" readonly></textarea>
                        </div>

                        <div class="mb-3">
                            <p class="text-danger fs-5" id="cantidadV" name="cantidadV"></p>
                            <input readonly hidden="" type="text" class="form-control form-control-lg fs-6 rounded-0" id="stock" name="stock">
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg fs-6 rounded-0" id="precioV" name="precioV" hidden>
                            <p class="text-success fs-5" id="precioP" name="precioP"></p>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" class="form-control form-control-lg fs-6 rounded-0" id="cantidad" name="cantidad" min="1" max="20">
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-primary rounded-0 d-block w-100" id="btnAgregaVenta">Agregar</button>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-danger rounded-0 d-block w-100" id="btnVaciarVentas">Vaciar todo</button>
                        </div>
                    
                        <div>
                            <p class="text-danger fs-5" id="message"></p>
                        </div>
                </form>
            </div>
            </div>
        </div>
        <!-- <div class="col-sm-3">
            <div id="imgProducto"></div>
        </div> -->
        <div class="col-sm-8">
            <div id="tablaVentasTempLoad"></div>
        </div>
    </div>
</div>

<script src="../js/ventas/ventas.js"></script>

<?php
        }else{
            header("location:inicio.php");
        }
    }else{
        header("location:../index.php");
    }
?>