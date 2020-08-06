<?php
require_once '../../config/Connection.php';
require_once '../../utilities/validate_string.php';
require_once '../../utilities/print_response.php';
require_once '../../utilities/sessions.php';

class User extends Connection
{

  public function __construct()
  {
  }

  public function login(String $username, String $password)
  {
    $name = cleanString($username);
    $password = cleanString($password);

    if (!$name || !$password) {
      printResJson(404, 'No se han recibidos datos validos.');
      return;
    }

    parent::getConnection();
    $ps = $this->link->prepare("SELECT id_user,fullname , username, user_pass, now() AS date_log, role, state AS status FROM users_system 
          WHERE username = :nu");
    $ps->bindParam(':nu', $name, PDO::PARAM_STR);
    $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $user = $ps->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $user['user_pass'])) {

      if ($user['status'] == 0) {
        printResJson(403, "Usuario deshabilitado");
        return;
      }
      $data = ['redirect' => '/'];
      createSession($user);
      printResJson(200, 'Verificacion correcta', $data);
      return;
    }
    printResJson(404, 'Datos de acceso invalidos');
  }

  public function new($doc, $fullname, $username, $password, $role)
  {

    $cedula = cleanString($doc);
    $completed_name = cleanString($fullname);
    $name_user = cleanString($username);
    $pass_secret = cleanString($password);
    $priviligies = cleanString($role);
    $hash = password_hash($pass_secret, PASSWORD_BCRYPT);

    parent::getConnection();
    $ps = $this->link->prepare("INSERT INTO users_system SET identification = :doc,fullname = :completed,
      username = :name_user, user_pass = :pass, role = :priviligies
    ");

    $ps->bindParam(":doc", $cedula, PDO::PARAM_STR);
    $ps->bindParam(":completed", $completed_name, PDO::PARAM_STR);
    $ps->bindParam(":name_user", $name_user, PDO::PARAM_STR);
    $ps->bindParam(":pass", $hash, PDO::PARAM_STR);
    $ps->bindParam(":priviligies", $priviligies, PDO::PARAM_STR);
    $rs = $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs
      ? printResJson(200, "Registro Exitoso")
      : printResJson(500, "Ha ocurrido un error");
  }

  public function update($id, $doc, $fullname, $username, $password, $role)
  {

    $cedula = cleanString($doc);
    $completed_name = cleanString($fullname);
    $name_user = cleanString($username);
    $pass_secret = cleanString($password);
    $priviligies = cleanString($role);
    $id_user = $id;
    $hash = password_hash($pass_secret, PASSWORD_BCRYPT);

    parent::getConnection();
    $ps = $this->link->prepare("UPDATE users_system SET identification = :doc,fullname = :completed,
      username = :name_user, user_pass = :pass, role = :priviligies WHERE id_user = :id LIMIT 1
    ");

    $ps->bindParam(":doc", $cedula, PDO::PARAM_STR);
    $ps->bindParam(":completed", $completed_name, PDO::PARAM_STR);
    $ps->bindParam(":name_user", $name_user, PDO::PARAM_STR);
    $ps->bindParam(":pass", $hash, PDO::PARAM_STR);
    $ps->bindParam(":priviligies", $priviligies, PDO::PARAM_STR);
    $ps->bindParam(":id", $id_user, PDO::PARAM_INT);
    $rs = $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs
      ? printResJson(200, "Actualización Exitosa")
      : printResJson(500, "Ha ocurrido un error");
  }

  public function changeState($id)
  {

    $id_user = $id;
    parent::getConnection();
    $ps = $this->link->prepare("UPDATE users_system SET state = !state WHERE id_user = :id LIMIT 1
    ");

    $ps->bindParam(":id", $id_user, PDO::PARAM_INT);
    $rs = $ps->execute();
    parent::clearConnection();
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }

    $rs
      ? printResJson(200, "Cambio de estado exitoso")
      : printResJson(500, "Ha ocurrido un error, intente mas tarde");
  }

  public function get()
  {
    parent::getConnection();
    $ps = $this->link->prepare("SELECT id_user AS id,identification AS doc, fullname AS fname, username AS name,
     user_pass AS pass, role AS r, state AS status ,date_created AS created
     FROM users_system
    ");
    $ps->execute();
    parent::clearConnection();

    $ms =  $ps->errorInfo();
    if ($ms[1]) {

      getMessageCodeError($ms);
      return;
    }

    $rs = $ps->fetchAll(PDO::FETCH_ASSOC);
    if ($rs) {
      $data = [];
      $data = $rs;
      printResJson('200', 'ok', $data);
      return;
    }

    printResJson(404, "No se existen datos registrado");
  }
}
