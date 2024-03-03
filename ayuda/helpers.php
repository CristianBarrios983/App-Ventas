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
