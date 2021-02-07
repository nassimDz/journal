<?php
//ce script sert a supprimer un article donné par son ID
if(isset($_REQUEST)){
  $id = $_REQUEST['id'];
  $sql_remove_article = 'DELETE FROM article WHERE ID=?';
  $prepared_remove_article = $db->prepare($sql_remove_article);
  $prepared_remove_article->execute(array($id));
  header('Location: index.php');
}

?>
