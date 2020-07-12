<span id="id" class="d-none"><?= strtolower($_SESSION['access_system']['id']) ?></span>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <a class="navbar-brand" href="/">Inventarios de Productos <i class="fas fa-apple-alt h3 m-0 text-secondary"></i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <!-- <li class="nav-item active">
        <a class="nav-link" href="/">Resumen <span class="sr-only">(current)</span></a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link text-info" href="/"> <i class="fas fa-cart-plus h5 m-0"></i> Nueva Venta!</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/"> <i class="fas fa-search-dollar h5 m-0"></i> Ventas</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="itemProvedor" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-truck-loading h5 m-0"></i> Almacen
        </a>
        <!-- <div class="dropdown-menu" aria-labelledby="itemProvedor">
          <a class="dropdown-item" href="#">Lista de Productos</a>
          <a class="dropdown-item" href="#">Lista de Categorias</a>
          <a class="dropdown-item" href="#">Registrar Nuevo Producto</a>
          <a class="dropdown-item" href="#">Registrar Categoria</a>
        </div> -->
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="itemProvedor" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-truck h5 m-0"></i> Provedores
        </a>
        <div class="dropdown-menu" aria-labelledby="itemProvedor">
          <a class="dropdown-item" href="/views/listall_provider.php">Lista Completa </i></a>
          <a class="dropdown-item" href="/views/register_provider.php"> Registrar Nuevo</a>
          <a class="dropdown-item" href="/views/search_provider.php">Consultar Información Detallada </a>
        </div>
      </li>


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="itemCliente" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-users h5 m-0"></i> Clientes
        </a>
        <div class="dropdown-menu" aria-labelledby="itemCliente">
          <a class="dropdown-item" href="/views/listall_client.php">Lista Completa </i></a>
          <a class="dropdown-item" href="/views/register_client.php"> Registrar Nuevo</a>
          <a class="dropdown-item" href="/views/search_client.php">Consultar Información Detallada </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-success text-capitalize" id="itemUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-user h5 m-0"></i> <?= strtolower($_SESSION['access_system']['name']) ?> </a>
        <div class="dropdown-menu" aria-labelledby="itemUser">
          <a class="nav-link" href="/logout.php">Cerrar Sesíon</a>
        </div>
      </li>
    </ul>
  </div>
</nav>