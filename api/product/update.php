<?php

require_once '../../models/Product.php';

if ($_POST) {

  $name = $_POST['name'];
  $id = $_POST['id'];
  $produt = new Product;
  $produt->changeName($id, $name);
}
