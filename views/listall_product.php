<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Productos registrados</h3>
  <div class="row">
    <div v-show="!existsData" class="alert alert-danger col-12 text-center trans">
      <b>{{msgRes}}</b>
    </div>
    <div class="col-12 col-md-4 mb-3" v-for="p in products">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-light text-center">
          <p class="h5 m-0">{{p.category}}</p>
        </div>
        <div class="card-body">
          <strong>Detalles del producto</strong>
          <p>{{p.name}}</p>
          <p>Precio de compra: {{p.p_shop}} <span class="text-danger">Bs.S</span></p>
          <p>Precio de venta: {{p.p_sale}} <span class="text-success">Bs.S</span></p>
          <p>Cantidad disponible <span class="text-success">{{p.stock}}</span> </p>
        </div>
        <div class="card-footer">
          <strong>Provedor</strong>
          <p>{{p.provider}}</p>
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
      products: [],
      existsData: true,
      msgRes: ""
    },
    methods: {
      async getProduct() {

        const res = await axios({
          method: "GET",
          url: "/api/product/get.php"
        })
        if (res.data.status >= 400) {
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.products = res.data.data
      }
    },
    created() {
      this.getProduct()
    }
  })
</script>
</body>

</html>