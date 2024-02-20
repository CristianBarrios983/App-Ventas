<?php
    session_start();
    if(isset($_SESSION['usuario'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articulos</title>
    <?php require_once "menu.php"; ?>
    <?php require_once "../clases/Conexion.php"; 
        $c= new conectar();
        $conexion=$c->conexion();

        $sql="SELECT id_categoria,nombreCategoria from categorias";
        $result=mysqli_query($conexion,$sql);
    ?>
</head>
<body>
    <div class="container">
        <h2>Articulos</h2>
        <div class="row">
             <div class="col-sm-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Registrar articulo</h5>
                    <form id="frmArticulos" enctype="multipart/form-data">
                        <label for="">Categoria</label>
                        <select class="form-control input-sm" name="categoriaSelect" id="categoriaSelect">
                            <option value="A">Seleccione categoria</option>
                        <?php while($mostrar=mysqli_fetch_row($result)): ?>
                            <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
                        <?php endwhile; ?>
                        </select>
                        <label for="">Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombre" id="nombre">
                        <label for="">Descripcion</label>
                        <input type="text" class="form-control input-sm" name="descripcion" id="descripcion">
                        <label for="">Cantidad</label>
                        <input type="text" class="form-control input-sm" name="cantidad" id="cantidad">
                        <label for="">Precio</label>
                        <input type="text" class="form-control input-sm" name="precio" id="precio">
                        <label for="">Imagen</label>
                        <input type="file" id="imagen" name="imagen">
                        <p></p>
                        <span id="btnAgregaArticulo" class="btn btn-primary">Agregar</span>
                    </form>
                  </div>
                </div>
              </div>
            <div class="col-sm-4">
                <div id="tablaArticulosLoad"></div>
            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="abremodalUpdateArticulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualiza articulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmArticulosU" enctype="multipart/form-data">
            <input type="text" hidden="" id="idArticulo" name="idArticulo">
            <label for="">Categoria</label>
            <select class="form-control input-sm" name="categoriaSelectU" id="categoriaSelectU">
                <option value="A">Seleccione categoria</option>
                <?php 
                    $sql="SELECT id_categoria,nombreCategoria from categorias";
                    $result=mysqli_query($conexion,$sql);
                 ?>
                <?php while($mostrar=mysqli_fetch_row($result)): ?>
                    <option value="<?php echo $mostrar[0] ?>"><?php echo $mostrar[1] ?></option>
                <?php endwhile; ?>
            </select>
            <label for="">Nombre</label>
            <input type="text" class="form-control input-sm" name="nombreU" id="nombreU">
            <label for="">Descripcion</label>
            <input type="text" class="form-control input-sm" name="descripcionU" id="descripcionU">
<<<<<<< HEAD
            <label for="">Precio</label>
            <input type="text" class="form-control input-sm" name="precioU" id="precioU">
            <label for="">Cambiar imagen</label>
            <input type="file" id="imagenU" name="imagenU">
=======
            <label for="">Cantidad</label>
            <input type="text" class="form-control input-sm" name="cantidadU" id="cantidadU">
            <label for="">Precio</label>
            <input type="text" class="form-control input-sm" name="precioU" id="precioU">
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal" id="btnActualizaArticulo">Actualizar</button>
      </div>
    </div>
  </div>
</div>
<<<<<<< HEAD


<!-- Modal Actualiza Stock-->
<div class="modal fade" id="abremodalAgregaStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmStockU">
            <input type="text" hidden="" id="idArticulo" name="idArticulo">
            <label for="">Cantidad Actual</label>
            <input type="text" class="form-control input-sm" name="cantidadU" id="cantidadU" readonly>
            <label for="">Cantidad Adicional</label>
            <input type="text" class="form-control input-sm" name="cantidadA" id="cantidadA">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal" id="btnActualizaStock">Agregar</button>
      </div>
    </div>
  </div>
</div>
=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
</body>
</html>

<script>
    $(document).ready(function(){
        $('#btnActualizaArticulo').click(function(){
<<<<<<< HEAD
            // datos=$('#frmArticulosU').serialize();
            var formDataU= new FormData(document.getElementById("frmArticulosU"));
            console.log(formDataU);
            $.ajax({
                type:"POST",
                // data:datos,
                data: formDataU,
                cache: false,
                contentType: false,
                processData: false,
                url:"../procesos/articulos/actualizaArticulos.php",
                success:function(r){
                    console.log(r);
=======
            datos=$('#frmArticulosU').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/articulos/actualizaArticulos.php",
                success:function(r){
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
                    if(r==1){
                        $("#tablaArticulosLoad").load("articulos/tablaArticulos.php");
                        alertify.success("Se actualizo con exito");
                    }else{
                        alertify.error("No se pudo actualizar");
                    }
                }
            });
        });
    });
</script>

<<<<<<< HEAD
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
                        $("#tablaArticulosLoad").load("articulos/tablaArticulos.php");
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
        // console.log("id:"+idarticulo);
=======
<script>
    function agregaDatosArticulo(idarticulo){
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
        $.ajax({
            type:"POST",
            data:"idart=" + idarticulo,
            url:"../procesos/articulos/obtieneDatosArticulo.php",
            success:function(r){
                dato=jQuery.parseJSON(r);
<<<<<<< HEAD
                // console.log(dato);
                $('input[name="idArticulo"]').val(dato['id_producto']);
                $('#categoriaSelectU').val(dato['id_categoria']);
                $('#nombreU').val(dato['nombre']);
                $('#descripcionU').val(dato['descripcion']);
                $('input[name="cantidadU"]').val(dato['cantidad']);
=======
                $('#idArticulo').val(dato['id_producto']);
                $('#categoriaSelectU').val(dato['id_categoria']);
                $('#nombreU').val(dato['nombre']);
                $('#descripcionU').val(dato['descripcion']);
                $('#cantidadU').val(dato['cantidad']);
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270
                $('#precioU').val(dato['precio']);
            }
        });
    }
<<<<<<< HEAD
    
=======
>>>>>>> b0679fb5fd7cf5604f6c56c7d7b1621b2bc75270

    function eliminaArticulo(idArticulo){
        alertify.confirm('¿Desea eliminar esta articulo?', function(){ 
            // alertify.success('Ok') 
            $.ajax({
                type:"POST",
                data:"idarticulo=" + idArticulo,
                url:"../procesos/articulos/eliminarArticulo.php",
                success:function(r){
                    if(r==1){
                        $("#tablaArticulosLoad").load("articulos/tablaArticulos.php");
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
    $(document).ready(function(){
        $("#tablaArticulosLoad").load("articulos/tablaArticulos.php");

        $('#btnAgregaArticulo').click(function(){

            vacios=validarFormVacio('frmArticulos');

            if(vacios > 0){
                alertify.alert("Los campos no deben estar vacios");
                return false;
            }

            var formData= new FormData(document.getElementById("frmArticulos"));

            $.ajax({
                url: "../procesos/articulos/insertaArticulo.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,

                success:function(r){

                    if(r == 1){
                        $('#frmArticulos')[0].reset();
                        $("#tablaArticulosLoad").load("articulos/tablaArticulos.php");
                        alertify.success("Agregado con exito");
                    }else{
                        alertify.error("Fallo al subir el archivo");
                    }
                }
            });
           
        });
    });
</script>

<?php
    }else{
        header("location:../index.php");
    }
?>