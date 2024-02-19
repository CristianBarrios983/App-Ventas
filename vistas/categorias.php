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
    <title>Categorias</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    <div class="container">
        <h2>Categoria</h2>
        <div class="row">
             <div class="col-sm-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Registrar categoria</h5>
                    <form id="frmCategorias">
                        <label for="">Categoria</label>
                        <input type="text" class="form-control input-sm" name="categoria" id="categoria">
                        <p></p>
                        <span class="btn btn-primary" id="btnAgregaCategoria">Agregar</span>
                    </form>
                  </div>
                </div>
              </div>
            <div class="col-sm-6">
                <div id="tablaCategoriaLoad"></div>
            </div>
        </div>
    </div>

    

<!-- Modal -->
<div class="modal fade" id="actualizaCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualiza categorias</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmCategoriaU">
            <input type="text" hidden="" id="idcategoria" name="idcategoria">
            <label for="">Categoria</label>
            <input type="text" id="categoriaU" name="categoriaU" class="form-control input-sm">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal" id="btnActualizaCategoria">Guardar</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<!-- script para agregar categoria nueva -->
<script type="text/javascript">
    $(document).ready(function(){

        $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
        $('#btnAgregaCategoria').click(function(){

            vacios=validarFormVacio('frmCategorias');

            if(vacios > 0){
                alertify.alert("Los campos no deben estar vacios");
                return false;
            }
            
        datos=$('#frmCategorias').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/categorias/agregaCategoria.php",
            success:function(r){
                if(r==1){
                    //Esta linea permite limpiar los registros
                    $('#frmCategorias')[0].reset();
                    $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
                    alertify.success("Categoria agregada exitosamente");
                }else{
                    alertify.error("No se pudo agregar la categoria :(");
                }
            }
        });
    });
    })
</script>

<!-- script para traer datos de categorias -->
<script>
    function agregaDato(idCategoria,categoria){
        $('#idcategoria').val(idCategoria);
        $('#categoriaU').val(categoria);
    }

    function eliminaCategoria(idcategoria){
        alertify.confirm('¿Desea eliminar esta categoria?', function(){ 
            // alertify.success('Ok') 
            $.ajax({
                type:"POST",
                data:"idcategoria=" + idcategoria,
                url:"../procesos/categorias/eliminarCategoria.php",
                success:function(r){
                    if(r==1){
                        $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
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

<!-- script para actualizar datos categoria -->
<script>
    $(document).ready(function(){
        $('#btnActualizaCategoria').click(function(){
            datos=$('#frmCategoriaU').serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../procesos/categorias/actualizaCategoria.php",
                success:function(r){
                    if(r==1){
                        $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
                        alertify.success("Actualizado con exito");
                    }else{
                        alertify.error("No se pudo actualizar")
                    }
                }
            });
        });
    })
</script>

<?php
    }else{
        header("location:../index.php");
    }
?>