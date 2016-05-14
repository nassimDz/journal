<?php
//procédure d'ajout d'un article

#1- on récupère tout les catégories depuis la BDD pour remplire notre liste déroulante du choix d'article
$sql_get_cats = 'SELECT * FROM categories';
$prepared_get_cats = $db->prepare($sql_get_cats);
$prepared_get_cats->execute();
$Categories = $prepared_get_cats->fetchAll(PDO::FETCH_OBJ);

#2-insertion dans la BDD si le formulaire est bien remplit
if(!empty($_POST)){
  extract($_POST);
  $user_id = $_SESSION['user_id'];
  $sql_insert_article = 'INSERT INTO article(ID_auteur,titre,contenu,date_creation,statue,id_cat) VALUES(?,?,?,?,?,?)';
  $prepared_sql_insert_article = $db->prepare($sql_insert_article);
  $prepared_sql_insert_article->execute(array($user_id,$title,$content,date('Y-m-d h:i:s'),'0',$Category));


if($_SESSION['Role']!="admin"){
  //envoyé l'email a l'admin
  //1- récupéré tout les emails des administrateurs
   $sql_get_admins = 'SELECT * FROM utilisateurs WHERE statut=?';
   $prepared_get_admins = $db->prepare($sql_get_admins);
   $prepared_get_admins->execute(array('admin'));
   $Mails = $prepared_get_admins->fetchAll(PDO::FETCH_OBJ);

   //2- parcourir tout les emails des admins, et pour chaqu'un d'eux, envoyé le mm email
   foreach($Mails as $admin){
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Port = 25;
    $mail->Username = 'testnewsnl@gmail.com';
    $mail->Password = 'AQW13579';
    $mail->SMTPSecure = 'tls';

    $mail->From = 'contact@localhost';
    $mail->FromName = 'Site d\'actualité';
    $mail->addAddress($admin->mail);
    $mail->Subject = "Un nouveau article a besoin de votre confirmation";
    $mail->Body ="Veuillez confirmer le nouveau article : ".$title."qui est ajouté réçament";
    $mail->send();
   }
}
  header('Location: index.php?path=profil');
}
?><div class="SignUp">
  <form action="index.php?path=AddArticle" method="post">
    <label for="nom">Titre de l'article</label>
    <input type="text" name="title" placeholder="Titre">
    <label for="Category">Catégorie de l'article</label>
    <select name="Category">
      <!-- ici on remplit notre liste déroulante -->
      <?php foreach($Categories as $caterory){ ?>
     <option value="<?php echo $caterory->id_cat ?>"><?php echo $caterory->cat_label; ?></option>
     <?php } ?>
    </select>
    <label for="nom">Contenu</label>
    <textarea name="content" rows="8" cols="40" placeholder="contenu de l'article"></textarea><br>
    <br><input type="submit" value="Publier">
  </form>
</div>
