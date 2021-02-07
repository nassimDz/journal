<?php
###############################################
# ce  fichier contient les fonctions essentielles
# pour le bon fonctionnement de l'application
###############################################
require('dbconnect.php');
require ('settings.php');


//cette fonction va vérifier si l'email respecte le format d'un email, aprés on vérifie s'il existe le même email dans la BDD, pour assurer l'unicité des mails
function CkechEmail($mail){

  if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
    return true; // si la fonction retourne true, donc l'email est valide et on peut l'utiliser
  }//end if
  else{
    return false;
  }
}//fin de la fonction

function Exist($mail){
  require('settings.php');

  try {
    $db = new PDO("mysql:host={$dbConfig['hostname']};dbname={$dbConfig['dbname']}",$dbConfig['username'],$dbConfig['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $e) {
    echo 'Exception -> '.$e->getMessage();

  }
  $sql_test_mail = 'SELECT * FROM utilisateurs WHERE mail=?';
  $prepared_query = $db->prepare($sql_test_mail);
  $prepared_query->execute(array($mail));
  $num_result = $prepared_query->rowCount();
  if($num_result > 0){
    return true;
  }else{
    return false;
  }
}
function isMatched($password1, $password2){
  if($password1 == $password2){
    return true; // si les 2 mots de passe sont identiques
  }
  else{
    return false; // si non
  }
}

function isAuthenticated(){ // cette fonction sert a vérifier qu'il existe un utilisateur authentifié
  if(!isset($_SESSION['username'])){
    return false;
  }
  else{
    return true;
  }
}


function isAdmin(){ // cette fonction sert a vérifier que l'utilisateur authentifié est un administrateur
  if($_SESSION['Role']!="admin"){
    return false;
  }
  else{
    return true;
  }
}

function traitement (&$champ){
  $champ=htmlspecialchars($champ);
  $champ=strip_tags($champ);
  return $champ;
}

?>

 