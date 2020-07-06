<?php
require_once '../utilities/sessions.php';
sessionExists();
// echo password_hash('1234', PASSWORD_BCRYPT);
include_once '../views/login.php';
