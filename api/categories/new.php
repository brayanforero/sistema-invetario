<?php
require_once '../../models/Category.php';

if ($_POST) {
  $name = $_POST['name'];
  $id_user = $_POST['id_user'];
  $c = new Category;
  $c->new($id_user, $name);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
