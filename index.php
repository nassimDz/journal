<?php
//on met la fonction session_start pour pouvoir utiliser les différentes variables des sessions
session_start();

//on fait l'inclusion du fichier init.php qui sert a charger les différents fichiers de configuration de l'application
require('php/init.php');
?>
<!DOCTYPE html>
<html>
  <head>

    <link rel="stylesheet" href="css/master.css">
    <meta charset="utf-8">
    <title>ESGI cloud</title>
  </head>
  <body>
  <div class="Container">
     <div class="Header">
          <?php
           //ici on va charger le menu principal

             if(isset($_SESSION['username'])){
               if($_SESSION['Role']=="Membre"){
               include('WebParts/html/menus/menu_authenticated.php'); // si l'utilisateur authenfié est un membre, on charge le menu du membre
             }

             else{
               include('WebParts/html/menus/menu_admin.php'); // si l'utilisateur authenfié est un admin, on charge le menu de l'admin
             }
             }

             else{
               include('WebParts/html/menus/menu_unauthenticated.php');// si il y a pas d'utilisateur authentifié, on charge le menu standard pour tous les utilisateurs
                          }
           ?>
     </div><!--Header-->
          
               

     <div class="MainContent">

       <!-- cette partie sert a charger les différentes pages du corps du site en utilisant la variable path -->
       <?php

       //on a utilisé une variable nommée path pour définir les différents chemins et liens dans l'application
       if(isset($_REQUEST['path'])){
         $path = $_REQUEST['path'];
         switch ($path) {
           //si path=articles , on appelle la page qui affiche tous les articles dans le site
           case 'articles':
             include('WebParts/html/parts/articles.php');
             break;

             //si path=Myarticles , on appelle la page qui affiche les articles du l'auteur connecté ( si un auteur veut consulter ses articles)
             case 'Myarticles':
             include('WebParts/html/parts/Myarticles.php');
             break;

             //si path=cats, on appelle a la page qui affiche les différentes catégories dans le site
             case 'cats':
             include('WebParts/html/parts/cats.php');
             break;

            //si path = signup, on appelle la page d'inscription
           case 'signup':
             include('WebParts/html/parts/signup.php');
             break;


          //si path=manageArticles, on appelle la page qui fait la gestion des articles
           case 'manageArticles':
             include('WebParts/html/parts/manageArticles.php');
             break;

            //si path=manageAccounts, on appelle la page qui sert a gérer les comptes
            case 'manageAccounts':
              include('WebParts/html/parts/manageAccounts.php');
              break;


          //si path=profil , on appelle la page qui affiche le profil personel de l'utilisateur connecté
            case 'profil':
              include('WebParts/html/parts/profil.php');
              break;

           //si path=AddArticle , on appelle la page qui sert a ajouter un nouvel article
            case 'AddArticle':
              include('WebParts/html/parts/AddArticle.php');
              break;

              //si path=EditArticle, on apelle la page qui sert a modifier un article existant
            case 'EditArticle':
              include('WebParts/html/parts/editArticle.php');
              break;

              //si path= editProfil, on appelle la page qui sert a faire des modifications des infos dans le profil
            case 'editProfil':
            include('WebParts/html/parts/editProfil.php');
            break;


            //si path=article, on appelle la page qui sert a afficher un article donné
            case 'article':
            include('WebParts/html/parts/article.php');
            break;


            //si path=validateArticle, on fait appelle au script qui valide un article, ( un article valide signifie qu'il est publié, si non il est en attente de validation et il n'est pas publié)
            case 'validateArticle':
            include('WebParts/html/parts/validateArticle.php');
            break;

            //si path=validateArticles, on appelle la page qui affiche les articles non validés
            case 'validateArticles':
            include('WebParts/html/parts/validateArticles.php');
            break;
            //si path=removeuser, on apelle le script qui sert a supprimer un utilisateur
            case 'removeuser':
            include('WebParts/html/parts/removeuser.php');
            break;


            //si path=RemoveArticle, on appelle le script qui sert a supprimer un article
            case'RemoveArticle':
            include('WebParts/html/parts/RemoveArticle.php');

            //si path=authorArticles, on appelle la page qui affiche les articles d"un auteur donné
            case'authorArticles':
            include('WebParts/html/parts/AuthorArticles.php');
            break;

            //si path=mannageCats, on appelle la page qui fait la gestion des catégories

            case 'manageCats':
            include('WebParts/html/parts/CategoriesManager.php');
            break;

            //si path = EditCat , on appelle la page qui sert a modifier une catégorie donnée
            case 'EditCat':
            include('WebParts/html/parts/EditCat.php');
            break;

            //si path = RemoveCat, on apelle le script qui sert a supprimer une catégorie donnée avec tous les articles de cette catégorie
            case 'RemoveCat':
            include('WebParts/html/parts/RemoveCat.php');
            break;

            //si path = AddCategory; on appelle la page qui sert a ajouter une nouvelle catégorie
            case 'AddCategory':
            include('WebParts/html/parts/AddCategory.php');
            break;

            case 'editRole':
              include('WebParts/html/parts/editRole.php');
              break;

            
            default: include('WebParts/html/parts/home.php');

            break;
         }


       }else{
         //si path est null , ou bien n'est pas définie, on affiche la page home.php, qui sert a afficher les derniers articles
         include('WebParts/html/parts/home.php');
       }


        ?>
      </div><!--MainContent-->
      
  </div><!--Container-->
	
	<footer>
	<?php include('WebParts/html/parts/footer.php'); ?>
  	</footer>


</body>
</html>
