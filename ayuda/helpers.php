<!-- Consulta para mostrar detalles de venta sin repetir los productos, mostrando un solo producto y la cantidad, asi como tambien la suma de los precios de cada uno: -->

SELECT ve.id_venta,
                    ve.fechaCompra,
                    ve.id_cliente,
                    art.nombre,
                    sum(art.precio),
                    art.descripcion,
                    count(art.nombre) as cantidad
                    from ventas as ve
                    inner join articulos as art
                    on ve.id_producto=art.id_producto and ve.id_venta='$idventa' group by cantidad having count(art.nombre)

                    
<!-- Script para crear un evento de un click -->
<script type="text/javascript">
    $('#').click(function(){
        datos=$('#').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../procesos/",
            success:function(r){

            }
        });
    });

    // Funcion para validar formulario con espacios vacios
    function validarFormVacio(formulario){
        datos=$('#' + formulario).serialize();
        d=datos.split('&');
        vacios=0;
        for(i=0;i< d.length;i++){
            controles=d[i].split("=");
            if(controles[1]=="A" || controles[1]==""){
                vacios++;
            }
        }
        return vacios;
    }

</script>


<!-- Script para enviar registros con imagenes -->
<script type="text/javascript">
    $('#').click(function(){
        var formData= new FormData(document.getElementById("frm"));

            $.ajax({
                url: "../procesos/articulos/insertaArchivo.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,

                success:function(data){

                    if(data == 1){
                        $('#frm')[0].reset();
                        $('tablaArticulosLoad').load('articulos/tablaArticulos.php');
                        alertify.success("Agregado con exito");
                    }else{
                        alertify.error("Fallo al subir el archivo");
                    }
                }
            });
    });
</script>

<!-- Metodo para obtener id de imagen y obtener ruta -->
<?php
    public function obtenerIdImg($idproducto){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_imagen from productos where id_producto='$idProducto'";
            $result=mysqli_query($conexion,$sql);

            return mysqli_fetch_row($result)[0];
        }
        public function obtenerRutaImagen($idImg){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT ruta from imagenes where id_imagen='$idImg'";
            $result=mysqli_query($conexion,$sql);

            return mysqli_fetch_row($result)[0];
        }
        public function crearFolio(){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_venta from ventas group by id_venta desc";

            $result=mysqli_query($conexion,$sql);
            $id=mysqli_fetch_row($result)[0];

            if($id=="" or $id==null or $id==0){
                return 1;
            }else{
                return $id + 1;
            }
        }

        public function nombreCliente($idCliente){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT apellido,nombre from clientes where id_cliente='$idCliente'";
            $result=mysqli_query($conexion,$sql);

            $mostrar=mysqli_fetch_row($result);

            return $mostrar[0]." ".$mostrar[1];
        }

        public function obtenerTotal($idventa){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT precio from ventas where id_venta='$idventa'";
            $result=mysqli_query($conexion,$sql);

            $total=0;

            while($mostrar=mysqli_fetch_row($result)){
                $total=$total + $mostrar[0];
            }

            return $total;
        }

?>

<!-- Codigo ajax para imprimir detalles en modal -->

function verDetalles(idVenta) {
    // Hacer una solicitud AJAX para obtener los detalles de la venta con el idVenta proporcionado
    $.ajax({
        type: "POST",
        data: "idVenta=" + idVenta,
        url: "../procesos/ventas/obtieneDetallesVenta.php",  // Asegúrate de tener un script que maneje esta solicitud y devuelva los detalles de la venta
        success: function(response) {
            // Parsear la respuesta JSON
            var detallesVenta = jQuery.parseJSON(response);

            // Limpiar la tabla de detalles antes de agregar nuevos datos
            $('#abremodalDetalles tbody').empty();

            // Iterar sobre los detalles y agregar filas a la tabla
            $.each(detallesVenta, function(index, detalle) {
                var fila = '<tr>' +
                    '<td>' + detalle.idProducto + '</td>' +
                    '<td>' + detalle.nombreProducto + '</td>' +
                    '<td>' + detalle.cantidad + '</td>' +
                    '<td>' + detalle.precio + '</td>' +
                    '</tr>';
                $('#abremodalDetalles tbody').append(fila);
            });

            // Mostrar el modal de detalles
            $('#abremodalDetalles').modal('show');
        }
    });
}


<!-- Navbar Bootstrap 5.3.3 -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<!-- Card Bootstrap 5.3.3 -->
<div class="card text-center">
  <div class="card-header">
    Featured
  </div>
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
  <div class="card-footer text-body-secondary">
    2 days ago
  </div>
</div>


<!-- Table Bootstrap 5.3.3 -->
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>


<!-- Modal Bootstrap 5.3.3 -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Formulario Bootstrap 5.3.3 -->
<form>
                <div class="mb-3 d-flex gap-2">
                  <div class="">
                    <input type="text" class="form-control form-control-lg fs-6 rounded-0" id="nombre" name="nombre" placeholder="Nombre" required>
                  </div>
                  <div class="">
                    <input type="text" class="form-control form-control-lg fs-6 rounded-0" id="asunto" name="asunto" placeholder="Asunto" required>
                  </div>
                </div>
                <div class="mb-3">
                  <input type="email" class="form-control form-control-lg fs-6 rounded-0" id="email" name="email" placeholder="Correo electrónico" required>
                </div>
                <div class="mb-3">
                  <textarea name="mensaje" id="mensaje" cols="30" rows="10" class="form-control form-control-lg fs-6 rounded-0" placeholder="Deje su mensaje aquí..." required></textarea>
                </div>
                <div class="mb-3" data-aos="fade-up">
                  <button type="submit" class="btn btn-primary fs-5 fw-bold rounded-0 d-block w-100">Enviar mensaje <i class="fa-regular fa-paper-plane"></i></button>
                </div>
</form>



<!-- Consulta para agregar columnas a una table -->
ALTER TABLE usuarios
ADD COLUMN rol INT AFTER id_usuario,
ADD CONSTRAINT fk_rol FOREIGN KEY (rol) REFERENCES roles(id_rol)