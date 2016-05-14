<?php
//cette page affiche les derniers articles
$sql_get_article = 'SELECT * FROM article WHERE statue=? ORDER BY ID DESC';
$prepared_get_article = $db->prepare($sql_get_article);
$prepared_get_article->execute(array('1'));
$ListArticles = $prepared_get_article->fetchAll(PDO::FETCH_OBJ);


// fonction pour l affichage de temps en format ago
function ago($i){
    $m = time()-$i; $o='Maintenat';
    $t = array('Anné'=>31556926,'mois'=>2629744,'semaine'=>604800,
'Jour'=>86400,'heur'=>3600,'minute'=>60,'seconde'=>1);
    foreach($t as $u=>$s){
        if($s<=$m){$v=floor($m/$s); $o="Il y'a "."$v $u".($v==1?'':'s'); break;}
    }
    return $o;
}




?>
<div class="home">

   <div class="ArticlesShow">
<?php foreach($ListArticles as $article){ ?>

      <article class="uniart">
		  <h3><a href="index.php?path=article&id=<?php echo $article->ID;?>" target="_blank"><?php echo $article->titre; ?></a><span style="font-weigh:100;font-size:10px;"> <?php echo "  ".ago( strtotime ( $article->date_creation )); ?></span></h3>
      <h4>
      <?php $sql_get_author = 'SELECT * FROM utilisateurs WHERE ID=?';
        $prepared_get_author = $db->prepare($sql_get_author);
        $prepared_get_author->execute(array($article->ID_auteur));
        $author = $prepared_get_author->fetchAll(PDO::FETCH_OBJ);
        foreach($author as $Auth){
          echo "Par ". $Auth->nom . " " . $Auth->prenom;
        }?>
      </h4>
      <p><?php echo substr($article->contenu,0,30)."..."; ?></p>
      </article>

    <?php } ?>
   </div>
</div>
