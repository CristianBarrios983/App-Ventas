<?php
    session_start();
    require_once "../../clases/Conexion.php";
    $c= new conectar();
    $conexion=$c->conexion();

    $sql="SELECT art.nombre,
       art.descripcion,
       art.cantidad,
       art.precio,
       img.ruta,
       cat.nombreCategoria,
       art.id_producto,
       art.stock_minimo
        FROM articulos AS art
        INNER JOIN imagenes AS img ON art.id_imagen = img.id_imagen
        INNER JOIN categorias AS cat ON art.id_categoria = cat.id_categoria
        WHERE art.estado = 1
        ";

    $result=mysqli_query($conexion,$sql);
?>

<table class="table text-center" id="tablaProductos">
  <thead class="table-dark">
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Imagen</th>
      <th scope="col">Stock Actual</th>
      <th scope="col">Stock minimo</th>
      <th scope="col">Precio</th>
      <th scope="col">Categoria</th>
      <?php if($_SESSION['rol'] == "Administrador"): ?>
      <th scope="col" colspan="3">Acciones</th>
      <?php endif; ?>

    </tr>
  </thead>
  <tbody>
  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while($mostrar=mysqli_fetch_row($result)): ?>
      <?php
      $claseBajoStock = ($mostrar[2] <= $mostrar[7]) ? 'bajo-stock' : '';
      ?>

    <tr>
      <td class="<?= $claseBajoStock; ?>"><?php echo $mostrar[0]; ?></td>
      <td class="<?= $claseBajoStock; ?>"><?php echo $mostrar[1]; ?></td>
      <td class="<?= $claseBajoStock; ?>">
          <?php 
            $imgMostrar=explode("/", $mostrar[4]);
            $imgRuta=$imgMostrar[1]."/".$imgMostrar[2]."/".$imgMostrar[3]; 
            ?>
            <img width="80" height="80" src="<?php echo $imgRuta ?>">
      </td>
      <td class="<?= $claseBajoStock; ?>"><?php echo $mostrar[2]; ?></td>
      <td class="<?= $claseBajoStock; ?>"><?php echo $mostrar[7]; ?></td>
      <td class="<?= $claseBajoStock; ?>"><?php echo '<label class="fw-bold text-success">$</label>'.$mostrar[3]; ?></td>
      <td class="<?= $claseBajoStock; ?>"><?php echo $mostrar[5]; ?></td>
      <td class="<?= ($mostrar[2] <= $mostrar[7]) ? 'bajo-stock' : '' ?>">
          <span data-bs-toggle="modal" data-bs-target="#abremodalAgregaStock" class="btn btn-success btn-xs rounded-0" onclick="agregaDatosActualizarStock('<?php echo $mostrar[6] ?>','<?php echo $mostrar[2] ?>')">
                <span class="bi bi-plus-lg"></span>
            </span>
      </td>
      <td class="<?= $claseBajoStock; ?>">
          <span data-bs-toggle="modal" data-bs-target="#abremodalUpdateArticulo" class="btn btn-warning btn-xs rounded-0" onclick="agregaDatosArticulo('<?php echo $mostrar[6] ?>')">
                <span class="bi bi-pen-fill"></span>
            </span>
      </td>
      <td class="<?= $claseBajoStock; ?>">
          <span class="btn btn-danger btn-xs rounded-0" onclick="eliminaArticulo('<?php echo $mostrar[6] ?>')">
                <span class="bi bi-trash3-fill"></span>
            </span>
      </td>
    </tr>
    <?php endwhile;?>
  <?php else: ?>
      <tr>
            <td colspan="9">No hay productos registrados.</td>
        </tr>
    <?php endif; ?>
  </tbody>
</table>

