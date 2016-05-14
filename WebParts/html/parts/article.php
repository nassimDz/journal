<?php

function ago($i){
    $m = time()-$i; $o='Maintenant';
    $t = array('Anné'=>31556926,'mois'=>2629744,'semaine'=>604800,
'Jour'=>86400,'heur'=>3600,'minute'=>60,'seconde'=>1);
    foreach($t as $u=>$s){
        if($s<=$m){$v=floor($m/$s); $o="Il y'a "."$v $u".($v==1?'':'s'); break;}
    }
    return $o;
}


//cette page affiche un article, selon son identificateur, on le récupère depuis la BDD et on l'affiche
if(isset($_REQUEST)){
  $id = $_REQUEST['id'];
  $sql_get_article = 'SELECT * FROM article WHERE `article`.`ID`=?';
  $prepared_get_article = $db->prepare($sql_get_article);
  $prepared_get_article->execute(array($id));
  $Article = $prepared_get_article->fetchAll(PDO::FETCH_OBJ);


}

//cette partie sert a ajouter les commentaires pour l'article en courant
if(!empty($_POST)){
  extract($_POST);
  $sql_insert_com = 'INSERT INTO commentaires (ID_utilisateur,ID_article,contenu_com,date_commentaire) VALUES (?,?,?,?)';
  $prepared_sql_comment = $db->prepare($sql_insert_com);
  $prepared_sql_comment->execute(array($_SESSION['user_id'],$idA,$comment,date('y-m-d h:i:s')));
  header('Location: index.php?path=article&id='.$idA);
}
?>
<div class="Article">
  <!--ici on affiche notre article récupéré depuis la BDD avec ces informations-->
  <?php foreach($Article as $article){ ?>
   <h3><a href="index.php?path=article&id=<?php echo $article->ID;?>" target="_blank"><?php echo $article->titre; ?></a>  <span style="font-weigh:100;font-size:10px;"> <?php echo "  ".ago( strtotime ( $article->date_creation )); ?></span></h3>
   <h3><?php $sql_get_author = 'SELECT * FROM utilisateurs WHERE ID=?';
   $prepared_get_author = $db->prepare($sql_get_author);
   $prepared_get_author->execute(array($article->ID_auteur));
   $author = $prepared_get_author->fetchAll(PDO::FETCH_OBJ);
   foreach($author as $Auth){
     echo $Auth->nom . " " . $Auth->prenom;
   } ?></h3>
   <p><?php echo $article->contenu ?></p>
   <!--ici, on va a la page qui nous affiche tout les articles de l'auteur qui a écrit cet article -->
   <a href="index.php?path=authorArticles&id=<?php echo $Auth->ID ?>">Tous les articles du : <?php echo $Auth->nom . " " . $Auth->prenom; ?></a>
   <hr>

   <!-- ici on va affiché les commentaires de l'article en courant-->
   <h4>commmentaires</h4>
   <?php
   $sql_get_comments = 'SELECT * FROM commentaires WHERE ID_article=?';
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
         <h4>Auteur : <?php echo $Auth->nom . " " . $Auth->prenom; ?></h4>
         <p><?php echo $comment->contenu_com; ?></p>
    </div>
<?php } ?>
  <?php endforeach; ?>

    <?php } ?>
    <!--on peut publié un commentaire si est seulement si on est connécté, la fonction isAuthenticated vérifie si on est connecté ou pas, si oui, on affiche le formulaire de pblicaztion d commentaire, si non on affiche que les commantaires-->
    <?php if(isAuthenticated()){ ?>
   <div class="commentForm">
     <form class="" action="index.php?path=article" method="post">
      <textarea name="comment" rows="8" cols="40"></textarea>
      <input type="text" name="idA" hidden value="<?php echo $id; ?>">
      <input type="submit" value="Ajouter commentaire">
     </form>
   </div>
   <?php } ?>
</div>

<!--dans cette partie, on affiche d'autre articles alétoirement-->
<div class="Ramdom">
  <h4>Autre Articles : </h4>
<?php

$sql = 'SELECT * from article ORDER BY RAND()';
$prep = $db->prepare($sql);
$prep->execute();
$arts = $prep->fetchAll(PDO::FETCH_OBJ);
foreach($arts as $article){
  echo "<a href=index.php?path=article&id=".$article->ID.">".$article->titre."</a>"."<br>"."<br>";
}
 ?>
</div>
