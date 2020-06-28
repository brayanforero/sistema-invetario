<?php
require_once '../../models/Providers.php';
if ($_POST) {

  $doc = $_POST['doc_provider'];
  $new_name = $_POST['new_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $addr = $_POST['addr'];
  $prv_id = $_POST['prv_id'];
  $provider = new Provider;
  $provider->update($doc, $new_name, $email, $phone, $addr, $prv_id);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
