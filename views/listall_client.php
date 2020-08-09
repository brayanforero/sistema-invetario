<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Clientes registrados</h3>
  <div class="row">
    <div v-show="!existsData" class="alert alert-danger col-12 text-center trans">
      <b>{{msgRes}}</b>
    </div>
    <div class="col-12 col-md-4" v-for="(c,i) in clients">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-light">
          <span class="h3 m-0">
            Cliente n°{{c.id}}
          </span>
        </div>
        <div class="card-body">
          <strong>Datos de personales</strong>
          <p><span>Nombre completo:</span> {{c.name}}</p>
          <p><span>Cedula:</span> {{c.doc}}</p>
          <hr>

          <strong>Contacto</strong>
          <p><span><i class="fas fa-envelope"></i> </span> {{c.email}}</p>
          <p><span><i class="fas fa-phone"></i> </span> {{c.phone_number}}</p>
          <p><span><i class="fas fa-building"></i></span> {{c.address}}</p>
          <button @click="deleteClient(c.id, i)" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
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
      clients: [],
      existsData: true,
      msgRes: ""
    },
    methods: {
      async getClient() {

        const res = await axios({
          method: "GET",
          url: "/api/client/get.php"
        })
        if (res.data.status >= 400) {
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.clients = res.data.data
      },
      deleteClient(id, i) {
        bootbox.confirm(`Esta seguro de eliminar a ${this.clients[i].name}`, async result => {
          if (result) {
            const res = await axios({
              method: "GET",
              url: `/api/client/delete.php?id=${id}`
            })
            if (res.data.status == 200) {
              bootbox.alert("Cliente eliminado con exito")
              this.clients.splice(i, 1);
              return
            }
            bootbox.alert(`${res.data.msg}`)
          }
        })
      }
    },
    created() {
      this.getClient()
    }
  })
</script>
</body>

</html>