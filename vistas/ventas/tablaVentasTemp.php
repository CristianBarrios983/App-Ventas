<?php
    session_start();
    // print_r($_SESSION['tablaComprasTemp']);

?>

<h2>Hacer venta</h2>
<h4><strong><div id="nombreclienteVenta"></div></strong></h4>

<table class="table">
    <caption>
        <span class="btn btn-success" onclick="crearVenta()">Generar venta
            <span class="bi bi-currency-dollar"></span>
    </span>
    </caption>
  <thead class="table-dark">
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Precio</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Quitar</th>
    </tr>
  </thead>
  <?php 
    // Esta variable contiene el total de la compra
    $total=0;
    // Almacena el nombre del cliente
    $cliente="";
        if(isset($_SESSION['tablaComprasTemp'])):
            $i=0;
            foreach (@$_SESSION['tablaComprasTemp'] as $key){

                $d=explode("||", @$key);
 
   ?>
  <tbody>
    <tr>
      <td><?php echo $d[1] ?></td>
      <td><?php echo $d[2] ?></td>
      <td><?php echo $d[3] ?></td>
      <td><?php echo 1; ?></td>
      <td>
          <span class="btn btn-danger btn-xs" onclick="quitarP('<?php echo $i; ?>')">
                <span class="bi bi-x-lg"></span>
            </span>
      </td>
    </tr>
    <?php 
            $total=$total + $d[3];
            $i++;
            $cliente=$d[4];
        }
        endif;    
    ?>
    <tr>
        <td>Total de venta <?php echo "$".$total; ?></td>
    </tr>
  </tbody>
</table>

<script>
    $(document).ready(function(){
        nombre="<?php echo @$cliente ?>";
        $('#nombreclienteVenta').text("Cliente: " + nombre);
    });
</script>