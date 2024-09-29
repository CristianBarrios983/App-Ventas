<?php
    session_start();
?>

<div class="row">
  <div class="col-lg-8">
    <div class="section-title">
      <p class="my-3 fs-5" id="nombreclienteVenta"></p>
    </div>
  </div>
</div>

<table class="table table-hover">
    <caption>
        <span class="btn btn-success rounded-0" onclick="crearVenta()">Hacer venta
            <span class="bi bi-currency-dollar"></span>
    </span>
    </caption>
  <thead class="table-dark">
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Descripcion</th>
      <!-- <th scope="col">Imagen</th> -->
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
      <!-- <td>
        <img src="<?php echo substr($d[5],3) ?>" alt="" width="80px" height="80px">
      </td> -->
      <td><?php echo number_format((float)$d[3], 2); ?></td>
      <!-- Input para modificar la cantidad -->
      <td>
        <input type="number" class="form-control form-control-lg fs-6 rounded-0" id="cantidad_<?php echo $i; ?>" name="cantidad" value="<?php echo $d[4]; ?>" min="1" onchange="actualizarCantidad(<?php echo $i; ?>, this.value, <?php echo $d[0]; ?>)">
      </td>
      <td>
          <span class="btn btn-danger btn-xs rounded-0" onclick="quitarP('<?php echo $i; ?>')">
                <span class="bi bi-x-lg"></span>
            </span>
      </td>
    </tr>
    <?php 
            $total = (float)$total + $d[3];
            $i++;
        }
        endif;    
    ?>
    <tr>
        <td colspan="5">Total: <?php echo '<label class="fw-bold text-success">$</label>'.number_format((float)$total, 2); ?></td>
    </tr>
  </tbody>
</table>

<script>
    $(document).ready(function(){
        nombre="<?php echo $_SESSION['cliente'] ?>";
        $('#nombreclienteVenta').text("Cliente: " + nombre);
    });
</script>