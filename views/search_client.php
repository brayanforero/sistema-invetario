<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Buscar cliente</h3>
  <div class="row">
    <div class="col-md-3" v-for="c in clients">
      <div class="card shadow-sm">
        <div class="card-body">
          <!-- <strong>Datos de personales</strong>
          <p><span>Nombre completo:</span> {{c.name}}</p>
          <p><span>Cedula:</span> {{c.doc}}</p>
          <hr>

          <strong>Contacto</strong>
          <p><span>Correo:</span> {{c.email}} <i class="fas fa-at"></i></p>
          <p><span>Telefono:</span> {{c.phone_number}} <i class="fas fa-phone"></i></p>
          <p><span>Dirección:</span> {{c.address}}</p> -->
        </div>
      </div>
    </div>
  </div>
</div>
<?php
require_once "./partials/scripts.php"
?>

<script src="/public/js/vue.js"></script>
<script>
  const app = new Vue({
    el: "#app",
    data: {
      title: "Vue"
    }
  })
</script>
</body>

</html>