<?php
require_once '../../models/Providers.php';

if (isset($_GET['document'])) {
  $doc = $_GET['document'];
  $provider = new Provider;
  $provider->getId($doc);
  return;
}
$provider = new Provider;
$provider->get();
