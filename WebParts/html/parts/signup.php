<?php

include ('email.php');

if(!empty($_POST)){
    extract($_POST);
    //initialisation des variables bouléennes des erreurs
    $GlobalError = false;       // cette variable pour voir si il y a une erreur dans l'inscription ou pas,
    $ErrorMail = false;         // cette variable pour les erreurs dans l'email
    $ErrorPasswordMatch = false; // cette erreur pour la confirmation du mot de passe


    //processus de validation des données

    //1- valider l'email
    if(Exist($mail)){
        $GlobalError = true; // il y a une erreur dans le processus d'inscription
        $ErrorMail = true; // l'erreur se trouve au niveau de l'email , qui est déja utilisé ou bien n'est pas valide
        $ErrorMailMessage = "Désolé ! l'email que vous avez entré n'est pas valide, ou bien il est déjà utilisé ! ";
    }


    //2- valider le nom d'utilisateur

    if(!isMatched($password,$confirm_password)){
        $GlobalError = true; // il y'a une erreur dans le processus d'inscription
        $ErrorPasswordMatch = true;
        $ErrorPasswordMatchMessage = "les deux mots de passe ne sont pas identiques ! ";
    }
    //insertion dans la BDD


    if(!$GlobalError){ // on vérifie d'abord si y'a pas d'erreur, et toutes les données sont validées
        $sql_insert_user = "INSERT INTO utilisateurs (nom,prenom,sexe,mail,password,date_de_naissance,statut) VALUES (?,?,?,?,?,?,?)";
        $prepared_insert_user = $db->prepare($sql_insert_user);
        $prepared_insert_user->execute(array(traitement($nom),traitement($prenom),$sexe,$mail,sha1($password),$date_naiss,'Membre'));
        sendEmail($mail, "Inscription à ESGI news", "bonjour $nom \nNous vous remercions pour votre confiance\nESGI news");
        header('Location: index.php');
    }



    //redirection
}

?>
<div class="SignUp">
    <div class="Errors" style="color:red">
        <?php if(isset($GlobalError)){
            echo "Une erreur est survenue lors votre inscription, veuillez corriger les erreurs suivantes : "."<br>";
            if(@isset($ErrorMail)){
                echo $ErrorMailMessage."<br>";
            }
            if(@$ErrorPasswordMatch){
                echo $ErrorPasswordMatchMessage."<br>";
            }
        } ?>
    </div>
    <form action="index.php?path=signup" method="post">

        <label for="FamilyName">Nom</label>
        <input type="text" name="nom" id="FamilyName" placeholder="Votre nom"  required="">

        <label for="FirstName">Prenom</label>
        <input type="text" name="prenom" id="FirstName" placeholder="Votre prenom" required="">

        <label for="birthday">Date de naissance</label>
        <input type="date" name="date_naiss" id="birthday" placeholder="DD-MM-YYYY" required>

        <label for="sexe">Sexe</label>
        <select name="sexe" id="sexe">
            <option value="homme" checked>homme</option>
            <option value="femme">femme</option>
        </select>

        <label for="email">Email</label>
        <input type="text" name="mail" id="email" placeholder="Email" required>

        <label for="pass">Mot de passe</label>
        <input type="password" name="password" id="pass" placeholder="Mot de passe" required>

        <label for="pass2">Confirmer le mot de passe</label>
        <input type="password" name="confirm_password" id="pass2" placeholder="Confirmer le mot de passe" required><br><br>
        <input type="submit" value="Enregistrer">

    </form>
</div>
