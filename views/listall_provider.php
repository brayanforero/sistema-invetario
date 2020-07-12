<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Provedores registrados</h3>
  <div class="row">
    <div v-show="!existsData" class="alert alert-danger col-12 text-center trans">
      <b>{{msgRes}}</b>
    </div>
    <div class="col-md-3" v-for="p in providers">
      <div class="card shadow-sm">
        <div class="card-body">
          <strong>Datos de personales</strong>
          <p><span>Nombre completo:</span> {{p.name}}</p>
          <p><span>Cedula:</span> {{p.doc}}</p>
          <hr>

          <strong>Contacto</strong>
          <p><span>Correo:</span> {{p.email}} <i class="fas fa-at"></i></p>
          <p><span>Telefono:</span> {{p.phone_number}} <i class="fas fa-phone"></i></p>
          <p><span>Dirección:</span> {{p.address}}</p>

        </div>
      </div>
    </div>
  </div>
</div>
<?php
require_once "./partials/scripts.php"
?>
<script src="/public/js/axios.js"></script>
<script src="/public/js/vue.js"></script>
<script>
  const app = new Vue({
    el: "#app",
    data: {
      providers: [],
      existsData: true,
      msgRes: ""
    },
    methods: {
      async getProvider() {

        const res = await axios({
          method: "GET",
          url: "/api/providers/get.php"
        })
        if (res.data.status >= 400) {
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.providers = res.data.data
      }
    },
    created() {
      this.getProvider()
    }
  })
</script>
</body>

</html>