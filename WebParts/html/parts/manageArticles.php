<?php
//cette page fait al gestion des articless, elle est accessible que par l'admin

if(!isAuthenticated() || !isAdmin()){
  header('Location: login.php');
}
$sql_get_articles = 'select * from article';
$prepared_get_articles = $db->prepare($sql_get_articles);
$prepared_get_articles->execute();
$listArticles = $prepared_get_articles->fetchAll(PDO::FETCH_OBJ);

?>
 <div class="ArticlesTable">
  <table>
    <thead>
      <tr>
        <th>Date de publication</th>
        <th>Auteur</th>
        <th>Titre</th>
        <th>Catégorie</th>
        <th>Statue</th>
        <th>Opérations</th>
       </tr>
     </thead>
     <tbody>
       <?php foreach($listArticles as $article){ ?>
       <tr>
         <td><?php echo $article->date_creation; ?></td>
         <td><?php
        $sql_get_author = 'SELECT * FROM utilisateurs WHERE ID=?';
        $prepared_get_author = $db->prepare($sql_get_author);
        $prepared_get_author->execute(array($article->ID_auteur));
        $author = $prepared_get_author->fetchAll(PDO::FETCH_OBJ);
        foreach($author as $Auth){
          echo $Auth->nom . " " . $Auth->prenom;
        }?>
        </td>
         <td> <a href="index.php?path=article&id=<?php echo $article->ID; ?>" target="_blank"><?php echo $article->titre ?></a></td>
         <td>
           <?php
           $sql_get_cat = 'SELECT * FROM categories WHERE id_cat=?';
           $prepared_get_cat = $db->prepare($sql_get_cat);
           $prepared_get_cat->execute(array($article->id_cat));
           $Cat = $prepared_get_cat->fetchAll(PDO::FETCH_OBJ);
           foreach($Cat as $cat){
             echo $cat->cat_label;
           }
          ?>
         </td>
         <td><?php if ($article->statue =='1' ){echo "Publié";}else{echo "En Attente";}?></td>
         <td><a href="index.php?path=EditArticle&id=<?php echo $article->ID; ?>">Modifier</a> /
             <a href="index.php?path=RemoveArticle&id=<?php echo $article->ID; ?>">Supprimer </a>
             <?php if($article->statue =='0'){?><a href="index.php?path=validateArticle&id=<?php echo $article->ID ?>">/ Valider</a><?php } ?></td>
       </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
