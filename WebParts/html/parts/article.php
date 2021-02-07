<?php

//cette page affiche un article, selon son identificateur, on le récupère depuis la BDD et on l'affiche
if(isset($_REQUEST)){
  $id = $_REQUEST['id'];
  $sql_get_article = "SELECT *, date_format(date_creation,'%d %M %Y a %H:%i') AS date_publication FROM article WHERE `article`.`ID`=?";
  $prepared_get_article = $db->prepare($sql_get_article);
  $prepared_get_article->execute(array($id));
  $Article = $prepared_get_article->fetchAll(PDO::FETCH_OBJ);


}

//cette partie sert a ajouter les commentaires pour l'article courant
if(!empty($_POST)){
  extract($_POST);
  $sql_insert_com = 'INSERT INTO commentaires (ID_utilisateur,ID_article,contenu_com,date_commentaire) VALUES (?,?,?,?)';
  $prepared_sql_comment = $db->prepare($sql_insert_com);
  $prepared_sql_comment->execute(array($_SESSION['user_id'],$idA,nl2br(traitement($comment)),date('y-m-d h:i:s')));
  header('Location: index.php?path=article&id='.$idA);
}
?>
<div class="Article">
  <!--ici on affiche notre article récupéré depuis la BDD avec ses informations-->
  <?php foreach($Article as $article){ ?>
   <p><a href="index.php?path=article&amp;id=<?php echo $article->ID;?>" target="_blank"><?php echo $article->titre; ?></a>  <span style="font-weight:bold;font-size:15px;"> </span><p>
   <?php $sql_get_author = 'SELECT * FROM utilisateurs WHERE ID=?';
   $prepared_get_author = $db->prepare($sql_get_author);
   $prepared_get_author->execute(array($article->ID_auteur));
   $author = $prepared_get_author->fetchAll(PDO::FETCH_OBJ);
   foreach($author as $Auth){
    
    ?><span style="font-style:italic;font-size:14px;font-weight:bold;color:#CC2B46;"><?php echo "article publié le  ". $article->date_publication.' par '.$Auth->nom . " " . $Auth->prenom;?></span></p><?php
   } ?>
   <p><?php echo $article->contenu ?></p>
   <!--ici, on va a la page qui nous affiche tous les articles de l'auteur qui a écrit cet article -->
   <a href="index.php?path=authorArticles&amp;id=<?php echo $Auth->ID ?>"> cliquez ici pour lire d'autres articles ecrits par  : <?php echo $Auth->nom . " " . $Auth->prenom; ?></a>
   <hr>

   <!-- ici on va afficher les commentaires de l'article courant-->
   <h4>Commentaires</h4>
   <?php
   $sql_get_comments = "SELECT *, DATE_FORMAT(date_commentaire, '%d %M %Y a %H:%i') AS date_comm FROM commentaires WHERE ID_article=?";
   $prepared_get_comment = $db->prepare($sql_get_comments);
   $prepared_get_comment->execute(array($article->ID));
   $ListComments = $prepared_get_comment->fetchAll(PDO::FETCH_OBJ);
   ?>
  <?php foreach ($ListComments as $comment): ?>
    <?php
    $sql_get_author = 'SELECT * FROM utilisateurs WHERE ID=?';
    $prepared_get_author = $db->prepare($sql_get_author);
    $prepared_get_author->execute(array($comment->ID_utilisateur));
    $author = $prepared_get_author->fetchAll(PDO::FETCH_OBJ);
    foreach($author as $Auth){?>


    <div class="Comment">
         <h4>Auteur : <?php echo $Auth->nom . " " . $Auth->prenom.'<br>'.
          'Date: '.$comment->date_comm;?></h4> 
         <p><?php echo $comment->contenu_com; ?></p>
    </div>
<?php } ?>
  <?php endforeach; ?>

    <?php } ?>
    <!--on peut publier un commentaire si et seulement si on est connécté, la fonction isAuthenticated vérifie si on est connecté ou pas, si oui, on affiche le formulaire de publication de commentaire, si non on affiche que les commantaires-->
    <?php if(isAuthenticated()){ ?>
   <div class="commentForm">
     <form class="" action="index.php?path=article" method="post">
      <textarea name="comment" rows="8" cols="40" required></textarea>
      <input type="text" name="idA" hidden value="<?php echo $id; ?>">
      <input type="submit" value="Ajouter commentaire">
     </form>
   </div>
   <?php } ?>
</div>

<!--dans cette partie, on affiche d'autres articles aléatoirement-->
<div class="Ramdom">
  <h4>Lisez aussi : </h4>
<?php

$sql = 'SELECT * from article ORDER BY RAND() LIMIT 20';
$prep = $db->prepare($sql);
$prep->execute();
$arts = $prep->fetchAll(PDO::FETCH_OBJ);
foreach($arts as $article){
  echo "<a href=index.php?path=article&id=".$article->ID.">".$article->titre."</a>"."<br>";
}
 ?>
</div>



