<?php include_once '../../models/User.php';

// sleep(5);
if ($_POST) {
  $username = $_POST['nameUser'];
  $pass = $_POST['namePass'];
  $user = new User();
  $user->login($username, $pass);
} else {

  echo json_encode([
    'status' => 404,
    "msg" => "Ha ocurrido un error."
  ]);
}
