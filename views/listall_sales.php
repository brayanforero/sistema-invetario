<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Ventas registradas</h3>
  <div class="row">
    <div v-show="!existsData" class="alert alert-danger col-12 text-center trans">
      <b>{{msgRes}}</b>
    </div>
    <div class="col-12 col-md-6 mb-3" v-for="(s, i) in sales">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-light">
          <p class="h4 m-0 text-center">Venta n° {{s.id}}</p>
          <button @click="deleteSale(s.id, i)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
        </div>
        <div class="card-body">
          <p>{{s.client}}</p>
          <p>{{s.product}}</p>
          <p>{{s.count}}</p>
          <p>{{s.price_sale}}</p>
          <p>{{s.mount_sale}}</p>
          <p>Fecha: {{s.date_created}}</p>
          <hr>
          <strong>Usuario</strong>
          <p>{{s.user}}</p>
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
      sales: [],
      existsData: true,
      msgRes: ""
    },
    methods: {
      async getsales() {
        const res = await axios({
          method: "GET",
          url: "/api/sale/get.php"
        })
        if (res.data.status >= 400) {
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.sales = res.data.data
      },
      async deleteSale(id, i) {
        const res = await axios({
          method: "GET",
          url: `/api/sale/delete.php?id=${id}`
        })
        if (res.data.status == 200) {
          this.sales.splice(i, 1);
          this.existsData = false;
          this.msg = "No existen datos registrados"
        }
      }
    },
    created() {
      this.getsales()
    }
  })
</script>
</body>

</html>