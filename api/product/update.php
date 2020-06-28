<?php

require_once '../../models/Product.php';

if ($_POST) {

  $user = $_POST['user'];
  $prv = $_POST['prv'];
  $brand = $_POST['brand'];
  $name = $_POST['name'];
  $price_sp = $_POST['price_sp'];
  $price_sl = $_POST['price_sl'];
  $id = $_POST['id'];
  $produt = new Product;
  $produt->update($prv, $user, $brand, $name, $price_sp, $price_sl, $id);
}
