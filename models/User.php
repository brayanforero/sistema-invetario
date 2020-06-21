<?php 
require_once '../../config/Connection.php';
require_once '../../utilities/validate_string.php';
require_once '../../utilities/print_response.php';
require_once '../../utilities/sessions.php';

class User extends Connection{
  
  private $id_user;
  private $fullname;
  private $usename;
  private $password;
  private $role;

  public function __construct(){

  }

  public function login(String $username, String $password){
    $name = cleanString($username);
    $password = cleanString($password);

    if (!$name || !$password) {
      printResJson(404, 'No se han recibidos datos validos.');
      return ;
    }

    parent::getConnection();
    $ps = $this->link->prepare("SELECT id_user,fullname , username, user_pass, now() AS date_log, role FROM users_system 
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
      $data = ['redirect' => '/'];
      createSession($user);
      printResJson(200, 'Verificacion correcta', $data);
      return;
    }

    printResJson(404, 'Datos de acceso invalidos');
  }
}

