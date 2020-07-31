<?php

require_once '../../models/Product.php';

if (isset($_GET)) {
  if ($_GET['filter'] == "stock") {
    $prod = new Product;
    $prod->getByStock();
    return;
  }
  $prod = new Product;
  $prod->get();
}
