<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    $c= new conectar();
    $conexion=$c->conexion();

    $obj= new ventas();

    $sql="SELECT id_venta,fechaCompra,id_cliente from ventas group by id_venta";
    $result=mysqli_query($conexion,$sql);

?>

<!-- Modal muestra detalles -->
<div class="modal fade" id="abremodalDetalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    </table>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-warning" data-dismiss="modal" id="btnActualizaStock">Agregar</button> -->
            </div>
            </div>
        </div>
    </div>

<h2>Reportes y ventas</h2>
<table class="table">
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Fecha</th>
      <th scope="col">Cliente</th>
      <th scope="col">Total</th>
      <th scope="col">Ticket</th>
      <th scope="col">Reporte</th>
      <th scope="col">Detalles</th>
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
      <td><a href="../procesos/ventas/crearTicketPdf.php?idventa=<?php echo $mostrar[0] ?>" class="btn btn-danger btn-sm">
                            Ticket <span class=""></span>
                        </a></td>
      <td><a href="../procesos/ventas/crearReportePdf.php?idventa=<?php echo $mostrar[0] ?>" class="btn btn-primary btn-sm">
                            Reporte <span class=""></span>
                        </a>   </td>
      <!-- Detalles de venta -->
      <td><a data-toggle="modal" data-target="#abremodalDetalles" class="btn btn-success btn-sm" onclick="verDetalles(<?php echo $mostrar[0] ?>)">
          Detalles <span class=""></span>
      </a>   </td>
    </tr>
  </tbody>
  <?php endwhile;?>
</table>

