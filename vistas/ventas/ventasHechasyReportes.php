<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    $c= new conectar();
    $conexion=$c->conexion();

    $obj= new ventas();

    $sql="SELECT id_venta,fechaCompra,id_cliente from ventas group by id_venta";
    $result=mysqli_query($conexion,$sql);

?>

<!-- Modal detalles de venta Bootstrap 5.3.3 -->
<div class="modal fade" id="abremodalDetalles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles de venta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        

            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                    </tr>
                </thead>
                <tbody>
                <!-- Detalles aqui -->
                </tbody>
            </table>
                
            <p>Cantidad de productos: <span id="cantidadProductos" class="fw-bold"></span></p>
            <p>Total de venta: <span id="totalVenta" class="fw-bold"></span></p>

      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-lg-8">
    <div class="section-title">
        <h2 class="my-3">Reportes y ventas</h2>
    </div>
    </div>
</div>
<table class="table table-hover">
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Fecha</th>
      <th scope="col">Cliente</th>
      <th scope="col">Total</th>
      <th scope="col" colspan="3">Acciones</th>
    </tr>
  </thead>
  <?php while($mostrar=mysqli_fetch_row($result)): ?>
  <tbody>
    <tr>
      <th scope="row"><?php echo $mostrar[0]; ?></th>
      <td><?php echo $mostrar[1]; ?></td>
      <td>
          <?php
              if($obj->nombreCliente($mostrar[2])==" "){
                  echo "Sin cliente";
              }else{
                  echo $obj->nombreCliente($mostrar[2]);
              }
          ?>
      </td>
      <td>
          <?php
              echo "$".$obj->obtenerTotal($mostrar[0]);
          ?>
      </td>
      <td><a href="../procesos/ventas/crearTicketPdf.php?idventa=<?php echo $mostrar[0] ?>" class="btn btn-danger btn-xs rounded-0">
                            Ticket <span class=""></span>
                        </a></td>
      <td><a href="../procesos/ventas/crearReportePdf.php?idventa=<?php echo $mostrar[0] ?>" class="btn btn-primary btn-xs rounded-0">
                            Reporte <span class=""></span>
                        </a>   </td>
      <!-- Detalles de venta -->
      <td><a data-bs-toggle="modal" data-bs-target="#abremodalDetalles" class="btn btn-success btn-xs rounded-0" onclick="verDetalles(<?php echo $mostrar[0] ?>)">
          Detalles <span class=""></span>
      </a>   </td>
    </tr>
  </tbody>
  <?php endwhile;?>
</table>