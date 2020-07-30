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
            <div class="form-group">
              <label for="product">Seleccione un Producto</label>
              <select v-model="productSelected" class="form-control" name="#" id="product">
                <option v-for="(p,i) in products" :value="i">{{p.name}}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="product_count">Cantidad</label>
              <input v-model="countProduct" class="form-control mb-2" step="1" id="product_count" type="number">
              <small class="text-success">Disponible: {{product.stock}}</small>
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
              <button @click="sale" class="btn btn-primary btn-block">Agregar a lista <i class="fas fa-shopping-cart"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include './views/partials/scripts.php' ?>
  <script src="/public/js/axios.js"></script>
  <script>
    const app = new Vue({
      el: "#app",
      data: {
        productSelected: 0,
        title: "App Vue main",
        products: [],
        countProduct: 1
      },
      computed: {
        product() {
          return this.products[this.productSelected]
        },
        totalPrice() {
          return (this.countProduct * this.product.p_sale).toFixed(2)
        },
      },
      watch: {
        validate() {
          if (this.countProduct > this.product.stock) {
            alert('Estas exediendo el limite del stock')
          }
        }
      },
      methods: {
        sale() {
          console.log("sale");
        },
        async getProducts() {
          const res = await axios({
            method: "GET",
            url: "/api/product/get.php?stock=1"
          })
          this.products = res.data.data
        },
      },
      created() {
        this.getProducts();
      }
    })
  </script>
</body>

</html>