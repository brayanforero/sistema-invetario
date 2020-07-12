<?php
require_once '../../models/Providers.php';

if (isset($_POST)) {

  $doc = $_POST['doc'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $addr = $_POST['addr'];
  $id_user = $_POST['id_user'];

  $provider = new Provider;
  $provider->new($doc, $name, $email, $phone, $addr, $id_user);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
