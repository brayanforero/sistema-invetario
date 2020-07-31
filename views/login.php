<?php include_once '../views/partials/header.php' ?>
<!-- <?= password_hash("1234", PASSWORD_BCRYPT) ?> -->
<div id="app" class="h-100">
  <div class="container">
    <!-- FILA -->
    <div class="row justify-content-center align-items-center">
      <!-- FORMULARIO DE LOGIN -->
      <div class="col-md-8 col-lg-5">
        <form id="formLogin" @submit.prevent="sendData" class="card rounded">
          <div class="card-header text-center">
            <p class="h1">Acceso al Sistema</p>
          </div>
          <div class="card-body">
            <div class="form-group">
              <input required autocomplete="off" v-model="nameUser" name="userName" type="text" placeholder="Nombre de Usuario" class="form-control">
            </div>
            <div class="form-group">
              <input required autocomplete="off" v-model="namePass" name="userPass" type="password" placeholder="Ingresa tu Contraseña" class="form-control">
            </div>
            <div class="input-group">
              <button type="submit" class="btn btn-block btn-primary">
                Ingresar
              </button>
            </div>
          </div>
          <div v-show="isError" class="card-footer">
            <div class="alert alert-danger">
              <strong>{{msgError}}</strong>
            </div>
          </div>
        </form>
      </div>
      <!-- TITULO DEL SISTEMA -->
      <div class="col-md-7 d-none d-lg-block p-5 bg-dark text-center text-white rounded">
        <p class="display-2">Inventario Productos</i> </p>
      </div>
    </div>
  </div>
</div>

<script src="/public/js/fontawesone.js"></script>
<script src="/public/js/jquery.js"></script>
<script src="/public/js/axios.js"></script>
<script src="/public/js/vue.js"></script>
<script src="/public/js/main.js"></script>
<?php include_once '../views/partials/footer.php' ?>