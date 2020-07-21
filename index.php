<?php require_once './utilities/sessions.php';
verifySession(); ?>
<!DOCTYPE html>

<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <!-- CARGANDO VUE JS -->
  <script src="/public/js/vue.js"></script>
  <title>Sistema de Inventario - Francisco</title>
  <!-- CARGA DE LOS ESTILOS PARA EL DISEÑO -->
  <link rel="stylesheet" href="/public/css/litera.css">
  <link rel="stylesheet" href="/public/css/main.css">
  <!-- CARGANDO EL ARCHIVOS DE ICONOS -->
</head>

<body>
  <?php include_once './views/partials/nav.php' ?>
  <?php include './views/partials/scripts.php' ?>
</body>

</html>