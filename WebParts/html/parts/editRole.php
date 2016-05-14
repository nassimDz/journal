<?php
if($_REQUEST['to']=="admin"){
  $id = $_REQUEST['id'];
  $sql_update_statue = 'UPDATE utilisateurs SET statut =? WHERE ID=?';
  $prepared_update_statue = $db->prepare($sql_update_statue);
  $prepared_update_statue->execute(array('admin',$id));
  header('Location: index.php?path=manageAccounts');
}



?>
