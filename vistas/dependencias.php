<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" type="text/css" href="../librerias/alertifyjs/css/alertify.css">
<link rel="stylesheet" type="text/css" href="../librerias/alertifyjs/css/themes/default.css">


<link rel="stylesheet" type="text/css" href="../librerias/bootstrap-5.3.3-dist/css/bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="../librerias/bootstrap-icons-1.11.3/font/bootstrap-icons.css">


<script type="text/javascript" src="../librerias/jquery-3.6.1.min.js"></script>
<script src="../librerias/alertifyjs/alertify.js"></script>
<script src="../librerias/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
<script src="../librerias/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/funciones.js"></script>

<!-- DataTables CDN -->
<link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>

<script>
  let dataTable = new DataTable("#tablaUsuarios", {
    perPage: 3,
    perPageSelect: [3,5,10]
  });
</script>