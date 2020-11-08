<?php require_once './utilities/sessions.php';
if (!verifySessionBackup()) {
  echo "No tienes los permisos para realizar esta accion";
  exit();
}

if ($_SESSION['access_system']['role'] === 'ADMIN') {
  $db_host = "localhost"; 
  $db_port = "3306"; 
  $db_name = "inventario_francisco"; 
  $db_user = "root"; 
  $db_pass = "root123*";
  $output_sql = 'databackup_'.date("Ymd-His").'.sql';
  $dump = "mysqldump -h".$db_host.' -u'.$db_user.' -p'.$db_pass.' --opt '.$db_name.' > ./backups/'.$output_sql;
  system($dump, $output);
  header("location: /backups/". $output_sql);
  exit();
}

echo "No tienes los permisos para realizar esta accion";

