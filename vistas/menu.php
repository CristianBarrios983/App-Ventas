<?php
    require_once "dependencias.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand">App de ventas</a>
<!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="inicio.php">Inicio</a>
    </li>

    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Administrar productos
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="categorias.php">Categorias</a>
        <a class="dropdown-item" href="articulos.php">Articulos</a>
      </div>
    </li>


  <?php
    if($_SESSION['id_usuario']==1):
  ?>
    <li class="nav-item">
      <a class="nav-link" href="usuarios.php">Administrar usuarios</a>
    </li>
  <?php
   endif;
  ?>


  <li class="nav-item">
      <a class="nav-link" href="clientes.php">Cliente</a>
  </li>
  <li class="nav-item">
      <a class="nav-link" href="ventas.php">Ventas</a>
    </li>
  </ul>

<ul class="navbar-nav ml-md-auto d-md-flex">
<li class="nav-item">
      <a class="nav-link"><label for=""><span>Usuario: <b class="text-success"><?php echo $_SESSION['usuario']; ?></b></span></label></a>
    </li>
<li class="nav-item">
      <a class="btn btn-primary" href="..//procesos/salir.php">Salir</a>
    </li>
</ul>
</nav>
</body>
</html>
