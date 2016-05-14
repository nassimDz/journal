<?php

//on récupère tout les catégories depuis la BDD
$sql_get_cats = 'select * from categories';
$prepared_get_cats = $db->prepare($sql_get_cats);
$prepared_get_cats->execute();
$listCats = $prepared_get_cats->fetchAll(PDO::FETCH_OBJ);
?>
<div>
 
  
     <ul>
       <?php foreach($listCats as $cat){ ?>
       <li>
         <a href="index.php?path=articles&cat=<?php echo $cat->id_cat; ?>">Acceder les articles de la catégorie <?php echo $cat->cat_label; ?></a>
        <?php
        $sql_get_num = 'SELECT * FROM article WHERE id_cat=?';
        $prepared_get_num = $db->prepare($sql_get_num);
        $prepared_get_num->execute(array($cat->id_cat));
        $num = $prepared_get_num->rowCount();
        

        ?>
                
		 </li>
        <?php } ?>
	</ul>
    
</div>
