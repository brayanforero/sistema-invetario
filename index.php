<?php require_once './utilities/sessions.php';
verifySession(); ?>
<!DOCTYPE html>

<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <!-- CARGANDO VUE JS -->
  <script src="/public/js/vue.js"></script>
  <title>Sistema de Inventario - Francisco</title>
  <!-- CARGA DE LOS ESTILOS PARA EL DISEÑO -->
  <link rel="stylesheet" href="/public/css/litera.css">
  <link rel="stylesheet" href="/public/css/main.css">
  <!-- CARGANDO EL ARCHIVOS DE ICONOS -->
</head>

<body>
  <?php include_once './views/partials/nav.php' ?>
  <div class="container" id="app">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="card">
          <div class="card-header bg-primary">
            <p class="h4 m-0 text-light text-center">Agregar Venta</p>
          </div>
          <div class="card-body">
            <div class="d-none alert text-center p-1">Procesando...</div>
            <div class="form-group">
              <label for="client">Seleccione un Cliente</label>
              <select v-model="clientSelected" class="form-control" name="#" id="client">
                <option v-for="(c,i) in clients" :value="i">{{c.name}}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="product">Seleccione un Producto</label>
              <select v-model="productSelected" class="form-control" name="#" id="product">
                <option v-for="(p,i) in products" :value="i">{{p.name}}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="product_count">Cantidad - </label>
              <strong :class="[colorStock]">Disponible: {{product.stock}}</strong>
              <input v-model="countProduct" class="form-control mb-2" step="1" id="product_count" type="number">
            </div>
            <div class="form-group">
              <label for="price">Precio</label>
              <input v-model="product.p_sale" disabled class="form-control" id="price">
            </div>
            <div class="form-group">
              <label for="price">Total</label>
              <input disabled v-model="totalPrice" class="form-control" name="#" id="price">
            </div>
            <div class="form-group">
              <button @click="sale" class="btn btn-primary btn-block">Agregar Venta<i class="fas fa-shopping-cart"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include './views/partials/scripts.php' ?>
  <script src="/public/js/axios.js"></script>
  <script>
    const id = document.querySelector("#id")
    const app = new Vue({
      el: "#app",
      data: {
        productSelected: 0,
        clientSelected: 0,
        title: "App Vue main",
        products: [],
        clients: [],
        countProduct: 1,
        productSale: {},
      },
      computed: {
        product() {
          return this.products[this.productSelected]
        },
        client() {
          return this.clients[this.clientSelected]
        },
        totalPrice() {
          return (this.countProduct * this.product.p_sale).toFixed(2)
        },
        colorStock() {
          return {
            "text-success": this.product.stock >= 10,
            "text-warning": this.product.stock > 5 && this.product.stock < 10,
            "text-danger": this.product.stock <= 5,
          }
        }
      },
      methods: {
        sale() {

          this.productSale.user = id.textContent;
          this.productSale.client = this.client.id;
          this.productSale.product = this.product.id;
          this.productSale.count = this.countProduct;
          this.productSale.price_sale = this.product.p_sale;

          let sale = this.productSale
          this.productSale = {}

          $.ajax({
            type: "POST",
            url: "/api/sale/new.php",
            data: sale,
            dataType: "json",
            beforeSend: () => {
              $(".alert")
                .removeClass("d-none")
                .addClass("alert-info")
                .text("Procesando...")
            },
            success: (res) => {
              if (res.status > 200) {
                $(".alert")
                  .removeClass("alert-info")
                  .addClass("alert-danger")
                  .text(res.msg)
              } else {

                $(".alert")
                  .removeClass("alert-info alert-danger")
                  .addClass("alert-success")
                  .text(res.msg)
              }
            },
            falied: (err) => {
              console.log(err);
            }
          })
          setInterval(() => {
            $(".alert")
              .removeClass("alert-info alert-danger alert-info")
              .addClass("d-none")
              .text("")
          }, 5000);
          this.getProducts();
        },
        async getProducts() {
          const res = await axios({
            method: "GET",
            url: "/api/product/get.php?filter=stock"
          })
          this.products = res.data.data
        },
        async getClients() {
          const res = await axios({
            method: "GET",
            url: "/api/client/get.php"
          })
          this.clients = res.data.data
        },
      },
      created() {
        this.getProducts();
        this.getClients();
      }
    })
  </script>
</body>

</html>