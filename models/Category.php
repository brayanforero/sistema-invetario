<?php
require_once '../../config/Connection.php';
require_once '../../utilities/validate_string.php';
require_once '../../utilities/print_response.php';

class Category extends Connection
{

  public function __construct()
  {
  }

  public function new($id, $name)
  {

    $user_id = $id;
    $n = cleanString($name);

    parent::getConnection();
    $ps = $this->link->prepare("INSERT INTO  categories 
      SET id_user = :user, name_category = :name");
    $ps->bindParam(':user', $user_id, PDO::PARAM_INT);
    $ps->bindParam(':name', $n, PDO::PARAM_STR);
    $rs = $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    // ENVIA MENSAJE EN CASO DE SE GUARDE O NO LOS DATOS.
    $rs ? printResJson(200, 'Registro existoso')
      : printResJson(500, 'Ha ocurrido');
  }

  public function get()
  {
    parent::getConnection();
    $ps = $this->link->prepare("SELECT 
      CT.id_category AS id, CT.name_category AS name,
      CT.date_created, CT.last_date_update, U.fullname AS user
      FROM categories AS CT, users_system AS U 
      WHERE CT.id_user = U.id_user  AND CT.state = 1
    ");
    $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }
    $rs = $ps->fetchAll(PDO::FETCH_ASSOC);
    // SI SE ENCUENTRAN DATOS SE ENVIAN A LA VISTA.
    if ($rs) {
      $data = [];
      $data = $rs;
      printResJson('200', 'ok', $data);
      return;
    }
    // POR DEFECTO SI NO HAY DATOS GUARDADOS-
    printResJson('404',  'No existen datos registrados');
  }

  public function delete($id)
  {
    $_id =  $id;
    parent::getConnection();
    $ps = $this->link->prepare("UPDATE categories SET state = false WHERE id_category = :id LIMIT 1");
    $ps->bindParam(':id', $_id, PDO::PARAM_INT);
    $rs = $ps->execute();
    parent::clearConnection();

    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs ? printResJson(200, 'Eliminacion exitosa')
      : printResJson(404, 'Ha ocurrido');
  }

  public function update($id, $newName)
  {
    $c_id = $id;
    $n = cleanString($newName);

    parent::getConnection();
    $ps = $this->link->prepare("UPDATE categories 
      SET name_category = :name WHERE id_category = :id LIMIT 1");
    $ps->bindParam(':name', $n, PDO::PARAM_STR);
    $ps->bindParam(':id', $c_id, PDO::PARAM_INT);
    $rs = $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    // ENVIA MENSAJE EN CASO DE SE GUARDE O NO LOS DATOS.
    $rs ? printResJson(200, 'Actualizacion exitosa')
      : printResJson(500, 'Ha ocurrido');
  }
}
