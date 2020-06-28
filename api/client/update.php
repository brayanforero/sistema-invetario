<?php require_once '../../models/Client.php';

$cliente = new Client;
$cliente->update("v-26401959", "brayan forero", "bf@gmail.com",
  "1234", "Av luis hurtado huguera", 1);
