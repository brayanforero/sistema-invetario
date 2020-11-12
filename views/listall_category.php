<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Categorias registradas</h3>
  <div class="row">
    <div v-show="!existsData" class="alert alert-danger col-12 text-center trans">
      <b>{{msgRes}}</b>
    </div>
    <div class="col-12 col-md-6 mb-3" v-for="(c,i) in categories">
      <div class="card rounded shadow-sm">
        <div :class="{'bg-info': c.id %2 != 0, 'bg-primary': c.id %2 == 0}" class="card-body text-center text-light">
          <span class="h6 m-0 text-center">{{c.name}}</span>

          <a class="text-light" @click.prevent="changeName(c.id, i)" href="#"><i class="fas fa-edit"></i></a>
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
      categories: [],
      existsData: true,
      msgRes: "",
      changeCategory: {
        id: 0,
        i: 0
      }
    },
    methods: {
      async getCategories() {

        const res = await axios({
          method: "GET",
          url: "/api/categories/get.php"
        })
        if (res.data.status >= 400) {
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.categories = res.data.data
      },
      changeName(id, i){
        this.changeCategory.id = id
        this.changeCategory.i = i
        const dialog = bootbox.dialog({
          title: `Ingresa un nombre`,
          message: `<input id='inputModalName' onkeyUp='onlyLetter()' class='form-control'></input>`,
          size: 'medium',
          centerVertical: true,
          buttons: {
            cancel: {
              label: "Cancelar",
              className: 'btn-secondary',
            },
            ok: {
              label: "Ok",
              className: 'btn-primary',
              callback: function(){

                if (document.querySelector("#inputModalName").value == '') {
                bootbox.alert("Debes ingresar un nombre");
                 return 
                }
                $.ajax({
                  type: "POST",
                  url: "/api/categories/update.php",
                  data: {
                    name: document.querySelector("#inputModalName").value,
                    id: app.changeCategory.id
                  },
                  dataType: "json",
                  success: async (res) => {
                    if (res.status >= 400) {
                    bootbox.alert(res.msg)
                      return
                    } 
                    bootbox.alert(res.msg)
                      await app.getCategories();
                    },
                    falied: (err) => {
                      console.log(err);
                      bootbox.alert("Ha ocurrido un error al conectar con el servidor")
                    }
                })
              }
            }
          }
        });
      }
    },
    created() {
      this.getCategories()
    }
  })

  onlyLetter= ()=> {

    if (!(/[aA-zZ\s]/g.test(document.querySelector("#inputModalName").value))) {
      document.querySelector("#inputModalName").value = ''
      return
    }
  }
</script>
</body>

</html>