<?php

require_once '../../models/Product.php';

if (isset($_GET)) {
  if ($_GET['stock']) {
    $prod = new Product;
    $prod->getByStock();
  } else {
    $prod = new Product;
    $prod->get();
  }
}
