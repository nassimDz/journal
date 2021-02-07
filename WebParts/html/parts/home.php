<?php
//cette page affiche les derniers articles


$sql_get_article = "SELECT *, date_format(date_creation,'%d %M %Y a %H:%i') AS date_publication FROM article WHERE statue=? ORDER BY ID DESC";
$prepared_get_article = $db->prepare($sql_get_article);
$prepared_get_article->execute(array('1'));
$ListArticles = $prepared_get_article->fetchAll(PDO::FETCH_OBJ);


?>
<div class="home">

   <div class="ArticlesShow">
<?php foreach($ListArticles as $article){ ?>

      <article class="uniart">
		  <h3><a href="index.php?path=article&amp;id=<?php echo $article->ID;?>"><?php echo $article->titre; ?></a><span style="font-size:10px;"></span></h3>
      <h4>
      <?php $sql_get_author = 'SELECT * FROM utilisateurs WHERE ID=?';
        $prepared_get_author = $db->prepare($sql_get_author);
        $prepared_get_author->execute(array($article->ID_auteur));
        $author = $prepared_get_author->fetchAll(PDO::FETCH_OBJ);
        foreach($author as $Auth){
          ?><p><span style="font-style:italic;font-size:14px;font-weight:bold;color:#CC2B46;"><?php echo "écrit par  ".$Auth->nom . " " . $Auth->prenom.' le'.$article->date_publication?></span></p><?php
        }?>
      </h4>
      <p><?php echo substr($article->contenu,0,450)."...";
       echo "<a href=index.php?path=article&amp;id=". $article->ID."  ;?>lire la suite</a>"  ?></p>
      
      </article>

    <?php } ?>

   </div>
</div>
