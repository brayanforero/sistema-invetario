<span id="id" class="d-none"><?= strtolower($_SESSION['access_system']['id']) ?></span>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <a class="navbar-brand" href="/">Sistema</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <!-- <li class="nav-item active">
        <a class="nav-link" href="/">Resumen <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="itemProvedor" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Almacen
        </a>
        <div class="dropdown-menu" aria-labelledby="itemProvedor">
          <a class="dropdown-item" href="#">Lista de Productos</a>
          <a class="dropdown-item" href="#">Lista de Categorias</a>
          <a class="dropdown-item" href="#">Registrar Nuevo Producto</a>
          <a class="dropdown-item" href="#">Registrar Categoria</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="itemProvedor" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Provedores
        </a>
        <div class="dropdown-menu" aria-labelledby="itemProvedor">
          <a class="dropdown-item" href="#"> Registrar Nuevo</a>
          <a class="dropdown-item" href="#">Consultar Información</a>
          <a class="dropdown-item" href="#">Lista Completa</a>
        </div>
      </li> -->


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="itemCliente" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Clientes
        </a>
        <div class="dropdown-menu" aria-labelledby="itemCliente">
          <a class="dropdown-item" href="/views/listall_client.php">Lista Completa</a>
          <a class="dropdown-item" href="/views/register_client.php"> Registrar Nuevo</a>
          <a class="dropdown-item" href="/views/search_client.php">Consultar Información Detallada</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/logout.php">Cerrar Sesíon</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-success text-capitalize" href="#">Hola <?= strtolower($_SESSION['access_system']['name']) ?></a>
      </li>
    </ul>
  </div>
</nav>