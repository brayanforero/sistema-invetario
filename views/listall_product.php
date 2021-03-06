<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Productos registrados</h3>
  <div class="row">
    <div v-show="!existsData" class="alert alert-danger col-12 text-center trans">
      <b>{{msgRes}}</b>
    </div>
    <div class="col-12 col-md-4 mb-3" v-for="(p,i) in products">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-light text-center">
          <p class="h5 m-0">{{p.category}}</p>
        </div>
        <div class="card-body">
          <strong>Detalles del producto</strong>
          <p>{{p.name}}</p>
          <p>Precio de compra: {{p.p_shop}} COP</p>
          <p>Precio de venta: {{p.p_sale}} COP</p>
          <p>Cantidad disponible <span :class="{'text-success': p.stock > 10,'text-warning': p.stock >= 5 && p.stock <= 10, 'text-danger': p.stock < 5}">{{p.stock == 0 ? 'no disponbile': p.stock}}</span></p>
          <?php if ($_SESSION['access_system']['role'] === 'ADMIN') : ?>
            <button class="btn btn-primary btn-sm" @click="changeName(p.id, i)">Cambiar Nombre <i class="fas fa-edit"></i></button>
          <button class="btn btn-primary btn-sm" @click="updateStock(p.id, i)">Sumar stock <i class="fas fa-plus-circle"></i></button>
          <?php endif?>
        </div>
        <div class="card-footer">
          <strong>Provedor</strong>
          <p>{{p.provider}}</p>
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
      products: [],
      existsData: true,
      msgRes: "",
      changeStock: {
        id: 0,
        i: 0,
      }
    },
    methods: {
      async getProduct() {

        const res = await axios({
          method: "GET",
          url: "/api/product/get.php?filter=0"
        })
        if (res.data.status >= 400) {
          this.existsData = false
          this.msgRes = res.data.msg
          return
        }
        this.products = res.data.data
      },
      updateStock(id, i){
        this.changeStock.id = id
        this.changeStock.i = i
        
        const dialog = bootbox.dialog({
          title: `¿Cuanto deseas agregar de ${this.products[i].name}?`,
          message: "<input id='inputModalName' onkeyUp='valid()' class='form-control' type='textplaceholer='0'></input>",
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

                if (document.querySelector("#inputModal").value <= 0 || document.querySelector("#inputModal").value == '') {
                bootbox.alert("Ingresa una cantidad valida");
                 return 
                }
                $.ajax({
                  type: "POST",
                  url: "/api/product/changestock.php",
                  data: {
                    stock: document.querySelector("#inputModal").value,
                    id: app.changeStock.id
                  },
                  dataType: "json",
                  success: async (res) => {
                    if (res.status >= 400) {
                    bootbox.alert(res.msg)
                      return
                    } 
                    bootbox.alert(res.msg)
                      await app.getProduct();
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
      },
      changeName(id, i){
        this.changeStock.id = id
        this.changeStock.i = i
        const dialog = bootbox.dialog({
          title: `Ingresa un nombre`,
          message: `<input id='inputModalName' value='${this.products[i].name}' class='form-control'></input>`,
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
                  url: "/api/product/update.php",
                  data: {
                    name: document.querySelector("#inputModalName").value,
                    id: app.changeStock.id
                  },
                  dataType: "json",
                  success: async (res) => {
                    if (res.status >= 400) {
                    bootbox.alert(res.msg)
                      return
                    } 
                    bootbox.alert(res.msg)
                      await app.getProduct();
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
      this.getProduct()
    }
  })

  const valid = (id) => {
    if (/\D/g.test(document.querySelector("#inputModal").value)) {
      document.querySelector("#inputModal").value = ""
      return;
    }
  }
</script>
</body>

</html>