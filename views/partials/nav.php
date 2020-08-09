<span id="id" class="d-none"><?= strtolower($_SESSION['access_system']['id']) ?></span>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 pr-5">
  <a class="navbar-brand d-flex align-items-center" href="/"><i class="fas fa-box-open h2 m-0 text-secondary"></i>
    <span class="h6 m-0 ml-1">Inventario</span>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <!-- AGG VENTA -->
      <li class="nav-item">
        <a class="nav-link" href="/"> <i class="fas fa-cart-plus h5 m-0"></i> Nueva Venta!</a>
      </li>
      <!-- VENTAS -->
      <?php if ($_SESSION['access_system']['role'] === 'ADMIN') : ?>
        <li class="nav-item">
          <a class="nav-link" href="/views/listall_sales.php"> <i class="fas fa-search-dollar h5 m-0"></i> Ventas</a>
        </li>
      <?php endif; ?>
      <!-- ALMACEN -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="itemProductos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-truck-loading h5 m-0"></i> Almacen
        </a>
        <div class="dropdown-menu" aria-labelledby="itemProductos">
          <?php if ($_SESSION['access_system']['role'] === 'ADMIN') : ?>
            <a class="dropdown-item" href="/views/register_product.php">Registrar Nuevo Producto</a>
          <?php endif; ?>
          <!-- <a class="dropdown-item" href="#">Registrar Categoria</a> -->
          <a class="dropdown-item" href="/views/listall_product.php">Lista de Productos</a>
          <?php if ($_SESSION['access_system']['role'] === 'ADMIN') : ?>
            <a class="dropdown-item" href="/views/listall_category.php">Lista de Categorias</a>
          <?php endif; ?>
          <?php if ($_SESSION['access_system']['role'] === 'ADMIN') : ?>
            <a class="dropdown-item" href="/views/register_category.php">Agregar Categorias</a>
          <?php endif; ?>
        </div>
      </li>
      <!-- PROVEDORES -->
      <?php if ($_SESSION['access_system']['role'] === 'ADMIN') : ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="itemProvedor" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-truck h5 m-0"></i> Provedores
          </a>
          <div class="dropdown-menu" aria-labelledby="itemProvedor">
            <a class="dropdown-item" href="/views/listall_provider.php">Lista Completa </i></a>
            <a class="dropdown-item" href="/views/register_provider.php"> Registrar Nuevo</a>
          </div>
        </li>
      <?php endif; ?>

      <!-- CLIENTES -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="itemCliente" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-users h5 m-0"></i> Clientes
        </a>
        <div class="dropdown-menu" aria-labelledby="itemCliente">
          <?php if ($_SESSION['access_system']['role'] === 'ADMIN') : ?>
            <a class="dropdown-item" href="/views/listall_client.php">Lista Completa </i></a>
          <?php endif; ?>
          <a class="dropdown-item" href="/views/register_client.php"> Registrar Nuevo</a>
        </div>
      </li>
      <!-- USUARIOS -->
      <?php if ($_SESSION['access_system']['role'] === 'ADMIN') : ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="itemCliente" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-users h5 m-0"></i> Sistema
          </a>
          <div class="dropdown-menu" aria-labelledby="itemCliente">
            <a class="dropdown-item" href="/views/register_user.php"> Nuevo Usuario</a>
            <a class="dropdown-item" href="/views/listall_users.php"> Usuarios Registrados</a>
          </div>
        </li>
      <?php endif; ?>
      <!-- USUARIO -->
      <li class="nav-item dropdown">
        <!-- SI ES ADMINISTRADOR -->
        <?php if ($_SESSION['access_system']['role'] === 'ADMIN') : ?>
          <a class="nav-link dropdown-toggle text-primary text-capitalize" id="itemUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-user h5 m-0"></i> <?= strtolower($_SESSION['access_system']['name']) ?> </a>
          <!-- SI ES VENDEDOR -->
        <?php else : ?>
          <a class="nav-link dropdown-toggle text-success text-capitalize" id="itemUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-user h5 m-0"></i> <?= strtolower($_SESSION['access_system']['name']) ?> </a>
        <?php endif; ?>
        <div class="dropdown-menu" aria-labelledby="itemUser">
          <a class="nav-link" href="/logout.php">Cerrar Sesíon</a>
        </div>
      </li>
    </ul>
  </div>
</nav>