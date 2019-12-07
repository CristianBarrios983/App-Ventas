<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        if($_SESSION['rol'] == "Administrador"){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <?php require_once "menu.php"; ?>
    <?php 
        require_once "../clases/Conexion.php"; 
        $c= new conectar();
        $conexion=$c->conexion();

        $sql="SELECT id_categoria,nombreCategoria from categorias";
        $result=mysqli_query($conexion,$sql);
    ?>
</head>
<body>
    <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="section-title">
              <h2 class="my-3">Productos</h2>
            </div>
          </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-8">
                <button type="button" class="btn btn-primary rounded-0 w-auto d-inline-block" data-bs-toggle="modal" data-bs-target="#abremodalRegistroArticulo">Registrar producto</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="tablaArticulosLoad"></div>
            </div>
        </div>
    </div>

<!-- Modal Registra Producto -->
<div class="modal fade" id="abremodalRegistroArticulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar producto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form id="frmArticulos" enctype="multipart/form-data">
                <div class="mb-3">
                    <select class="form-select form-select-lg fs-6 rounded-0" name="categoriaSelect" id="categoriaSelect">
                        <option value="">Seleccione categoria</option>
                    <?php while($mostrar=mysqli_fetch_row($result)): ?>
                        <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
                    <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="nombre" id="nombre" placeholder="Nombre">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="descripcion" id="descripcion" placeholder="Descripcion">
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control form-control-lg fs-6 rounded-0" name="cantidad" id="cantidad" placeholder="Cantidad">
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control form-control-lg fs-6 rounded-0" name="stock_minimo" id="stock_minimo" placeholder="Stock minimo">
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control form-control-lg fs-6 rounded-0" name="precio" id="precio" placeholder="Precio">
                </div>
                <div>
                    <input type="file" id="imagen" name="imagen" class="form-control form-control-lg fs-6 rounded-0" onchange="vistaPreliminar(event)">
                </div>
                <div class="mb-3">
                  <img class="d-block w-100" src="" alt="" id="img-preview">
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="btnAgregaArticulo" type="submit" class="btn btn-primary rounded-0">Registrar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Actualiza Producto -->
<div class="modal fade" id="abremodalUpdateArticulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form id="frmArticulosU" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="text" hidden="" id="idArticulo" name="idArticulo">
            </div>
            <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Categoria</label>
                <select class="form-select form-select-lg fs-6 rounded-0" name="categoriaSelectU" id="categoriaSelectU">

                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Nombre</label>
                <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="nombreU" id="nombreU">
            </div>
            <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Descripcion</label>
                <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="descripcionU" id="descripcionU">
            </div>
            <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Precio</label>
                <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="precioU" id="precioU">
            </div>
            <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Stock_minimo</label>
                <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="stock_minimoU" id="stock_minimoU">
            </div>
            <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Cambiar imagen (opcional)</label>
                <input type="file" id="imagenU" name="imagenU" class="form-control form-control-lg fs-6 rounded-0" onchange="vistaPreliminarEditar(event)">
            </div>
            <div class="mb-3">
            <img class="d-block w-100" src="" alt="" id="img-preview-update">
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="btnActualizaArticulo" type="button" class="btn btn-primary rounded-0">Actualizar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Actualiza Stock -->
<div class="modal fade" id="abremodalAgregaStock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir stock</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form id="frmStockU">
            <div class="mb-3">
                <input type="text" hidden="" id="idArticulo" name="idArticulo">
            </div>
            <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Stock Actual</label>
                <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="cantidadU" id="cantidadU" readonly>
            </div>
            <div class="mb-3">
                <label for="" class="form-label text-secondary fs-6">Cantidad Adicional</label>
                <input type="number" class="form-control form-control-lg fs-6 rounded-0" name="cantidadA" id="cantidadA">
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="btnActualizaStock" type="button" class="btn btn-primary rounded-0">Agregar</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<script src="../js/articulos/articulos.js"></script>
<script src="../js/funciones.js"></script>


<?php
        }else{
            header("location:inicio.php");
        }
    }else{
        header("location:../index.php");
    }
?>