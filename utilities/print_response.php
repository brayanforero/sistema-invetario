<?php

// RETURNA UN JSON CON O SIN DATA PARA EL VISTA
function printResJson($code, $msg, $data = null)
{
  $res = [];
  if (!$data) {
    $res['status'] = $code;
    $res['msg'] = $msg;
  } else {
    $res['status'] = $code;
    $res['msg'] = $msg;
    $res['data'] = $data;
  }
  echo json_encode(
    $res
  );
}

// RETORNA EL MENSAJE PERSONALIDADO DE ERROR A LA VISTA
function getMessageCodeError($array)
{
  switch ($array[1]) {
    case 1062:
      printResJson(404, 'Error: Registro existente');
      break;
    case 1451:
      printResJson(404, 'Error: No se puede eliminar un registro que este asociado a otro.');
      break;
    default:
      printResJson(404, $array[2]);
      break;
  }
}
