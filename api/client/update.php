<?php require_once '../../models/Client.php';

if ($_POST) {

  $doc = $_POST['doc'];
  $new_name = $_POST['new_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $addr = $_POST['addr'];
  $addr = $_POST['addr'];
  $id_client = $_POST['id_client'];

  $client = new Client;
  $client->update($doc, $new_name, $email, $phone, $addr, $id_client);
  return;
}

echo json_encode([
  "status", 400,
  "msg" => "No se recibieron datos validos"
]);
