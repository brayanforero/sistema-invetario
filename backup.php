<?php require_once './utilities/sessions.php';

if (!verifySessionBackup()) {
  echo "no estas autorizado para realizar esta accion";
  return;
}

$db_host = "localhost"; 
$db_port = "3306"; 
$db_name = "inventario_francisco"; 
$db_user = "root"; 
$db_pass = "root123*";
$output_sql = 'databackup_'.date("Ymd-His").'.sql';
$dump = "mysqldump -h".$db_host.' -u'.$db_user.' -p'.$db_pass.' --opt '.$db_name.' > ./backups/'.$output_sql;
system($dump, $output);
$zip = new ZipArchive();
$output_zip = './backups/.databackup_'.date("Ymd-His").'.zip';
if($zip->open($output_zip, ZIPARCHIVE::CREATE)){
  
  $zip->addFile('./backups/'.$output_sql);
  $zip->close();
  unlink($output_sql);
  header("location: ". $output_zip);
  echo "Respaldo generado con exito";
  exit();
}

echo 'No se pudo completar su respaldo';
exit();