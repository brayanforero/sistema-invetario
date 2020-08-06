<?php
require_once '../../models/User.php';

if (isset($_POST)) {
  $id =  $_POST['id'];

  $user = new User;
  $user->changeState($id);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se han recibidos datos Validos"
]);
