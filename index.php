<?php require_once './utilities/sessions.php';verifySession();include_once './views/partials/header.php';?>

  <div id="app" class="text-right p-3 bg-primary">
    <a class="text-white" href="/logout.php">Cerrar Sesion</a>
  </div>

  <script src="/public/js/jquery.js"></script>
  <script src="/public/js/app.js"></script>
<?php include_once './views/partials/footer.php';?>

