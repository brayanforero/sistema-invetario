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
    <div class="col-12 col-md-4 mb-3" v-for="(p,i) in products">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-light text-center">
          <p class="h5 m-0">{{p.category}}</p>
        </div>
        <div class="card-body">
          <strong>Detalles del producto</strong>
          <p>{{p.name}}</p>
          <p>Precio de compra: {{p.p_shop}} $</p>
          <p>Precio de venta: {{p.p_sale}} $</p>
          <p>Cantidad disponible <span :class="{'text-success': p.stock > 10,'text-warning': p.stock >= 5 && p.stock <= 10, 'text-danger': p.stock < 5}">{{p.stock == 0 ? 'no disponbile': p.stock}}</span></p>
          <button class="btn btn-primary" @click="updateStock(p.id, i)">Sumar stock <i class="fas fa-circle-plus"></i></button>
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
      msgRes: "",
      changeStock: {
        id: 0,
        i: 0,
      }
    },
    methods: {
      async getProduct() {

        const res = await axios({
          method: "GET",
          url: "/api/product/get.php?filter=0"
        })
        if (res.data.status >= 400) {
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.products = res.data.data
      },
      updateStock(id, i){
        this.changeStock.id = id
        this.changeStock.i = i
        bootbox.prompt({
            title: `¿Cuanto deseas agregar de ${this.products[i].name}?`,
            centerVertical: true,
            callback: function(result){
              app.changeStock.stock = result
              if(result <= 0) {
                bootbox.alert("Ingresa una cantida valida");
                return 
              }
              $.ajax({
              type: "POST",
              url: "/api/product/changestock.php",
              data: {
                stock: result,
                id: app.changeStock.id
              },
              dataType: "json",
              success: async (res) => {
                
                if (res.status >= 400) {
                  bootbox.alert(res.msg)
                  return
                } 
                bootbox.alert(res.msg)
                await app.getProduct();
              },
              falied: (err) => {
                console.log(err);
                bootbox.alert("Ha ocurrido un error al conectar con el servidor")
              }
            })
            }
        });
      }
    },
    created() {
      this.getProduct()
    }
  })
</script>
</body>

</html>