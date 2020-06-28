<?php


require_once '../../models/Category.php';

if ($_POST) {
  $new_name = $_POST['new_name'];
  $n_categoria = $_POST['n_categoria'];
  $c = new Category;
  $c->update($n_categoria, $new_name);
  return;
}

echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
