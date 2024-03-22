<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once '../../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$id = $_GET['idventa'];

$html = file_get_contents("http://localhost/AppVentas/vistas/ventas/reporteVentaPdf.php?idventa=" . $id);

// Instanciamos un objeto de la clase DOMPDF con las opciones configuradas
$pdf = new Dompdf();

// Configuramos dompdf
$options = $pdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$pdf->setOptions($options);

// Cargamos el contenido HTML.
$pdf->loadHtml($html);

// Establecemos el tamaño y orientación del papel.
$pdf->setPaper("letter");

// Renderizamos el documento PDF.
$pdf->render();

// Enviamos el fichero PDF al navegador.
$pdf->stream('reporteVenta.pdf', array("Attachment" => false));

?>