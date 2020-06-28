<?php
require_once '../../models/Providers.php';
if ($_POST) {

  $doc = $_POST['documento'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $addr = $_POST['addr'];
  $provider = $_POST['id'];

  $provider = new Provider;
  $provider->update($doc, $name, $email, $phone, $addr, $provider);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
