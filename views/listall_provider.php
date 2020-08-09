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
    <div class="col-12 col-md-4" v-for="(p,i) in providers">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-light">
          <p class="h3 m-0">Provedor n°{{p.id}}</p>
        </div>
        <div class="card-body">
          <strong>Datos de personales</strong>
          <p><span>Nombre completo:</span> {{p.name}}</p>
          <p><span>Cedula:</span> {{p.doc}}</p>
          <hr>

          <strong>Contacto</strong>
          <p><span><i class="fas fa-envelope"></i></span> {{p.email}}</p>
          <p><span><i class="fas fa-phone"></i></span> {{p.phone_number}}</p>
          <p><span><i class="fas fa-building"></i></span> {{p.address}}</p>
          <button class="btn btn-danger" @click="deleteProvider(p.id, i)"><i class="fas fa-trash"></i></button>
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
      },
      deleteProvider(id, i) {

        bootbox.confirm(`Esta seguro que desesa eliminar a ${this.providers[i].name}`, async result => {
          const res = await axios({
            method: "GET",
            url: `/api/providers/delete.php?id=${id}`
          })

          if (res.data.status == 200) {
            bootbox.alert("Provedor elinimando con exito")
            this.providers.splice(i, 1)
            return
          }
          bootbox.alert(`${res.data.msg}`)
        })

      }
    },
    created() {
      this.getProvider()
    }
  })
</script>
</body>

</html>