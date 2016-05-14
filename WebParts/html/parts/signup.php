<?php
if(!empty($_POST)){
  extract($_POST);
  //initialisation des variables bouléens des erreurs
  $GlobalError = false;       // cette variable pour voir si y'a une erreur dans l'inscription ou pas,
  $ErrorMail = false;         // cette variable pour les erreurs dans l'email
  $ErrorPasswordMatch = false; // cette erreur pour la confirmation du mot de passe


  //processur de validation des données

  //1- valider l'email
  if(Exist($mail)){
     $GlobalError = true; // il y'a une erreur dans le processus d'inscripption
     $ErrorMail = true; // l'erreur se trouve au niveau de l'email , qui est déja utilisé ou bien n'est pas valide
     $ErrorMailMessage = "Désolé ! l'email que vous avez entrer n'est pas valide, ou bien il est déjà utilisé ! ";
  }


  //2- valider le nom d'utilisateur

  if(!isMatched($password,$confirm_password)){
     $GlobalError = true; // il y'a une erreur dans le processus d'inscripption
     $ErrorPasswordMatch = true;
     $ErrorPasswordMatchMessage = "les deux mot de passes ne sont pas identiques ! ";
  }
  //insertion dans la BDD

    if(!$GlobalError){ // on vérifie d'abbord si y'a pas d'erreur, et tout les données sont validés
       $sql_insert_user = "INSERT INTO utilisateurs (nom,prenom,sexe,mail,password,date_de_naissance,statut) VALUES (?,?,?,?,?,?,?)";
       $prepared_insert_user = $db->prepare($sql_insert_user);
       $prepared_insert_user->execute(array($nom,$prenom,$sexe,$mail,encrypt($password),$date_naiss,'Membre'));
       header('Location: index.php');
    }

  //redirection
}

?>
<div class="SignUp">
  <div class="Errors" style="color:red">
   <?php if(isset($GlobalError)){
     echo "Une erreur est survenu lors votre inscription, veuillez corrigé les erreurs suivantes : "."<br>";
     if(@isset($ErrorMail)){
       echo $ErrorMailMessage."<br>";
     }
     if(@$ErrorPasswordMatch){
       echo $ErrorPasswordMatchMessage."<br>";
     }
   } ?>
  </div>
<form action="index.php?path=signup" method="post">
  <label for="nom">Nom</label>
  <input type="text" name="nom" placeholder="Votre Nom" required>

  <label for="nom">Prénom</label>
  <input type="text" name="prenom" placeholder="Votre Prénom" required>

  <label for="nom">Date de naissance</label>
  <input type="date" name="date_naiss" placeholder="DD-MM-YYYY" required>
  <label for="sexe">Sexe</label>
   <select name="sexe">
    <option value="masculine">masculine</option>
    <option value="féminin">féminin</option>
   </select>
  <label for="nom">Email</label>
  <input type="text" name="mail" placeholder="Email" required>

  <label for="nom">Mot de passe</label>
  <input type="password" name="password" placeholder="Mot de passe" required>

  <label for="nom">Confirmer le mot de passe</label>
  <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required><br>
    <br><input type="submit" value="Enregistrer">
</form>
</div>
