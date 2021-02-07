<?php
///si le fprmulaire est bien rempli, on insert la catégorie dans la BDD
if(!empty($_POST)){
  extract($_POST);
  $sql_insert_cat = 'INSERT INTO categories(cat_label) VALUES(?)';
  $prepared_sql_insert_cat = $db->prepare($sql_insert_cat);
  $prepared_sql_insert_cat->execute(array($catName));
  header('Location: index.php?path=manageCats');
}
?><div class="SignUp">
  <form action="index.php?path=AddCategory" method="post">
    <label for="nom">Nom de la catégorie</label>
    <input type="text" name="catName" placeholder="Nom de la catégorie"><br><br>
    <br><input type="submit" value="Ajouter">
  </form>
</div>
