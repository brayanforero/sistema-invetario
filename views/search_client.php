<?php
require_once '../utilities/sessions.php';
verifySession();
include_once './partials/header.php';
include_once './partials/nav.php';
?>
<div class="container" id="app">
  <h3 class="text-center mb-3">Buscar cliente</h3>
  <div class="row mb-5">
    <div v-show="isSearch" class="col-12 mb-2">
      <div :class="{'alert-info': !isError, 'alert-danger': isError}" class="alert text-center m-auto w-50 p-1">
        <b>{{msgHtml}}</b>
      </div>
    </div>
    <div class="col-6 m-auto d-flex">
      <select v-model="typeDoc" class="form-control w-25 mr-2">
        <option v-for="sc in selectDoc" :value="[sc.value]">
          {{sc.key}}
        </option>
      </select>
      <input v-model="doc" type="text" class="form-control" placeholder="Ingresa en n° de cedula o documento">
      <button @click="seachClient" class="btn btn-primary ml-2">Buscar </button>
    </div>
  </div>

  <div v-show="client.doc" class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <p>{{client.name}}</p>
          <p>{{client.doc}}</p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
require_once "./partials/scripts.php"
?>

<script src="/public/js/vue.js"></script>
<script>
  const app = new Vue({
    el: "#app",
    data: {
      title: "Vue",
      typeDoc: "",
      doc: "",
      selectDoc: [{
        key: "V",
        value: "V-"
      }, {
        key: "E",
        value: "E-"
      }],
      isSearch: false,
      isError: false,
      msgHtml: "Buscando...",
      client: {
        doc: "",
        name: "",
        email: "",
        phone_number: "",
        address: "",
        date_created: "",
        last_date_update: "",
        user: ""
      }
    },
    methods: {
      async seachClient() {
        this.isSearch = true
        const res = await fetch(`/api/client/get.php?document=${this.typeDoc + this.doc}`)
        const data = await res.json()

        if (data.data) {
          data.data[0]
          this.setData(data.data[0])
        }
        this.showMessage(data)
      },
      showMessage(res) {
        if (res.status >= 400) {
          this.isError = true
          this.msgHtml = res.msg
          setInterval(() => {
            this.isSearch = false
            this.isError = false
            this.msgHtml = "Cargando..."
          }, 3000);
        } else {
          this.isSearch = false
          this.typeDoc = "";
          this.doc = "";
          return
        }

      },
      setData(data) {
        this.client.doc = data.doc
        this.client.name = data.name;
        this.client.email = data.email;
        this.client.phone_number = data.phone;
        this.client.address = data.address;
        this.client.date_created = data.date_created;
        this.client.last_date_update = data.last_date_update;
        this.client.user = data.user;
      }
    }
  })
</script>
</body>

</html>