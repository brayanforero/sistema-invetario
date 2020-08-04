<?php require_once '../../models/Client.php';

if (isset($_GET) && isset($_GET['id'])) {

  $id = $_GET['id'];
  $client = new Client;
  $client->delete($id);
  return;
}

echo json_encode([
  "status" => 400,
  "msg" => "No se recibieron datos validos"
]);
