<?php

require_once '../../models/Product.php';

if ($_POST['stock']) {

  $product = new Product;
  $product->updateStock($_POST['id'],$_POST['stock']);

}
