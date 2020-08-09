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
      <div class="card rounded shadow-sm">
        <div :class="{'bg-info': c.id %2 != 0, 'bg-primary': c.id %2 == 0}" class="card-body text-center text-light">
          <span class="h6 m-0 text-center">{{c.name}}</span>
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