<?php
#1- on récupère toutes les catégories depuis la BDD pour remplir notre liste déroulante du choix d'article
$sql_get_cats = 'SELECT * FROM categories';
$prepared_get_cats = $db->prepare($sql_get_cats);
$prepared_get_cats->execute();
$Categories = $prepared_get_cats->fetchAll(PDO::FETCH_OBJ);

//cette partie nous affiche tous les articles d'un auteur donné, par son identificateur, on récupère tous ses articles

$id = $_SESSION['user_id'];
$sql_get_articles = 'SELECT * FROM article WHERE ID_auteur=?';
$prepared_get_articles = $db->prepare($sql_get_articles);
$prepared_get_articles->execute(array($id));
$listArticles = $prepared_get_articles->fetchAll(PDO::FETCH_OBJ);


//cette page affiche le profil personel + possibilité de le modifier
$sql_get_profil = 'SELECT * FROM utilisateurs WHERE ID=?';
$prepared_get_profil = $db->prepare($sql_get_profil);
$prepared_get_profil->execute(array($_SESSION['user_id']));
$UserProfil = $prepared_get_profil->fetchAll(PDO::FETCH_OBJ);

?>
<div class="AddArticle" style="float:left;">
  <form action="index.php?path=AddArticle" method="post">
      <label for="nom">Titre de l'article</label>
      <input type="text" name="title" id="nom" placeholder="Titre" required>
     
      <label for="Categorie ">Catégorie de l'article</label>
      <select name="Category" id="Categorie">
        <!-- ici on remplit notre liste déroulante -->
        <?php foreach($Categories as $caterory){ print_r($category)?>
         <option value="<?php echo $caterory->id_cat ?>"><?php echo $caterory->cat_label; ?></option>
         <?php } ?>
      </select>
     
      <label for="contenu">Contenu</label>
      <textarea name="content" id="contenu" rows="8" cols="40" placeholder="contenu de l'article" required></textarea><br>
      <br><input type="submit" value="Publier">
  </form>
</div>

<div class="profil" style="color:#2C3E50; width:300px;height:600px; font-size:12px;float:right;">
<?php foreach ($UserProfil as $profil): ?>

    <h1>Nom Complet : </h1><?php echo $profil->nom." ".$profil->prenom; ?>
    <h1>Date de naissance : </h1><?php echo $profil->date_de_naissance; ?>
    <h1>Email : </h1><?php echo $profil->mail; ?>
    <h1>Sexe : </h1><?php echo $profil->sexe;  ?>
    <h1>Type du compte : </h1><?php echo $profil->statut; ?><br><br><br>
    <a href="index.php?path=editProfil&amp;id=<?php echo $profil->ID; ?>"><input type="button"value="Modifier mes infos"></a>
<?php endforeach; ?>
</div>


<div class="AuthArticlesTable" >
  <table>
    <thead>
      <tr>
        <th>Date de publication</th>
        <th>Auteur</th>
        <th>Titre</th>
        <th>Catégorie</th>
        <th>Statut</th>
        <th>Contenu</th>
        <th>Opération</th>
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
         <td> <a href="index.php?path=article&amp;id=<?php echo $article->ID; ?>" target="_blank"><?php echo $article->titre; ?></a></td>
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
         <td><?php if($article->statue =='0'){echo "En Attente de validation";}else{echo "Validé";} ?></td>
         <td><?php echo $article->contenu; ?></td>
         <td><a href="index.php?path=EditArticle&amp;id=<?php echo $article->ID; ?>">Modifier</a> /
             <a href="index.php?path=RemoveArticle&amp;id=<?php echo $article->ID; ?>">Supprimer </a></td>
       </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
