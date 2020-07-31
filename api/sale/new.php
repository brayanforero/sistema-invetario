<?php

require_once '../../models/Sale.php';

if ($_POST) {

  $user = $_POST['user'];
  $client = $_POST['client'];
  $product = $_POST['product'];
  $count = $_POST['count'];
  $price_sale = $_POST['price_sale'];

  $sale = new Sale;
  $sale->new($user, $client, $product, $count, $price_sale);
}
