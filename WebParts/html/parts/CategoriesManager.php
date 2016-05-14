<?php
//cette page sert a gérer les catégories dans le site

//on fait d'abbord le teste si un utilisateur est authentifié, en mème temps qu'il a le bon droit d'accedé a cette page

//la fonction idAdmin vérifie que si l'utilisateur connecté est un admin
if(!isAuthenticated() || !isAdmin()){
  header('Location: login.php');
}

//on récupère tout les catégories depuis la BDD
$sql_get_cats = 'select * from categories';
$prepared_get_cats = $db->prepare($sql_get_cats);
$prepared_get_cats->execute();
$listCats = $prepared_get_cats->fetchAll(PDO::FETCH_OBJ);
?><div class="ArticlesTable">
  <a href="index.php?path=AddCategory"><input type="button" value="Ajouter"></a><br><br>
  <table>
    <thead>
      <tr>
        <th>Nom de catégorie</th>
        <th>Nombre d'articles</th>
        <th>Opérations</th>
       </tr>
     </thead>
     <tbody>
       <?php foreach($listCats as $cat){ ?>
       <tr>
         <td><?php echo $cat->cat_label; ?></td>
         <td><?php
        $sql_get_num = 'SELECT * FROM article WHERE id_cat=?';
        $prepared_get_num = $db->prepare($sql_get_num);
        $prepared_get_num->execute(array($cat->id_cat));
        $num = $prepared_get_num->rowCount();
        echo $num;

        ?>
        </td>
         <td><a href="index.php?path=EditCat&id=<?php echo $cat->id_cat; ?>">Modifier</a> /
             <a href="index.php?path=RemoveCat&id=<?php echo $cat->id_cat; ?>">Supprimer </a></td>
       </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
