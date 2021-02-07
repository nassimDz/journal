<?php
//on met la fonction session_start pour pouvoir utiliser les différentes variables des sessions
session_start();

//on fait l'insclution du fichier init.php qui sert a chargé les différents fichier de configuration de l'applicaion
require('php/init.php');
?><nav class="Header">
  <?php require('WebParts/html/menus/menu_unauthenticated.php');?>
</nav>
<?php
if(!empty($_POST)){ // si le formulaire est bien remlit,
  extract($_POST); //on fait une extraction de tout les informations du formulaire, au lieu d'utilisé la méthode classique $variable = $_POST['name'], on utilise la fonction extract pour facilité le travail, le name de l'input sera lui mème la variable
  //1- on vérifie d'abbord que le mail donnée existe dans la BDD
  $logged = true; // une variable pour voir si la procédure d'authentification est faite avec succée ou pas
  $user_test_sql = "SELECT * FROM utilisateurs WHERE mail=?"; // la requêtte pour récupérer l'utilisateur qui a le mail donnée
  $user_test = $db->prepare($user_test_sql); //on prépare notre requette pour qu'elle soit exécuté
  $user_test->execute(array($mail)); // on exécute notre requette, on injectant notre variables dans un tableau
  $num_res = $user_test->rowCount(); // on calcule le nombre de résultats retournés
  	     if ($num_res==0) { // 0 veux dire que aucun utilisateur n'est trouvé
           $logged = false;
  		     $errur_user = " L'email que vous avez entrée est introuvable ! essayé une autre fois ";
  	     }else{ //si on a trouvé un utilisateur
  	     	foreach ($user_test as $users) { // on vérifie le mot de passe introduit dans le formulaire avec cel qui est dans la BDD
  	     		$dbpass = $users['password'];
  	     		if (sha1($password) != $dbpass) { // si le mdp est incorrect
              $logged = false;
  	     			$errur_pass = "Mot de passe incorrecte !";
  	     		}
  	     	}
  	     }
  	     if ($logged) {
           //si tout marche bien, et l'utilisateur est bien authentifié
           //on crée des variables de session qui seront partagé dans tout les pages qui contiennts la fonction session_start
           //on va utilisé ces variables pour faire des testes si un utilisateur est connécté, si l'utilisateur est un admin ou pas .. etc
  	     	   $_SESSION['username'] = $mail;
  	         $user_role_sql = "SELECT * FROM utilisateurs WHERE mail=?";
  	         $user_role = $db->prepare($user_role_sql);
  	         $user_role->execute(array($mail));
  	         $roles = $user_role->fetchAll(PDO::FETCH_OBJ);
  	       	foreach ($roles as $roless) {
  	     		$role = $roless->statut;
  	     		$_SESSION['Role'] =$role;
  	     		$_SESSION['user_id'] =$roless->ID;
  	     	}
            //redirection vers la page principale
  	     		header('location:index.php');

  	     }

}





?><!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css/login.css">
    <meta charset="utf-8">
    <title>Authentification</title>
  </head>
  <body>
      <div class="Errors" style="color:red;position:absolute;top:90px;left:400px;">
       <?php
       if(isset($errur_user)){
           echo $errur_user;
       }
       if(isset($errur_pass)){
         echo $errur_pass;
     }        ?>
    </div>
    <div class="LoginFormContainer">
            <div class="FormTitle">
                 <h1>S'authentifier a votre compte</h1>
            </div>
            <div class="FormContent">
                  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                       <label for="user_mail">Votre Email</label>
                       <input type="text" name="mail" placeholder="Vote Email">
                       <label for="user_mail">Votre Mot de passe</label>
                       <input type="password" name="password" placeholder="Votre Mot de passe"><br>
                       <br><input type="submit" value="Connexion">
                  </form><br><br>
                  <a href="passwordRecover.php">Mot de passe perdu ?</a>
            </div>
    </div>
    <footer>
      <?php require('WebParts/html/parts/footer.php'); ?>
    </footer>
  </body>
</html>
