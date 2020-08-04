<?php
require_once '../../models/User.php';

if (isset($_GET)) {

  $user = new User;
  $user->get();
}
