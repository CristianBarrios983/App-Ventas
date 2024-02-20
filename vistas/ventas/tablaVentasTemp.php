<?php
    session_start();
<<<<<<< HEAD
?>

=======
    // print_r($_SESSION['tablaComprasTemp']);

?>

<h2>Hacer venta</h2>
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
<h4><strong><div id="nombreclienteVenta"></div></strong></h4>

<table class="table">
    <caption>
<<<<<<< HEAD
        <span class="btn btn-success" onclick="crearVenta()">Hacer venta
=======
        <span class="btn btn-success" onclick="crearVenta()">Generar venta
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
            <span class="bi bi-currency-dollar"></span>
    </span>
    </caption>
  <thead class="table-dark">
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Descripcion</th>
<<<<<<< HEAD
      <!-- <th scope="col">Imagen</th> -->
=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
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
<<<<<<< HEAD
      <!-- <td>
        <img src="<?php echo substr($d[5],3) ?>" alt="" width="80px" height="80px">
      </td> -->
      <td><?php echo $d[3]; ?></td>
      <td><?php echo $d[4]; ?></td>
=======
      <td><?php echo $d[3] ?></td>
      <td><?php echo 1; ?></td>
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
      <td>
          <span class="btn btn-danger btn-xs" onclick="quitarP('<?php echo $i; ?>')">
                <span class="bi bi-x-lg"></span>
            </span>
      </td>
    </tr>
    <?php 
            $total=$total + $d[3];
            $i++;
<<<<<<< HEAD
            // $cliente=$d[6];
=======
            $cliente=$d[4];
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
        }
        endif;    
    ?>
    <tr>
<<<<<<< HEAD
        <td class="text-bold">Total <?php echo "$".$total; ?></td>
=======
        <td>Total de venta <?php echo "$".$total; ?></td>
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
    </tr>
  </tbody>
</table>

<script>
    $(document).ready(function(){
<<<<<<< HEAD
        nombre="<?php echo $_SESSION['cliente'] ?>";
=======
        nombre="<?php echo @$cliente ?>";
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
        $('#nombreclienteVenta').text("Cliente: " + nombre);
    });
</script>