<?php
//cette page fait al gestion des comptes, elle est accessible que par l'admin
if(!isAuthenticated() || !isAdmin()){
  header('Location: login.php');
}
$sql_get_users = 'select * from utilisateurs';
$prepared_get_users = $db->prepare($sql_get_users);
$prepared_get_users->execute();
$listUsers = $prepared_get_users->fetchAll(PDO::FETCH_OBJ);
?>
 <div class="ArticlesTable">
  <table>
    <thead>
      <tr>
        <th>Nom complet</th>
        <th>Date de naissance</th>
        <th>Email</th>
        <th>Sexe</th>
        <th>Statue</th>
        <th>Opérations</th>
       </tr>
     </thead>
     <tbody>
       <?php foreach($listUsers as $user){ ?>
       <tr>
         <td><?php echo $user->nom." ".$user->prenom;?></td>
         <td><?php echo $user->date_de_naissance; ?></td>
         <td><?php echo $user->mail; ?></td>
         <td><?php echo $user->sexe; ?></td>
         <td><?php echo $user->statut; ?></td>
         <td><?php if($user->statut !="admin"){ ?><a href="index.php?path=editRole&to=admin&id=<?php echo $user->ID; ?>">Affecter le role d'administrateur</a> / <?php } ?><a href="index.php?path=removeuser&id=<?php echo $user->ID; ?>">Supprimer</a></td>
       </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
