<?php
require_once '../../models/Sale.php';
if (isset($_GET)) {
  $sale = new Sale;
  $sale->get();
  return;
}
echo json_encode([
  "status" => 500,
  "msg" => "No se pudo completar su solicitud"
]);
