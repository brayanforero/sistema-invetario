<?php

require_once '../../models/Sale.php';
if (isset($_GET) && isset($_GET['id'])) {

  $sale = new Sale;
  $sale->delete($_GET['id']);
}
