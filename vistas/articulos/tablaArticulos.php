<?php
    require_once "../../clases/Conexion.php";
    $c= new conectar();
    $conexion=$c->conexion();

    $sql="SELECT art.nombre,
                    art.descripcion,
                    art.cantidad,
                    art.precio,
                    img.ruta,
                    cat.nombreCategoria,
                    art.id_producto 
                    from articulos as art
                    inner join imagenes as img on art.id_imagen=img.id_imagen
                    inner join categorias as cat on art.id_categoria=cat.id_categoria";

    $result=mysqli_query($conexion,$sql);
?>

<table class="table">
  <thead class="table-dark">
    <h6>Articulos:</h6>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Precio</th>
      <th scope="col">Imagen</th>
      <th scope="col">Categoria</th>
<<<<<<< HEAD
      <th scope="col">Agregar stock</th>
=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
      <th scope="col">Editar</th>
      <th scope="col">Eliminar</th>
    </tr>
  </thead>
  <?php while($mostrar=mysqli_fetch_row($result)): ?>
  <tbody>
    <tr>
      <td><?php echo $mostrar[0]; ?></td>
      <td><?php echo $mostrar[1]; ?></td>
      <td><?php echo $mostrar[2]; ?></td>
      <td><?php echo $mostrar[3]; ?></td>
      <td>
          <?php 
            $imgMostrar=explode("/", $mostrar[4]);
            $imgRuta=$imgMostrar[1]."/".$imgMostrar[2]."/".$imgMostrar[3]; 
            ?>
            <img width="80" height="80" src="<?php echo $imgRuta ?>">
      </td>
      <td><?php echo $mostrar[5]; ?></td>
      <td>
<<<<<<< HEAD
          <span data-toggle="modal" data-target="#abremodalAgregaStock" class="btn btn-success btn-xs" onclick="agregaDatosArticulo('<?php echo $mostrar[6] ?>')">
                <span class="bi bi-plus-lg"></span>
            </span>
      </td>
      <td>
=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
          <span data-toggle="modal" data-target="#abremodalUpdateArticulo" class="btn btn-warning btn-xs" onclick="agregaDatosArticulo('<?php echo $mostrar[6] ?>')">
                <span class="bi bi-pen-fill"></span>
            </span>
      </td>
      <td>
          <span class="btn btn-danger btn-xs" onclick="eliminaArticulo('<?php echo $mostrar[6] ?>')">
                <span class="bi bi-trash3-fill"></span>
            </span>
      </td>
    </tr>
  </tbody>
  <?php endwhile;?>
</table>