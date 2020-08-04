<?php
require_once '../../models/Providers.php';

if (isset($_GET) && isset($_GET['id'])) {

  $id = $_GET['id'];
  $provider = new Provider;
  $provider->delete($id);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
