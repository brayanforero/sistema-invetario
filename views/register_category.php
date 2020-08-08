<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">

  <div class="row justify-content-center align-items-center">
    <div class="col-md-8">
      <form @submit.prevent="sendData" class="card" id="newCategory">
        <div class="card-header bg-primary text-center text-light">
          <span class="card-title h2 text-center">Registro de Categoria<p>
        </div>
        <div class="card-body">
          <div class="form-group d-flex justify-content-center align-items-center">
            <input v-model="newCategory.name" placeholder="Nombre de la categoria" type="text" class="form-control">
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
      newCategory: {
        name: "",
      }

    },
    methods: {

      sendData() {
        const category = {
          name: this.newCategory.name,
          id_user: parseInt(id.textContent)
        }
        this.newCategory.name = ""
        $.ajax({
          type: "POST",
          url: "/api/categories/new.php",
          data: category,
          dataType: "json",
          beforeSend: () => {
            $("#newCategory button").text("Procesando...")
          },
          success: (res) => {
            $("#newCategory button").text("Registrar")
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