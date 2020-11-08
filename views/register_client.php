<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">

  <div class="row justify-content-center align-items-center">
    <div class="col-md-8">
      <form @submit.prevent="sendData" class="card" id="newClient">
        <div class="card-header bg-primary text-center text-light">
          <span class="card-title h2 text-center">Registro de Cliente</span>
        </div>
        <div class="card-body">
          <div class="form-group d-flex justify-content-center align-items-center">
            <select required v-model="newClient.typeDoc" class="form-control w-25 mr-2" id="docSelect">
              <option value="V-">V</option>
              <option value="E-">E</option>
            </select>
            <input required id="doc" v-model="newClient.doc" placeholder="Cedula de identidad" type="text" class="form-control">
          </div>

          <div class="form-group">
            <input required v-model="newClient.name" placeholder="Nombre completo" type="text" class="form-control">
          </div>
          <div class="form-group d-flex justify-content-center align-items-center">
            <input required v-model="newClient.email" placeholder="Correo electrónico" type="email" class="form-control">
            <span class="text-warning ml-1">*</span>
          </div>
          <div class="form-group d-flex justify-content-center align-items-center">
            <input required id="phone" v-model="newClient.phone" placeholder="Número de telefono" type="text" class="form-control">
            <span class="text-warning ml-1">*</span>
          </div>

          <div class="form-group d-flex justify-content-center align-items-center">
            <input required v-model="newClient.addr" placeholder="Dirección" type="text" class="form-control">
            <span class="phone text-warning ml-1">*</span>
          </div>

          <div class="form-group">
            <div id="alert" class="alert  p-2 text-center d-none"></div>
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
          </div>
        </div>
        <div class="card-footer">
          <p>Campos opcionales <span class="text-warning">*</span></p>
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
      newClient: {
        typeDoc: "",
        doc: "",
        name: "",
        email: "",
        phone: "",
        addr: ""
      }
    },
    methods: {
      sendData() {
        if (!this.newClient.typeDoc) {
          bootbox.alert("Debes seleccionar un tipo de documento")
          return
        }
        const user = {
          doc: this.newClient.typeDoc + this.newClient.doc,
          name: this.newClient.name,
          email: this.newClient.email,
          phone: this.newClient.phone,
          addr: this.newClient.addr,
          id_user: parseInt(id.textContent)
        }

        this.newClient.typeDoc = ""
        this.newClient.doc = ""
        this.newClient.name = ""
        this.newClient.email = ""
        this.newClient.phone = ""
        this.newClient.addr = ""

        $.ajax({
          type: "POST",
          url: "/api/client/new.php",
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
    }
  })


  document.querySelector("#phone").addEventListener("keyup", (e) => {
    if (/\D/g.test(e.target.value)) {
      e.target.value = ''
      return
    }
  })

  document.querySelector("#doc").addEventListener("keyup", (e) => {
    if (/\D/g.test(e.target.value)) {
      e.target.value = ''
      return
    }
  })
</script>
</body>

</html>