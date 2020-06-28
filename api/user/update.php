<?php
require_once '../../models/User.php';

if ($_POST) {
  $id =  $_POST['id'];
  $doc = $_POST['documento'];
  $fullname = $_POST['fullName'];
  $username = $_POST['userName'];
  $password = $_POST['userPass'];
  $role = $_POST['role'];
  $user = new User;
  $user->update($id, $doc, $fullname, $username, $password, $role);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se han recibidos datos Validos"
]);
