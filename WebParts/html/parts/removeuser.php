<?php
//se script sert a supprimer un utilisateur donné par son iD
if(isset($_REQUEST)){
  $id = $_REQUEST['id'];
  $sql_remove_user = 'DELETE FROM utilisateurs WHERE ID=?';
  $prepared_remove_user = $db->prepare($sql_remove_user);
  $prepared_remove_user->execute(array($id));
  header('Location: index.php?path=manageAccounts');
}

?>
