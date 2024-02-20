<?php
    require_once "../../clases/Conexion.php";

    $c= new conectar();
    $conexion=$c->conexion();

    $sql="SELECT id_cliente,nombre,apellido,direccion,email,telefono FROM clientes";
    $result=mysqli_query($conexion,$sql);
?>

<table class="table">
  <thead class="table-dark">
    <h6>Clientes:</h6>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Direccion</th>
      <th scope="col">Email</th>
      <th scope="col">Telefono</th>
      <th scope="col">Editar</th>
      <th scope="col">Eliminar</th>
    </tr>
  </thead>
  <?php while($mostrar=mysqli_fetch_row($result)): ?>
  <tbody>
    <tr>
      <td><?php echo $mostrar[1]; ?></td>
      <td><?php echo $mostrar[2]; ?></td>
      <td><?php echo $mostrar[3]; ?></td>
      <td><?php echo $mostrar[4]; ?></td>
      <td><?php echo $mostrar[5]; ?></td>
      <td>
          <span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#abremodalClientesUpdate" onclick="agregaDatosCliente('<?php echo $mostrar[0]; ?>')">
              <span class="bi bi-pen-fill"></span>
          </span>
      </td>
      <td>
          <span class="btn btn-danger btn-xs" onclick="eliminarCliente('<?php echo $mostrar[0]; ?>')">
              <span class="bi bi-trash3-fill"></span>
          </span>
      </td>
    </tr>
  </tbody>
  <?php endwhile;?>
</table>
</table>