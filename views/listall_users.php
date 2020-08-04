<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Usuarios registradas</h3>
  <div class="row">
    <div v-show="!existsData" class="alert alert-danger col-12 text-center trans">
      <b>{{msgRes}}</b>
    </div>
    <div class="col-12 col-md-6 mb-3" v-for="(u,i) in users">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-light">
          <p class="h4 m-0 text-center">Categoria</p>
        </div>
        <div class="card-body">
          <p>{{u.fname}}</p>
          <p>{{u.doc}}</p>
          <p>{{u.name}}</p>
          <p>Registrado: {{u.created}}</p>
          <!-- <p>Ultima Modificacion: {{u.last_date_update}}</p> -->
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
      }
    },
    created() {
      this.getUsers()
    }
  })
</script>
</body>

</html>