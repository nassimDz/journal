<?php
//cette page sert a modifier un article donné, par son identificateur, on le récupère depuis la BDD
//, on l'affiche dans le formulaire de modification

//on accède a cette page si et seulement si on est connecté
if(!isAuthenticated()){
  header('Location: login.php');
}

//on récupère l'article depuis la BDD
if(isset($_REQUEST)){
  $id = $_REQUEST['id'];
  $sql_get_article = 'SELECT * FROM article WHERE ID=?';
  $prepared_get_article = $db->prepare($sql_get_article);
  $prepared_get_article->execute(array($id));
  $Article = $prepared_get_article->fetchAll(PDO::FETCH_OBJ);
}


//aprés avoir modifié notre article, on fait les modifications au niveau de la BDD
if(!empty($_POST)){
  extract($_POST);
  $sql_update_article = 'UPDATE article SET titre=?, contenu=? WHERE ID=?';
  $prepared_update_article = $db->prepare($sql_update_article);
  $prepared_update_article->execute(array($title,$content,$idA));

  //redirection vers la page d'accueil
  header('Location: index.php');
}
?><div class="SignUp">
  <!-- ici on affiche l'article dans le formulaire de modification-->
  <?php foreach($Article as $article){ ?>
  <form action="index.php?path=EditArticle" method="post">
    <label for="nom">Titre de l'article</label>
    <input type="text" name="title" value="<?php echo $article->titre; ?>">
      <input type="text" name="idA" value="<?php echo $article->ID; ?>" hidden>
    <label for="nom">Contenu</label>
    <textarea name="content" rows="8" cols="40"  value=""><?php echo $article->contenu; ?></textarea><br>
    <br><input type="submit" value="Mettre à jour">
  </form>
  <?php  }?>
</div>
