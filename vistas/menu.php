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

<!-- Navbar Bootstrap 5.3.3 -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="#">App Ventas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="inicio.php">Panel</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administrar productos
          </a>
          <ul class="dropdown-menu rounded-0">
            <li><a class="dropdown-item" href="articulos.php">Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="categorias.php">Categorias</a></li>
          </ul>
        </li>
        <?php
          if($_SESSION['id_usuario']==1):
        ?>
        <li class="nav-item">
          <a class="nav-link" href="usuarios.php">Usuarios</a>
        </li>
        <?php
          endif;
        ?>
        <li class="nav-item">
          <a class="nav-link" href="clientes.php">Clientes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ventas.php">Ventas</a>
        </li>
      </ul>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
          <a class="nav-link disabled" href="ventas.php">Usuario: <span class="text-success fw-bold"><?php echo $_SESSION['usuario']; ?></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="..//procesos/salir.php">Salir</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</body>
</html>
