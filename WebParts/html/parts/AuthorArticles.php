<?php
//cette page nous affiche tout les articles d'un auteur donnée, par son identificateur, on récupère tout ces articles
if(isset($_REQUEST)){
$id = $_REQUEST['id'];
$sql_get_articles = 'select * from article WHERE ID_auteur=? AND statue=?';
$prepared_get_articles = $db->prepare($sql_get_articles);
$prepared_get_articles->execute(array($id,'1'));
$listArticles = $prepared_get_articles->fetchAll(PDO::FETCH_OBJ);
}
?><div class="ArticlesTable">
  <table>
    <thead>
      <tr>
        <th>Date de publication</th>
        <th>Auteur</th>
        <th>Titre</th>
        <th>Catégorie</th>
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
         <td> <a href="index.php?path=article&id=<?php echo $article->ID; ?>" target="_blank"><?php echo $article->titre; ?></a></td>
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
       </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
