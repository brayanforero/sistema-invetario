<?php
require_once '../../models/User.php';

if ($_POST) {
  $doc = $_POST['document'];
  $fullname = $_POST['fullName'];
  $username = $_POST['userName'];
  $password = $_POST['userPass'];
  $role = $_POST['role'];
  $user = new User;
  $user->new($doc, $fullname, $username, $password, $role);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se han recibidos datos Validos"
]);
