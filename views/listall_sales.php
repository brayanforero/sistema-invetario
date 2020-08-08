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
        <div class="card-header bg-light">
          <span class="h5 d-block text-center">Información de Venta</span>
          <p>N° de Venta: <strong>{{s.id}}</strong></p>
          <p>Fecha y hora: <strong> {{s.fecha}}</strong></p>
        </div>
        <div class="card-body">
          <p>Cliente: <strong>{{s.client}}</strong></p>
          <p>Producto: <strong>{{s.product}}</strong></p>
          <p>Unidades: <strong>{{s.quantity}}</strong></p>
          <p>Precio Vendido: <strong>{{s.price_sale}}</strong> $</p>
          <p>Total de Venta: <strong>{{s.mount_sale}}</strong> $</p>
          <hr>
          <strong>Usuario</strong>
          <p>{{s.user}}</p>
          <button @click="deleteSale(s.id, i)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
      deleteSale(id, i) {
        bootbox.confirm(`Esta seguro de eliminar la venta ${this.sales[i].id}, esta acción no se puede revertir`, async result => {
          if (result) {
            const res = await axios({
              method: "GET",
              url: `/api/sale/delete.php?id=${id}`
            })
            if (res.data.status == 200) {
              bootbox.alert(`${res.data.msg}`)
              this.sales.splice(i, 1)
              this.existsData = false
              this.msgRes = "No existen datos registrados"
              return
            }
            bootbox.alert("No se pudo completar su operacion")
          }
        })
      }
    },
    created() {
      this.getsales()
    }
  })
</script>
</body>

</html>