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
  <title>Sistema de Inventario</title>
  <!-- CARGA DE LOS ESTILOS PARA EL DISEÑO -->
  <link rel="stylesheet" href="/public/css/litera.css">
  <link rel="stylesheet" href="/public/css/main.css">
  <!-- CARGANDO EL ARCHIVOS DE ICONOS -->
</head>

<body>
  <?php include_once './views/partials/nav.php' ?>
  <div class="container" id="app">
    <div class="row justify-content-center">
      <div class="col-md-6">

        <div class="card">
          <div class="card-header bg-primary p-4 text-center">
            <span class="h4 m-0 text-light ">Agregar Venta <i class="fas fa-shopping-cart"></i></span>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="client">Seleccione un Cliente</label>
              <select v-model.lazy="clientSelect" @change="onSelectClient($event)" class="form-control" name="#" id="client">
                <option v-for="(c,i) in listClients" :value="i">{{c.name}}</option>
                <option v-if="!listClients" disabled>No hay clientes registrados</option>
              </select>
            </div>
            <div class="form-group">
              <label for="product">Seleccione un Producto</label>
              <select v-model.lazy="productSelect" @change="onSelectProduct($event)" class="form-control" name="#" id="product">
                <option v-for="(p,i) in listProducts" :value="i">{{p.name}}</option>
                <option v-if="!listProducts" disabled>No hay productos registrados</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div v-show="isSelectedProduct" class="card p-4">
          <div  class="form-group">
              <label for="product_count">Indique la cantidad</label>
              <input @change="validateNumber($event)" v-model.lazy="countProduct" class="form-control mb-2 w-75" id="product_count" type="number">
              <span class="small" :class="[colorStock]">Disponible: {{productSelected.stock}}</span>
            </div>
            <div v-show="isSelectedProduct" class="form-group">
              <label for="price">Precio</label>
              <input v-model="productSelected.p_sale" disabled class="form-control">
            </div>
            <div v-show="isSelectedProduct" class="form-group">
              <label for="price">Total</label>
              <input disabled v-model="totalPrice" class="form-control">
            </div>
            <div class="form-group">
              <div class="d-none alert text-center p-1">Procesando...</div>
              <button :disabled="!listClients || !listProducts || !isSelectedProduct" @click="sale" class="btn btn-primary btn-block">Agregar Venta</button>
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
        productSelected: {},
        clientSelected: {},
        clientSelect: "",
        productSelect: "",
        listProducts: [],
        listClients: [],
        countProduct: 1,
        productSale: {},
        isSelectedProduct: false,
      },
      computed: {
        colorStock() {
          return {
            "text-success": this.productSelected.stock >= 10,
            "text-warning": this.productSelected.stock > 5 && this.productSelected.stock < 10,
            "text-danger": this.productSelected.stock <= 5,
          }
        },
        totalPrice() {
          return (this.productSelected.p_sale * this.countProduct).toFixed(2)
        }
      },
      methods: {
        sale() {
          this.productSale.user = id.textContent;
          this.productSale.client = this.clientSelected.id;
          this.productSale.product = this.productSelected.id;
          this.productSale.count = this.countProduct;
          this.productSale.price_sale = this.productSelected.p_sale;

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
                  .html(`<i class="fas fa-times-circle"></i> ${res.msg}`)
              } else {
                app.listProducts[app.productSelect].stock -= app.countProduct
                app.reset()
                $(".alert")
                  .removeClass("alert-info alert-danger")
                  .addClass("alert-success")
                  .html(`<i class="fas fa-check-circle"></i> ${res.msg}`)
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
              .html("")
          }, 5000);
        },
        async getProducts() {
          const res = await axios({
            method: "GET",
            url: "/api/product/get.php?filter=stock"
          })
          this.listProducts = res.data.data
        },
        async getClients() {
          const res = await axios({
            method: "GET",
            url: "/api/client/get.php"
          })
          this.listClients = res.data.data
        },
        validateNumber(e) {
          if (parseInt(e.target.value) <= 0) {
            this.countProduct = 1
            return
          }
          // if (parseInt(e.target.value) > this.product.stock) {
          //   this.countProduct = this.product.stock
          // }
        },
        onSelectClient(e) {
          this.clientSelected = this.listClients[this.clientSelect]
        },
        onSelectProduct(e) {
          this.isSelectedProduct = true
          this.productSelected = this.listProducts[this.productSelect]
        },
        reset() {
          this.countProduct = 1
        },
      },
      created() {
        this.getProducts();
        this.getClients();
      },
    })
  </script>
</body>

</html>