<?php require_once '../../models/Client.php';

if (isset($_GET['document'])) {
  $doc = $_GET['document'];
  $cliente = new Client;
  $cliente->getId($doc);
  return;
}
$cliente = new Client;
$cliente->get();
