<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">

  <div class="row justify-content-center align-items-center">
    <div class="col-md-8">
      <form @submit.prevent="sendData" class="card" id="newUser">
        <div id="alert" class="alert  p-2 text-center d-none"></div>
        <div class="card-body">
          <p class="card-title h2 text-center">Registro de Usuario<p>
              <div class="form-group d-flex justify-content-center align-items-center">
                <select required v-model="newUser.typeDoc" class="form-control w-25 mr-2" id="docSelect">
                  <option value="V-">V</option>
                  <option value="E-">E</option>
                  <input required v-model="newUser.doc" placeholder="Cedula de identidad" type="text" class="form-control">
                </select>
              </div>
              <div class="form-group">
                <input v-model="newUser.fullname" placeholder="Nombre de completo" type="text" class="form-control">
              </div>
              <div class="form-group">
                <input v-model="newUser.username" placeholder="Nombre de ususario" type="text" class="form-control">
              </div>
              <div class="form-group">
                <input v-model="newUser.password" placeholder="Contraseña" type="password" class="form-control">
              </div>
              <div class="form-group">
                <select v-model="newUser.role" class="form-control" id="role">
                  <option value="ADMIN">Administrador</option>
                  <option value="VENDOR">Vendedor</option>
                </select>
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
      newUser: {
        typeDoc: "V-",
        doc: "",
        fullname: "",
        username: "",
        password: "",
        role: "ADMIN",
      }

    },
    methods: {

      sendData() {
        const user = {
          document: `${this.newUser.typeDoc}${this.newUser.doc}`,
          fullName: this.newUser.fullname,
          userName: this.newUser.username,
          userPass: this.newUser.password,
          role: this.newUser.role
        }

        $.ajax({
          type: "POST",
          url: "/api/user/new.php",
          data: user,
          dataType: "json",
          beforeSend: () => {
            $("#newUser button").text("Procesando...")
          },
          success: (res) => {
            console.log(res);
            $("#newUser button").text("Registrar")
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
    },
    created() {

    }
  })
</script>
</body>

</html>