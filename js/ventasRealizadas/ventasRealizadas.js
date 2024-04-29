// Cargar datatables en ventas hechas
document.addEventListener("DOMContentLoaded", function() {
    $('#tablaVentasRealizadas', function() {
        // Inicializar DataTables después de cargar la tabla
        let dataTable = new DataTable("#tablaVentasRealizadas", {
            perPageSelect: [10,20,30,40,50,75,100],
            // Para cambiar idioma
            labels: {
                        placeholder: "Buscar...",
                        perPage: "{select} Registros por pagina",
                        noRows: "Venta no encontrada",
                        info: "Mostrando registros del {start} al {end} de {rows} registros"
                    }
        });
    });
});

// Funcion para ver los detalles de la venta
function verDetalles(idVenta){
    $.ajax({
        type:"POST",
        data:"idVenta=" + idVenta,
        url:"../procesos/ventas/verDetalles.php",
        success:function(r){
             let detallesVenta = jQuery.parseJSON(r);
            console.log(detallesVenta)
             // Limpiar la tabla de detalles antes de agregar nuevos datos
             $('#abremodalDetalles tbody').empty();

             // Iterar sobre los detalles y agregar filas a la tabla
             let i = 0;
             let total = 0;
             $.each(detallesVenta, function(index, detalle) {
                i++;
                total = detalle.total;
                  var fila = '<tr>' +
                      '<td>' + detalle.nombreProducto + '</td>' +
                      '<td>' + detalle.cantidad + '</td>' +
                      '<td>' + '$' + detalle.precio + '</td>' +
                      '</tr>';
                  $('#abremodalDetalles tbody').append(fila);
                  console.log(detalle.nombreProducto, detalle.cantidad, detalle.precio);
             });

             console.log(i,total);
             $('#abremodalDetalles #cantidadProductos').text(`${i}`);
             $('#abremodalDetalles #totalVenta').text(`$${total}`);

            }
    });
}