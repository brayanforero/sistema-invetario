<?php
require_once '../../config/Connection.php';
require_once '../../utilities/validate_string.php';
require_once '../../utilities/print_response.php';
class Product extends Connection
{

  public function __construct()
  {
  }

  public function new($id_provider, $id_user, $brand, $name, $price_shoping, $price_sale)
  {
    $provider = $id_provider;
    $user = $id_user;
    $name_b = $brand;
    $pr_name = $name;
    $pr_shop = $price_shoping;
    $pr_sa = $price_sale;

    parent::getConnection();
    $ps = $this->link->prepare("INSERT INTO products SET id_user = :user, id_provider = :provider,
      brand = :brand, product_name = :name, shop_price = :shop, sale_price = :sale
    ");

    $ps->bindParam(":user", $user, PDO::PARAM_INT);
    $ps->bindParam(":provider", $provider, PDO::PARAM_INT);
    $ps->bindParam(":brand", $name_b, PDO::PARAM_STR);
    $ps->bindParam(":name", $pr_name, PDO::PARAM_STR);
    $ps->bindParam(":shop", $pr_shop, PDO::PARAM_STR);
    $ps->bindParam(":sale", $pr_sa, PDO::PARAM_STR);
    $rs = $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();

    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs
      ? printResJson(200, "Registro exitoso")
      : printResJson(500, "No se pudo completar la operacion");
  }

  public function update($id_provider, $id_user, $brand, $name, $price_shoping, $price_sale, $id_prod)
  {
    $provider = $id_provider;
    $user = $id_user;
    $name_b = cleanString($brand);
    $pr_name = cleanString($name);
    $pr_shop = floatval($price_shoping);
    $pr_sa = floatval($price_sale);
    $id_pr = $id_prod;

    parent::getConnection();
    $ps = $this->link->prepare("UPDATE products SET id_user = :user, id_provider = :provider,
      brand = :brand, product_name = :name, shop_price = :shop, sale_price = :sale
      WHERE id_product = :id LIMIT 1
    ");

    $ps->bindParam(":user", $user, PDO::PARAM_INT);
    $ps->bindParam(":provider", $provider, PDO::PARAM_INT);
    $ps->bindParam(":brand", $name_b, PDO::PARAM_STR);
    $ps->bindParam(":name", $pr_name, PDO::PARAM_STR);
    $ps->bindParam(":shop", $pr_shop, PDO::PARAM_STR);
    $ps->bindParam(":sale", $pr_sa, PDO::PARAM_STR);
    $ps->bindParam(":id", $id_pr, PDO::PARAM_INT);
    $rs = $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();

    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs
      ? printResJson(200, "Actualización exitosa")
      : printResJson(500, "No se pudo completar la operacion");
  }

  public function delete($id)
  {

    $id_pr = $id;
    parent::getConnection();
    $ps = $this->link->prepare("UPDATE products SET state = 0
      WHERE id_product = :id LIMIT 1
    ");

    $ps->bindParam(":id", $id_pr, PDO::PARAM_INT);
    $rs = $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();

    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs
      ? printResJson(200, "Eliminacion exitosa")
      : printResJson(500, "No se pudo completar la operacion");
  }

  public function get()
  {
    parent::getConnection();
    $ps = $this->link->prepare("SELECT 	prod.id_product, us.fullname AS user, prv.fullname AS provider,
      prod.brand, prod.product_name, prod.shop_price, prod.sale_price
      FROM products AS prod, users_system AS us, providers AS prv
      WHERE prod.id_user = us.id_user AND prod.id_provider = prv.id_provider
    ");
    $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs = $ps->fetch(PDO::FETCH_ASSOC);
    if ($rs) {
      $data = [];
      $data = $rs;

      printResJson(200, "ok", $data);
      return;
    }

    printResJson(404, "No se existen datos registrados");
  }
}
