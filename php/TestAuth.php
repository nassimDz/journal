<?php
###################################
#ce petit code sert a vérifier si
#il y'a un utilisateur
#authentifé ou pas
###################################
session_start();
if(!isset($_SESSION['username'])){
  header('Location: login.php');
}

?>
