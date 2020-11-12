<?php


require_once '../../models/Category.php';

if ($_POST) {
  $new_name = $_POST['name'];
  $id = $_POST['id'];
  $c = new Category;
  $c->update($id, $new_name);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
