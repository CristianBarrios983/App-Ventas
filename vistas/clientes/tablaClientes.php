<?php
    session_start();
    require_once "../../clases/Conexion.php";

    $c= new conectar();
    $conexion=$c->conexion();

    $sql="SELECT id_cliente,nombre,apellido,direccion,email,telefono FROM clientes";
    $result=mysqli_query($conexion,$sql);
?>

<table class="table table-hover text-center">
  <thead class="table-dark">
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Direccion</th>
      <th scope="col">Email</th>
      <th scope="col">Telefono</th>
      <?php if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Supervisor"): ?>
      <th scope="col" colspan="2">Acciones</th>
      <?php endif; ?>
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
      <?php if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Supervisor"): ?>
      <td>
          <span class="btn btn-warning btn-xs rounded-0" data-bs-toggle="modal" data-bs-target="#abremodalClientesUpdate" onclick="agregaDatosCliente('<?php echo $mostrar[0]; ?>')">
              <span class="bi bi-pen-fill"></span>
          </span>
      </td>
      <td>
          <span class="btn btn-danger btn-xs rounded-0" onclick="eliminarCliente('<?php echo $mostrar[0]; ?>')">
              <span class="bi bi-trash3-fill"></span>
          </span>
      </td>
      <?php endif; ?>
    </tr>
  </tbody>
  <?php endwhile;?>
</table>