<?php

require_once '../../models/Product.php';

if ($_POST) {

  $id = $_POST['id'];
  $produt = new Product;
  $produt->delete($id);
}
