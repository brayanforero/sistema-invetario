<?php require_once '../../models/Client.php';

if (isset($_POST)) {

  $doc = $_POST['doc'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $addr = $_POST['addr'];
  $id_user = $_POST['id_user'];

  $client = new Client;
  $client->new($doc, $name, $email, $phone, $addr, $id_user);
  return;
}

echo json_encode([
  "status", 400,
  "msg" => "No se recibieron datos validos"
]);
