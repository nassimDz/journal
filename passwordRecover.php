<?php
//on met la fonction session_start pour pouvoir utiliser les différentes variables des sessions
session_start();

//on fait l'insclution du fichier init.php qui sert a chargé les différents fichier de configuration de l'applicaion
require('php/init.php');
if(!empty($_POST)){ // si le formulaire est bien remlit,
   extract($_POST); //on fait une extraction de tout les informations du formulaire, au lieu d'utilisé la méthode classique $variable = $_POST['name'], on utilise la fonction extract pour facilité le travail, le name de l'input sera lui mème la variable

     $sql_get_pass = 'SELECT * FROM utilisateurs WHERE mail=?';
     $prepared = $db->prepare($sql_get_pass);
     $prepared->execute(array($mail));
     $Passwords = $prepared->fetchAll(PDO::FETCH_OBJ);
     $num = $prepared->rowCount();
     if($num==0){
       $errorMail = "Email Introuvable ! ";
     }
     else{
       foreach($Passwords as $pass){
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
         $mail->addAddress($mail);
         $mail->Subject = "Votre Mot de passe";
         $mail->Body ="Votre mot de pass est  :".decrypt($pass->password)." .";
         $mail->send();
       }
     }

            //redirection vers la page principale
  	     		header('location:index.php');

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

                  if(isset($errorMail)){
                      echo $errorMail;
                  }

              ?>
    </div>
    <div class="LoginFormContainer">
            <div class="FormTitle">
                 <h1>Recuperer votre Mot de passe</h1>
            </div>
            <div class="FormContent">
                  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                       <label for="user_mail">Votre Email</label>
                       <input type="text" name="mail" placeholder="Vote Email">
                       <br><input type="submit" value="Récuperer">
                  </form>
            </div>
    </div>
  </body>
</html>
