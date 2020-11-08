<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">

  <div class="row justify-content-center align-items-center">
    <div class="col-md-8">
      <form @submit.prevent="sendData" class="card" id="newProvider">
        <div id="alert" class="alert  p-2 text-center d-none"></div>
        <div class="card-body">
          <p class="card-title h2 text-center">Registro de Provedor<p>
              <div class="form-group d-flex justify-content-center align-items-center">
                <select required v-model="newProvider.typeDoc" class="form-control w-25 mr-2" id="docSelect">
                  <option value="V-">V</option>
                  <option value="E-">E</option>
                  <option value="J-">J</option>
                </select>
                <input required id="doc" v-model="newProvider.doc" placeholder="Cedula o documento fiscal" type="text" class="form-control" minlength="8" maxlength="16">
              </div>
              <div class="form-group">
                <input required v-model="newProvider.name" placeholder="Nombre de la persona o empresa" type="text" class="form-control">
              </div>
              <div class="form-group d-flex justify-content-center align-items-center">
                <input v-model="newProvider.email" placeholder="Correo electrónico" type="text" class="form-control">
                <span class="text-warning ml-1">*</span>
              </div>
              <div class="form-group d-flex justify-content-center align-items-center">
                <input required id="phone" v-model="newProvider.phone" placeholder="Número de telefono" type="text" class="form-control" minlength="8" maxlength="16">
                <span class="text-warning ml-1">*</span>
              </div>
              <div class="form-group d-flex justify-content-center align-items-center">
                <input v-model="newProvider.addr" placeholder="Dirección" type="text" class="form-control">
                <span class="text-warning ml-1">*</span>
              </div>

              <div class="form-group">
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
      newProvider: {
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
        const user = {
          doc: this.newProvider.typeDoc + this.newProvider.doc,
          name: this.newProvider.name,
          email: this.newProvider.email,
          phone: this.newProvider.phone,
          addr: this.newProvider.addr,
          id_user: parseInt(id.textContent)
        }

        this.newProvider.typeDoc = ""
        this.newProvider.doc = ""
        this.newProvider.name = ""
        this.newProvider.email = ""
        this.newProvider.phone = ""
        this.newProvider.addr = ""

        $.ajax({
          type: "POST",
          url: "/api/providers/new.php",
          data: user,
          dataType: "json",
          beforeSend: () => {
            $("#newProvider button").text("Procesando...")
          },
          success: (res) => {
            $("#newProvider button").text("Registrar")
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

      }
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