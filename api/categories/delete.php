<?php
require_once '../../models/Category.php';

if ($_POST) {

  $id = $_POST['id'];
  $c = new Category;
  $c->delete($id);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
