<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    $c= new conectar();
    $conexion=$c->conexion();

    $obj= new ventas();

    $sql="SELECT id_venta,fechaCompra,id_cliente from ventas group by id_venta";
    $result=mysqli_query($conexion,$sql);

?>

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
    </tr>
  </tbody>
  <?php endwhile;?>
</table>