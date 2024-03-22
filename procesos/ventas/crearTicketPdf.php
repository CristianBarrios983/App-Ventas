<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once '../../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$id=$_GET['idventa'];

 $html=file_get_contents("http://localhost/AppVentas/vistas/ventas/ticketVentaPdf.php?idventa=".$id);

// Instanciamos un objeto de la clase DOMPDF.
$pdf = new DOMPDF();
 
// Definimos el tamaño y orientación del papel que queremos.
//$pdf->set_paper("letter", "portrait");
$pdf->set_paper(array(0,0,104,250));
 
// Cargamos el contenido HTML.
$pdf->load_html(utf8_decode($html));
 
// Renderizamos el documento PDF.
$pdf->render();
 
// Enviamos el fichero PDF al navegador.
$pdf->stream('TicketVenta.pdf', array("Attachment" => false));
//Para descargar en vez de abrir en el navegador es true