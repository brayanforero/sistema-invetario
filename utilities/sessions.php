<?php 
// CREA UNA NUEVA SESION CON EL USUARIO ENVIADO POR PARAMETRO
function createSession($user){
  
  session_start();
  $base = $user['id_user'].''.$user['date_log'];
  $token = password_hash($base,PASSWORD_BCRYPT);
  
  $_SESSION['access_system'] = [
      'id' => $user['id_user'],
      'token' => $token,
      'name' => $user['fullname'],
      'username' => $user['username'],
      'role' => $user['role']
  ];
}
// VERFICA SI HAY UNA SESSION ACTIVA PARA QUE NO VUEVA AL LOGIN
function verifySession(){
  session_start();
  if ( empty($_SESSION) || empty($_SESSION['access_system']) ) {
    deleteSession();
    redirect('/acceso');
    return;
  } 
}
// VERFICA SI NO HAY UNA SESSION ACTIVA PARA SE LOGUEE
function sessionExists(){
  session_start();
  if ($_SESSION && $_SESSION['access_system']) {
    redirect('/');
  }
}
// ELIMINA LA SESION DEL USUARIO
function deleteSession(){
  session_start();
  $_SESSION = array();
  if ( ini_get("session.use_cookies") ) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }
  session_destroy();
  redirect('/acceso');
}

// REDIRIGE HACIA EL PATH QUE SE LE ENVIA POR PARAMETRO
function redirect($path){
  header("location: ".$path);
}