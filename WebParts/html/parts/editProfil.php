<?php
//cette page sert a modifier le profil personnel
//1- on récupère le profil actuel de l'utilisateur connecté
if(isset($_REQUEST)){
  $id = $_REQUEST['id'];
  $sql_get_infos = 'SELECT * FROM utilisateurs WHERE ID=?';
  $prepared_get_profil = $db->prepare($sql_get_infos);
  $prepared_get_profil->execute(array($id));
  $Infos = $prepared_get_profil->fetchAll(PDO::FETCH_OBJ);
}

//aprés avoir modifer les infos, on met a jours dans la BDD
if(!empty($_POST)){
  extract($_POST);
  //initialisation des variables bouléens des erreurs
  $GlobalError = false;       // cette variable pour voir si y'a une erreur dans l'inscription ou pas,
  $ErrorMail = false;         // cette variable pour les erreurs dans l'email
  $ErrorPasswordMatch = false; // cette erreur pour la confirmation du mot de passe

  if(!isMatched($password,$confirm_password)){
     $GlobalError = true; // il y'a une erreur dans le processus d'inscripption
     $ErrorPasswordMatch = true;
     $ErrorPasswordMatchMessage = "les deux mot de passes ne sont pas identiques ! ";
  }
  //insertion dans la BDD

    if(!$GlobalError){ // on vérifie d'abbord si y'a pas d'erreur, et tout les données sont validés
       $sql_insert_user = "UPDATE utilisateurs SET nom=?,prenom=?,sexe=?,mail=?,password=?,date_de_naissance=? WHERE ID=?";
       $prepared_insert_user = $db->prepare($sql_insert_user);
       $prepared_insert_user->execute(array($nom,$prenom,$sexe,$mail,md5($password),$date_naiss,$_SESSION['user_id']));
       header('Location: index.php?path=profil');
    }

  //redirection
}

?>
<div class="SignUp">
  <div class="Errors" style="color:red">
   <?php if(isset($GlobalError)){
     echo "Une erreur est survenu lors votre inscription, veuillez corrigé les erreurs suivantes : "."<br>";
     if(isset($ErrorMail)){
       echo $ErrorMailMessage."<br>";
     }
     if(isset($ErrorPasswordMatch)){
       echo $ErrorPasswordMatchMessage."<br>";
     }
   } ?>
  </div>
<!--on affiche les infos dans le formulaire de modif-->
  <?php foreach ($Infos as $info): ?>


<form action="index.php?path=editProfil" method="post">
  <label for="nom">Nom</label>
  <input type="text" name="nom" placeholder="Votre Nom" value="<?php echo $info->nom; ?>">

  <label for="nom">Prénom</label>
  <input type="text" name="prenom" placeholder="Votre Prénom" value="<?php echo $info->prenom; ?>">

  <label for="nom">Date de naissance</label>
  <input type="text" name="date_naiss" placeholder="Date de naissance" value="<?php echo $info->date_de_naissance; ?>">
  <label for="sexe">Sexe</label>
   <select name="sexe">
    <option value="masculine">masculine</option>
    <option value="féminin">féminin</option>
   </select>
  <label for="nom">Email</label>
  <input type="text" name="mail" placeholder="Email" value="<?php echo $info->mail; ?>">

  <label for="nom">Mot de passe</label>
  <input type="password" name="password" placeholder="Mot de passe">

  <label for="nom">Confirmer le mot de passe</label>
  <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe"><br>
    <br><input type="submit" value="Enregistrer">
</form>
<?php endforeach; ?>
</div>
