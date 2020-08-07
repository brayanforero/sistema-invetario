<?php include_once '../views/partials/header.php' ?>
<!-- <?= password_hash("1234", PASSWORD_BCRYPT) ?> -->
<div id="app" class="h-100">
  <div class="container-fluid p-0">
    <!-- FILA -->
    <div class="row m-0 justify-content-center align-items-center">
      <!-- FORMULARIO DE LOGIN -->
      <div class="col-md-8 col-lg-5">
        <form id="formLogin" @submit.prevent="sendData" class="card rounded shadow-sm">
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
          <div class="card-footer bg-white border-0 d-none animate__animated animate__faster">
            <div class="alert alert-danger m-0">
              <strong>{{msgError}}</strong>
            </div>
          </div>
        </form>
      </div>
      <!-- TITULO DEL SISTEMA -->
      <div class="col-md-7 h-100 shadow-sm d-none d-lg-block p-0 bg-image">
        <!-- <p class="display-1 h-inherit bg-dark">Inventario Productos</i> </p>
       -->
        <div class="w-100 h-100 bg-alpha text-center">
          <p class="display-4 text-white m-0 w-100 h-100 d-flex justify-content-center align-items-center">Inventario de Genericos</p>
        </div>
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