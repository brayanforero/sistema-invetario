<?php
require_once '../../models/Providers.php';

if ($_POST) {

  $id = $_POST['id'];
  $provider = new Provider;
  $provider->delete($id);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
