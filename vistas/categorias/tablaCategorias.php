<?php
    session_start();
    require_once "../../clases/Conexion.php";
    $c= new conectar();
    $conexion=$c->conexion();

    $sql="SELECT id_categoria,nombreCategoria FROM categorias;";

    $result=mysqli_query($conexion,$sql);
?>

<table class="table table-hover">
  <thead class="table-dark">
    <tr>
      <th scope="col">Categoria</th>
      <?php if($_SESSION['rol'] == "Administrador"): ?>
      <th scope="col" colspan="2">Acciones</th>
      <?php endif; ?>
    </tr>
  </thead>
  <?php while($mostrar=mysqli_fetch_row($result)): ?>
  <tbody>
    <tr>
      <td><?php echo $mostrar[1]; ?></td>
      <?php if($_SESSION['rol'] == "Administrador"): ?>
      <td>
          <span class="btn btn-warning btn-xs rounded-0" data-bs-toggle="modal" data-bs-target="#actualizaCategoria" onclick="agregaDato('<?php echo $mostrar[0] ?>','<?php echo $mostrar[1] ?>')">
                <span class="bi bi-pen-fill"></span>
            </span>
      </td>
      <td>
          <span class="btn btn-danger btn-xs rounded-0" onclick="eliminaCategoria('<?php echo $mostrar[0] ?>')">
                <span class="bi bi-trash3-fill"></span>
            </span>
      </td>
      <?php endif; ?>
    </tr>
  </tbody>
  <?php endwhile;?>
</table>