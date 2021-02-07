<?php
//se script sert a supprimer une catégorie  donnée par son ID avec tous les articles qui appartiennent a cette catégorie
if(isset($_REQUEST)){
  $id = $_REQUEST['id'];
  $sql_rem_cat = 'DELETE FROM categories WHERE id_cat=?';
  $sql_rem_articles = 'DELETE FROM article WHERE id_cat=?';
  $prep = $db->prepare($sql_rem_cat);
  $prep1 = $db->prepare($sql_rem_articles);

  $prep->execute(array($id));
  $prep1->execute(array($id));
  header('Location: index.php?path=manageCats');
}


?>
