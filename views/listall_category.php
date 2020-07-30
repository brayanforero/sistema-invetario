<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Categorias registradas</h3>
  <div class="row">
    <div v-show="!existsData" class="alert alert-danger col-12 text-center trans">
      <b>{{msgRes}}</b>
    </div>
    <div class="col-12 col-md-6 mb-3" v-for="c in categories">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-light">
          <p class="h4 m-0 text-center">Categoria</p>
        </div>
        <div class="card-body">
          <p>{{c.name}}</p>
          <p>Registrada: {{c.date_created}}</p>
          <p>Ultima Modificacion: {{c.last_date_update}}</p>
          <hr>
          <strong>Usuario</strong>
          <p>{{c.user}}</p>
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
      categories: [],
      existsData: true,
      msgRes: ""
    },
    methods: {
      async getCategories() {

        const res = await axios({
          method: "GET",
          url: "/api/categories/get.php"
        })
        if (res.data.status >= 400) {
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.categories = res.data.data
      }
    },
    created() {
      this.getCategories()
    }
  })
</script>
</body>

</html>