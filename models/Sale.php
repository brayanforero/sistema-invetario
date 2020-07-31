<?php

require_once '../../config/Connection.php';
require_once '../../utilities/validate_string.php';
require_once '../../utilities/print_response.php';

class Sale extends Connection
{

  public function __construct()
  {
  }

  public function new($user, $client, $product, $quanty, $priceUnitary)
  {

    $user_id = $user;
    $client_id = $client;
    $product_id = $product;
    $product_count = $quanty;
    $price_unitary = floatval(($priceUnitary));
    // $total_sale = floatval(cleanString($totalSale));

    // verificar si hay stock suficiente
    parent::getConnection();
    $ps = $this->link->prepare("SELECT count AS stock FROM products WHERE id_product = :id ");
    $ps->bindParam(':id', $product_id, PDO::PARAM_STR);

    $rs = $ps->execute();
    $currentStock = $ps->fetch(PDO::FETCH_ASSOC)['stock'];
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }
    if ($currentStock < $product_count) {
      printResJson(500, "Venta no procesada, cantidad insuficiente: {$currentStock}");
      return;
    }

    // proceso de venta
    try {
      parent::getConnection();
      $this->link->beginTransaction();
      $newStock = $currentStock - $product_count;
      $update_stock = $this->link->prepare("UPDATE products SET count = :pc WHERE id_product = :id");
      $update_stock->bindParam(":pc", $newStock, PDO::PARAM_INT);
      $update_stock->bindParam(":id", $product_id, PDO::PARAM_INT);
      $update_stock->execute();

      $ps = $this->link->prepare("
      INSERT INTO  sales SET id_user = :user, id_client = :client, id_product = :product,
      price_sale = :ps, quantity = :q, mount_sale = price_sale * quantity");
      $ps->bindParam(':user', $user_id, PDO::PARAM_INT);
      $ps->bindParam(':client', $client_id, PDO::PARAM_INT);
      $ps->bindParam(':product', $product_id, PDO::PARAM_INT);
      $ps->bindParam(':ps', $price_unitary, PDO::PARAM_STR);
      $ps->bindParam(':q', $product_count, PDO::PARAM_INT);
      $ps->execute();
      $this->link->commit();
      parent::clearConnection();
      printResJson(200, 'Venta procesada con exito');
    } catch (Exception $e) {
      printResJson(500, "Venta no procesada, por favor intente mas tarde");
      return;
      $this->link->rollBack();
    }
  }
}
