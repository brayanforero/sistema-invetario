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
        <div id="alert" class="alert  p-2 text-center d-none"></div>
        <div class="card-body">
          <p class="card-title h2 text-center">Registro de Producto<p>
              <div class="form-group d-flex justify-content-center align-items-center">
                <input v-model="newProduct.name" placeholder="Nombre o descripcion del producto" type="text" class="form-control">
              </div>
              <div class="form-group">
                <select class="form-control" aria-placeholder="Selecciona un provedor" v-model="newProduct.provider">

                  <option v-for="p in providerOpt" :value="p.id">{{p.name}}</option>
                </select>
              </div>
              <div class="form-group d-flex justify-content-center align-items-center">
                <input v-model="newProduct.count" placeholder="Cantidad a registrar" type="number" class="form-control">
              </div>
              <div class="form-group d-flex justify-content-center align-items-center">
                <input v-model="newProduct.shopPrice" placeholder="Precio de compra" type="number" step="0.25" class="form-control">

              </div>
              <div class="form-group d-flex justify-content-center align-items-center">
                <input v-model="newProduct.salePrice" placeholder="Precio de venta" type="number" step="0.25" class="form-control">

              </div>

              <div class="form-group">
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
        count: "",
        shopPrice: "",
        salePrice: ""
      },
      providerOpt: []
    },
    methods: {

      sendData() {
        const user = {
          name: this.newProduct.name,
          provider: this.newProduct.provider,
          count: this.newProduct.count,
          price_sp: this.newProduct.shopPrice,
          price_sl: this.newProduct.salePrice,
          id_user: parseInt(id.textContent)
        }

        this.newProduct.name = ""
        this.newProduct.provider = ""
        this.newProduct.count = ""
        this.newProduct.shopPrice = ""
        this.newProduct.salePrice = ""

        $.ajax({
          type: "POST",
          url: "/api/product/new.php",
          data: user,
          dataType: "json",
          beforeSend: () => {
            $("#newClient button").text("Procesando...")
          },
          success: (res) => {
            $("#newClient button").text("Registrar")
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
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.providerOpt = res.data.data
      }
    },
    created() {
      this.getProvider()
    }
  })
</script>
</body>

</html>