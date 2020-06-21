<?php

// LIMPIA LAS CADENAS DE TEXTO DE INYECCION SQL O HTML, 
// ESPACIOS EN BLANCO AL PRINCIO Y FINAL, TRANSFORMA A LETRAS MAYUSCULAS.
function cleanString($string){
  $newString = trim($string);
  $newString = htmlspecialchars($string);
  $newString = strtoupper($newString);
  $newString = strtoupper( filter_var($newString, FILTER_SANITIZE_STRING) );
  return $newString;
}

// EL MISMO CASO ANTERIOR, LA DIFERECIA ELIMINA CARACTERES NO VALIDOS EN EMAIL.
function cleanStringEmail($string){
  $newString = trim($string);
  $newString = htmlspecialchars($string);
  $newString = strtoupper($newString);
  $newString = strtoupper( filter_var($newString, FILTER_SANITIZE_EMAIL) );
  return $newString;
}