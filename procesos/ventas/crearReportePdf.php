<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
// require_once '../../librerias/dompdf/autoload.inc.php';
require_once '../../librerias/dompdf-new/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$id = $_GET['idventa'];

// Introducimos HTML de prueba
function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

$html = file_get_contents("http://localhost/Proyectos/AppVentas/vistas/ventas/reporteVentaPdf.php?idventa=" . $id);

// Configuramos dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

// Instanciamos un objeto de la clase DOMPDF con las opciones configuradas
$pdf = new DOMPDF($options);

// Cargamos el contenido HTML.
$pdf->loadHtml($html);

// Establecemos el tamaño y orientación del papel.
$pdf->setPaper("letter", "portrait");

// Renderizamos el documento PDF.
$pdf->render();

// Enviamos el fichero PDF al navegador.
$pdf->stream('reporteVenta.pdf', array("Attachment" => false));

?>