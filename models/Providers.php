<?php 
require_once '../../config/Connection.php';
require_once '../../utilities/validate_string.php';
require_once '../../utilities/print_response.php';

class Provider extends Connection{
  
  private $id_provider;
  private $user;
  private $identification;
  private $fullname;
  private $email;
  private $phone_number;
  private $address;
  private $state;
  private $date_created;
  private $las_date_updated;

  public function __construct(){
    // echo password_hash('1234', PASSWORD_BCRYPT);
  }

  public function new($identi, $fullname, $email, $phone, $address, $user) {
    $user_id = $user;
    $doc = cleanString($identi);
    $fname = cleanString($fullname);
    $mail =cleanStringEmail($email);
    $n_phone = cleanString($phone);
    $addrs = cleanString($address);

    parent::getConnection();
    $ps = $this->link->prepare("INSERT INTO  providers 
      SET id_user = :user, identification = :doc, fullname = :fname, email = :mail,
      phone_number = :phone, address = :addrs");
    $ps->bindParam(':user', $user, PDO::PARAM_INT);
    $ps->bindParam(':doc', $doc, PDO::PARAM_STR);
    $ps->bindParam(':fname', $fname, PDO::PARAM_STR);
    $ps->bindParam(':mail', $mail, PDO::PARAM_STR);
    $ps->bindParam(':phone', $n_phone, PDO::PARAM_STR);
    $ps->bindParam(':addrs', $addrs, PDO::PARAM_STR);
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

  public function get(){

    parent::getConnection();
    $ps = $this->link->prepare("SELECT 
      P.identification AS doc, P.fullname AS name,P.email,
      P.phone_number , P.address, U.fullname AS user
      FROM providers AS P, users_system AS U 
      WHERE P.id_user = U.id_user  AND P.state = 1
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
    if($rs) {
      $data = [];
      $data = $rs;
      printResJson('200','ok', $data);
      return;
    }
    // POR DEFECTO SI NO HAY DATOS GUARDADOS-
    printResJson('404',  'No existen datos registrados');
  }

  public function getId($doc){

    $d = cleanString($doc);
    parent::getConnection();
    $ps = $this->link->prepare("SELECT 
      P.identification AS doc, P.fullname AS name,P.email,
      P.phone_number , P.address, U.fullname AS user
      FROM providers AS P, users_system AS U 
      WHERE P.id_user = U.id_user  AND P.state = 1 AND P.identification = :doc
    ");
    $ps->bindParam(':doc', $d, PDO::PARAM_STR);
    $ps->execute();
    parent::clearConnection();
    
    $ms = $ps->errorInfo();
    if ($ms[1]) {
      getMessageCodeError($ms);
      return;
    }
    
    $rs = $ps->fetchAll(PDO::FETCH_ASSOC);
    // SI SE ENCUENTRAN DATOS SE ENVIAN A LA VISTA.
    if($rs) {
      $data = [];
      $data = $rs;
      printResJson('200','ok', $data);
      return;
    }
    // POR DEFECTO SI NO HAY DATOS GUARDADOS-
    printResJson('404',  'No existen datos registrados');
  }

}