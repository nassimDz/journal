<?php
###############################################
# ce  fichier contien le code essentiel pour
# asusré une connexion sécurisé avec la BDD
###############################################
require('settings.php');

try {
  $db = new PDO("mysql:host={$dbConfig['hostname']};dbname={$dbConfig['dbname']}",$dbConfig['username'],$dbConfig['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
  echo 'Exception -> '.$e->getMessage();

}



?>
