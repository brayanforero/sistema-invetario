<?php require_once '../../models/Client.php';

if ($_POST) {

  $id_client = $_POST['id_client'];
  $cliente = new Client;
  $cliente->delete($id_client);
}

echo json_encode([
  "status" => 400,
  "msg" => "No se recibieron datos validos"
]);
