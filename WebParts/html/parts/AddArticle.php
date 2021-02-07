<?php

//procédure d'ajout d'un article
include ('email.php');

#1- on récupère toutes les catégories depuis la BDD pour remplir notre liste déroulante du choix d'article
$sql_get_cats = 'SELECT * FROM categories';
$prepared_get_cats = $db->prepare($sql_get_cats);
$prepared_get_cats->execute();
$Categories = $prepared_get_cats->fetchAll(PDO::FETCH_OBJ);

#2-insertion dans la BDD si le formulaire est bien rempli
if(!empty($_POST)){
  extract($_POST);
  $user_id = $_SESSION['user_id'];
  $sql_insert_article = 'INSERT INTO article(ID_auteur,titre,contenu,date_creation,statue,id_cat) VALUES(?,?,?,?,?,?)';
  $prepared_sql_insert_article = $db->prepare($sql_insert_article);
  $prepared_sql_insert_article->execute(array($user_id,traitement($title),traitement($content),date('Y-m-d h:i:s'),'0',$Category));
  sendEmail("nassim.hadjarab@gmail.com", "A new article has been posted", "new article");

  header('Location: index.php?path=profil');
}
?>
<div class="SignUp">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

     <label for="nom">Titre de l'article</label>
     <input type="text" name="title" id="nom" placeholder="Titre" required>

     <label for="Categorie ">Catégorie de l'article</label>
     <select name="Category" id="Categorie">
      <!-- ici on remplit notre liste déroulante -->
      <?php foreach($Categories as $caterory){ ?>
       <option value="<?php echo $caterory->id_cat ?>"><?php echo $caterory->cat_label; ?></option>
       <?php } ?>
     </select>

     <label for="contenu">Contenu</label>
     <textarea name="content" id="contenu" rows="8" cols="40" placeholder="contenu de l'article" required></textarea><br><br>
     <input type="submit" value="Publier">
 </form>
</div>
