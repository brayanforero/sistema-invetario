<?php
require_once '../../config/Connection.php';
require_once '../../utilities/validate_string.php';
require_once '../../utilities/print_response.php';
class Product extends Connection
{

  public function __construct()
  {
  }

  public function new($id_provider, $id_user, $cat, $name, $count, $price_shoping, $price_sale)
  {
    $user = $id_user;
    $provider = $id_provider;
    $category = $cat;
    $name_p = cleanString($name);
    $cont = cleanString($count);
    $pr_shop = cleanString($price_shoping);
    $pr_sa = cleanString($price_sale);

    parent::getConnection();
    $ps = $this->link->prepare("INSERT INTO products SET id_user = :user, id_provider = :provider,
      id_category = :category, product_name = :name,count = :con, shop_price = :shop, sale_price = :sale
    ");

    $ps->bindParam(":user", $user, PDO::PARAM_INT);
    $ps->bindParam(":provider", $provider, PDO::PARAM_INT);
    $ps->bindParam(":category", $category, PDO::PARAM_INT);
    $ps->bindParam(":name", $name_p, PDO::PARAM_STR);
    $ps->bindParam(":con", $cont, PDO::PARAM_STR);
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
    $ps = $this->link->prepare("SELECT 	prod.id_product AS id, us.fullname AS user, 
      prv.fullname AS provider, cat.name_category AS category ,prod.product_name AS name, prod.count AS stock, prod.shop_price AS p_shop, prod.sale_price AS p_sale
      FROM products AS prod, users_system AS us, providers AS prv, categories AS cat
      WHERE prod.id_user = us.id_user AND prod.id_provider = prv.id_provider AND prod.id_category = cat.id_category 
    ");
    $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs = $ps->fetchAll(PDO::FETCH_ASSOC);
    if ($rs) {
      $data = [];
      $data = $rs;

      printResJson(200, "ok", $data);
      return;
    }

    printResJson(404, "No se existen datos registrados");
  }

  public function getByStock()
  {
    parent::getConnection();
    $ps = $this->link->prepare("SELECT 	prod.id_product AS id, us.fullname AS user, 
      prv.fullname AS provider, cat.name_category AS category ,prod.product_name AS name, prod.count AS stock, prod.shop_price AS p_shop, prod.sale_price AS p_sale
      FROM products AS prod, users_system AS us, providers AS prv, categories AS cat
      WHERE prod.id_user = us.id_user AND prod.id_provider = prv.id_provider AND prod.id_category = cat.id_category AND prod.count > 0
    ");
    $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs = $ps->fetchAll(PDO::FETCH_ASSOC);
    if ($rs) {
      $data = [];
      $data = $rs;

      printResJson(200, "ok", $data);
      return;
    }

    printResJson(404, "No se existen datos registrados");
  }
}
