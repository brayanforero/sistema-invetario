<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">

  <div class="row justify-content-center align-items-center">
    <div class="col-md-8">
      <form @submit.prevent="sendData" class="card" id="newProduct">
        <div class="card-header bg-primary text-center text-light">
          <span class="card-title h2 text-center">Registro de Producto<span>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="productName">Nombre o descripcion del producto:</label>
            <input required id="productName" v-model="newProduct.name" type="text" class="form-control">
          </div>
          <div class="form-group">
            <label for="provider">Selecione un provedor:</label>
            <select id="provider" class="form-control" v-model="newProduct.provider">
              <option v-for="p in providerOpt" :value="p.id">{{p.name}}</option>
              <option disabled v-show="providerOpt.length == 0">No exiten provedores registrados</option>
            </select>
          </div>
          <div class="form-group">
            <label for="category">Seleccione una categoria:</label>
            <select @change="isEnabled = true" id="category" class="form-control" v-model="newProduct.category">
              <option v-for="c in categoriesOpt" :value="c.id">{{c.name}}</option>
              <option disabled v-show="categoriesOpt.length == 0">No exiten categorias registradas</option>
            </select>
          </div>
        </div>
        <div class="card-footer" v-show="isEnabled">
          <div class="form-group">
            <label for="count">Indique la cantidad para el stock:</label>
            <input required id="count" name="stock" @change="validateStock($event)" v-model="newProduct.count" type="number" class="form-control">
          </div>
          <div class="form-group">
            <label for="priceShop">Precio de compra:</label>
            <input required name="priceShop" id="priceShop" @change="validateStock($event)" v-model="newProduct.shopPrice" type="number" step="0.25" class="form-control">
          </div>
          <div class="form-group">
            <label for="priceSale">Precio de venta:</label>
            <input id="priceSale" required name="priceSale" @change="validateStock($event)" v-model="newProduct.salePrice" type="number" step="0.25" class="form-control">
          </div>

          <div class="form-group">
            <div id="alert" class="alert  p-2 text-center d-none"></div>
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
require_once "./partials/scripts.php"
?>
<script src="/public/js/axios.js"></script>
<script src="/public/js/vue.js"></script>
<script>
  const id = document.querySelector("#id")
  const app = new Vue({
    el: "#app",
    data: {
      newProduct: {
        name: "",
        provider: "",
        category: "",
        count: 1,
        shopPrice: 0.25,
        salePrice: 0.25
      },
      providerOpt: [],
      categoriesOpt: [],
      isEnabled: false
    },

    methods: {

      sendData() {
        const user = {
          name: this.newProduct.name,
          provider: this.newProduct.provider,
          cat: this.newProduct.category,
          count: this.newProduct.count,
          price_sp: this.newProduct.shopPrice,
          price_sl: this.newProduct.salePrice,
          id_user: parseInt(id.textContent)
        }

        this.newProduct.name = ""
        this.newProduct.provider = ""
        this.newProduct.category = ""
        this.newProduct.count = ""
        this.newProduct.shopPrice = ""
        this.newProduct.salePrice = ""

        $.ajax({
          type: "POST",
          url: "/api/product/new.php",
          data: user,
          dataType: "json",
          beforeSend: () => {
            $("#newProduct button").text("Procesando...")
          },
          success: (res) => {
            $("#newProduct button").text("Registrar")
            if (res.status >= 400) {
              $("#alert").addClass("alert-danger").html(`<b>${res.msg}<b>`).removeClass("d-none")

              setInterval(() => {
                $("#alert").addClass("d-none").html("").removeClass("alert-danger")
              }, 5000);
              return
            }

            $("#alert").addClass("alert-success").html(`<b>${res.msg}<b>`).removeClass("d-none")
            setInterval(() => {
              $("#alert").addClass("d-none").html("").removeClass("alert-success")
              app.isEnabled = false
            }, 5000);

          },
          falied: (err) => {
            console.log(err);
          }
        })

      },
      async getProvider() {

        const res = await axios({
          method: "GET",
          url: "/api/providers/get.php"
        })
        if (res.data.status >= 400) {
          return
        }
        this.providerOpt = res.data.data
        const cat = await axios({
          method: "GET",
          url: "/api/categories/get.php"
        })

        this.categoriesOpt = cat.data.data

      },
      validateStock(e) {
        if (e.target.value == 0) {
          this.validateInputByName(e.target.name)
        }
      },
      validateInputByName(name) {
        switch (name) {
          case "stock":
            this.newProduct.count = 1
            break;
          case "priceShop":
            this.newProduct.shopPrice = 0.25
            break;
          case "priceSale":
            this.newProduct.salePrice = 0.25
            break;
          default:
            console.log("Ha ocurrido un error");
            break;
        }
      }
    },
    created() {
      this.getProvider()
    }
  })
</script>
</body>

</html>