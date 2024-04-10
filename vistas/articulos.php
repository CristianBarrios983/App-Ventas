<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        if($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Supervisor"){
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
            <?php if($_SESSION['rol'] == "Administrador"): ?>
            <div class="col-lg-8">
                <button type="button" class="btn btn-primary rounded-0 w-auto d-inline-block" data-bs-toggle="modal" data-bs-target="#abremodalRegistroArticulo">Registrar producto</button>
            </div>
            <?php endif; ?>
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
                    <input type="number" class="form-control form-control-lg fs-6 rounded-0" name="precio" id="precio" placeholder="Precio">
                </div>
                <div>
                    <input type="file" id="imagen" name="imagen" class="form-control form-control-lg fs-6 rounded-0">
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="btnAgregaArticulo" type="button" class="btn btn-primary rounded-0" data-bs-dismiss="modal">Registrar</button>
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
                    <option value="">Seleccione categoria</option>
                    <?php 
                        $sql="SELECT id_categoria,nombreCategoria from categorias";
                        $result=mysqli_query($conexion,$sql);
                    ?>
                    <?php while($mostrar=mysqli_fetch_row($result)): ?>
                        <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
                    <?php endwhile; ?>
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
                <label for="" class="form-label text-secondary fs-6">Cambiar imagen</label>
                <input type="file" id="imagenU" name="imagenU" class="form-control form-control-lg fs-6 rounded-0">
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="btnActualizaArticulo" type="button" class="btn btn-primary rounded-0" data-bs-dismiss="modal">Actualizar</button>
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
                <input type="text" class="form-control form-control-lg fs-6 rounded-0" name="cantidadA" id="cantidadA">
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cerrar</button>
        <button id="btnActualizaStock" type="button" class="btn btn-primary rounded-0" data-bs-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){
        $('#btnActualizaArticulo').click(function(){

            var formDataU= new FormData(document.getElementById("frmArticulosU"));

            $.ajax({
                type:"POST",
                data: formDataU,
                cache: false,
                contentType: false,
                processData: false,
                url:"../procesos/articulos/actualizaArticulos.php",
                success:function(r){
                    if(r==1){
                        $("#tablaArticulosLoad").load("articulos/tablaArticulos.php", function() {
                            // Inicializar DataTables después de cargar la tabla
                            let dataTable = new DataTable("#tablaProductos", {
                                perPage: 3,
                                perPageSelect: [3,5,10],
                                // Para cambiar idioma
                                labels: {
                                            placeholder: "Buscar...",
                                            perPage: "{select} Registros por pagina",
                                            noRows: "Registro no encontrado",
                                            info: "Mostrando registros del {start} al {end} de {rows} registros"
                                        }
                            });
                        });
                        alertify.success("Se actualizo con exito");
                    }else{
                        alertify.error("No se pudo actualizar");
                    }
                }
            });
        });
    });
</script>

<!-- Actualiza Stock -->
<script>
    $(document).ready(function(){
        $('#btnActualizaStock').click(function(){
            datos=$('#frmStockU').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/articulos/agregaStock.php",
                success:function(r){
                    if(r==1){
                        $('#frmStockU')[0].reset();
                        $("#tablaArticulosLoad").load("articulos/tablaArticulos.php", function() {
                            // Inicializar DataTables después de cargar la tabla
                            let dataTable = new DataTable("#tablaProductos", {
                                perPage: 3,
                                perPageSelect: [3,5,10],
                                // Para cambiar idioma
                                labels: {
                                            placeholder: "Buscar...",
                                            perPage: "{select} Registros por pagina",
                                            noRows: "Registro no encontrado",
                                            info: "Mostrando registros del {start} al {end} de {rows} registros"
                                        }
                            });
                        });
                        alertify.success("Se agrego al stock actual con exito");
                    }else{
                        alertify.error("No se pudo agregar al stock");
                    }
                }
            });
        });
    });
</script>

<script>
    function agregaDatosArticulo(idarticulo){
        $.ajax({
            type:"POST",
            data:"idart=" + idarticulo,
            url:"../procesos/articulos/obtieneDatosArticulo.php",
            success:function(r){
                dato=jQuery.parseJSON(r);

                $('input[name="idArticulo"]').val(dato['id_producto']);
                $('#categoriaSelectU').val(dato['id_categoria']);
                $('#nombreU').val(dato['nombre']);
                $('#descripcionU').val(dato['descripcion']);
                $('input[name="cantidadU"]').val(dato['cantidad']);
                $('#precioU').val(dato['precio']);
            }
        });
    }
    

    function eliminaArticulo(idArticulo){
        alertify.confirm('¿Desea eliminar esta articulo?', function(){ 
            // alertify.success('Ok') 
            $.ajax({
                type:"POST",
                data:"idarticulo=" + idArticulo,
                url:"../procesos/articulos/eliminarArticulo.php",
                success:function(r){
                    if(r==1){
                        $("#tablaArticulosLoad").load("articulos/tablaArticulos.php", function() {
                            // Inicializar DataTables después de cargar la tabla
                            let dataTable = new DataTable("#tablaProductos", {
                                perPage: 3,
                                perPageSelect: [3,5,10],
                                // Para cambiar idioma
                                labels: {
                                            placeholder: "Buscar...",
                                            perPage: "{select} Registros por pagina",
                                            noRows: "Registro no encontrado",
                                            info: "Mostrando registros del {start} al {end} de {rows} registros"
                                        }
                            });
                        });
                        alertify.success("Eliminado con exito");
                    }else{
                        alertify.error("No se pudo eliminar");
                    }
                }
            });
        }, function(){ 
            alertify.error('Cancelar')});
    }
</script>

<!-- Script para validar campos vacios e ingresar articulo -->
<script type="text/javascript">
    // Cargando datatables apenas inicia la pagina
    document.addEventListener("DOMContentLoaded", function() {
        $('#tablaArticulosLoad').load("articulos/tablaArticulos.php", function() {
            // Inicializar DataTables después de cargar la tabla
            let dataTable = new DataTable("#tablaProductos", {
                perPage: 3,
                perPageSelect: [3,5,10],
                // Para cambiar idioma
                labels: {
                            placeholder: "Buscar...",
                            perPage: "{select} Registros por pagina",
                            noRows: "Registro no encontrado",
                            info: "Mostrando registros del {start} al {end} de {rows} registros"
                        }
            });
        });
    });

    $(document).ready(function(){

        $('#btnAgregaArticulo').click(function(){

            vacios=validarFormVacio('frmArticulos');

            if(vacios > 0){
                alertify.alert("Los campos no deben estar vacios");
                return false;
            }

            var formData= new FormData(document.getElementById("frmArticulos"));

            $.ajax({
                url: "../procesos/articulos/insertaArticulo.php",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,

                success:function(r){
                    console.log(r);
                    if(r == 1){
                        $('#frmArticulos')[0].reset();
                        $("#tablaArticulosLoad").load("articulos/tablaArticulos.php", function() {
                            // Inicializar DataTables después de cargar la tabla
                            let dataTable = new DataTable("#tablaProductos", {
                                perPage: 3,
                                perPageSelect: [3,5,10],
                                // Para cambiar idioma
                                labels: {
                                            placeholder: "Buscar...",
                                            perPage: "{select} Registros por pagina",
                                            noRows: "Registro no encontrado",
                                            info: "Mostrando registros del {start} al {end} de {rows} registros"
                                        }
                            });
                        });
                        alertify.success("Agregado con exito");
                    }else{
                        alertify.error("Fallo al agregar el producto");
                    }
                }
            });
           
        });
    });
</script>

<?php
        }else{
            header("location:inicio.php");
        }
    }else{
        header("location:../index.php");
    }
?>