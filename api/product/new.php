<?php

require_once '../../models/Product.php';

if (isset($_POST)) {

  $user = $_POST['id_user'];
  $prv = $_POST['provider'];
  $name = $_POST['name'];
  $count = $_POST['count'];
  $price_sp = $_POST['price_sp'];
  $price_sl = $_POST['price_sl'];

  $product = new Product;
  $product->new($prv, $user, $name, $count, $price_sp, $price_sl);
  return;
}
echo json_encode([
  "status" => 404,
  "msg" => "No se recibieron datos validos"
]);
