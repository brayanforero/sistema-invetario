<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Usuarios registrados</h3>
  <div class="row">
    <div v-show="!existsData" class="alert alert-danger col-12 text-center trans">
      <b>{{msgRes}}</b>
    </div>
    <div class="col-12 col-md-6 mb-3" v-for="(u,i) in users">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-light">
          <p class="h4 m-0 text-center">Usuario</p>
        </div>
        <div class="card-body">
          <p>Persona: <strong>{{u.fname}}</strong></p>
          <p>Cedula: <strong>{{u.doc}}</strong></p>
          <p>Nombre de usuario: <strong>{{u.name}}</strong></p>
          <p>Estatus:
            <strong :class="{'text-success': u.status == 1,'text-danger': u.status != 1}">{{u.status == 1 ? 'activo' : 'dasabilitado'}}</strong>
          </p>
          <p>Registrado: {{u.created}}</p>
          <button @click=" changeStatusUser(u.status, u.id, i)" class="btn show-alert" :class="{'btn-warning': u.status == 1, 'btn-info': u.status != 1}">{{u.status == 1 ? 'Deshabilitar' : 'Habilitar'}}</button>
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
      users: [],
      existsData: true,
      msgRes: ""
    },
    methods: {
      async getUsers() {
        const res = await axios({
          method: "GET",
          url: "/api/user/get.php"
        })
        if (res.data.status >= 400) {
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.users = res.data.data
      },
      changeStatusUser(status, id, i) {
        bootbox.confirm(`Esta seguro de cambiar el estado de <strong>${this.users[i].name}</strong>`, result => {
          if (result) {
            if (status == 1) {
              $.ajax({
                type: "POST",
                url: "/api/user/change.php",
                data: {
                  id
                },
                dataType: "json",
                success: (res) => {
                  bootbox.alert("Se deshabilitado el usuario correctamente")
                  app.users[i].status = 0;
                },
                falied: (err) => {
                  console.log(err);
                }
              })
              return
            }
            $.ajax({
              type: "POST",
              url: "/api/user/change.php",
              data: {
                id
              },
              dataType: "json",
              success: (res) => {
                bootbox.alert("Se habilitado el usuario correctamente")
                app.users[i].status = 1;
              },
              falied: (err) => {
                console.log(err);
              }
            })
          }
        })

      }
    },
    created() {
      this.getUsers()
    }
  })
</script>
</body>

</html>