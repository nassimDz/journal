<?php
//cette page sert a modifier une catégorie donnée
// d'abord, on récupère la catégorie depuis la BDD en utilisant son identificateur
if(isset($_REQUEST)){
  $id = $_REQUEST['id'];
  $sql_get_cat = 'SELECT * FROM categories where id_cat =?';
  $prep_get_cat = $db->prepare($sql_get_cat);
  $prep_get_cat->execute(array($id));
  $Categories = $prep_get_cat->fetchAll(PDO::FETCH_OBJ);
}



//aprés avoir rempli le formulaire de modif, on fait la modif au niveau de la BDD
if(!empty($_POST)){
  extract($_POST);
  $sql_insert_cat = 'UPDATE categories set cat_label=? WHERE id_cat =?';
  $prepared_sql_insert_cat = $db->prepare($sql_insert_cat);
  $prepared_sql_insert_cat->execute(array($catName,$CatId));
  header('Location: index.php?path=manageCats');
}
?><div class="SignUp">
  <!-- ici on affiche la catégorie dans le formulaire du modif-->
  <?php foreach($Categories as $category){ ?>
  <form action="index.php?path=EditCat" method="post">
    <label for="nom">Nom de la catégorie</label>
    <input type="text" name="catName" placeholder="Nom de la catégorie" value="<?php echo $category->cat_label; ?>"><br><br>
    <input type="text" name="CatId" value="<?php echo $category->id_cat; ?>" hidden>
    <br><input type="submit" value="Modifier">
  </form>
  <?php } ?>
</div>
