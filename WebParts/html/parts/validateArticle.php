<?php
if(isset($_REQUEST)){
  $id = $_REQUEST['id'];
  $sql_validate_article = 'UPDATE article SET statue=? WHERE ID=?';
  $prepared_validate_article = $db->prepare($sql_validate_article);
  $prepared_validate_article->execute(array('1',$id));
  header('location: index.php?path=validateArticles');
}
?>
