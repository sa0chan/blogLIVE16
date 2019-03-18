<?php 

session_start();
include('../config/config.php');
include('../lib/bdd.lib.php');


$vue = 'users.phtml';



try
{

/* 1 : Connexion au serveur de Base de Données */
    
   $dbh = connexionBdd();

 
/* 2 : Executer une requête */


   
// je vais chercher mon formulaire et l'injecter dans ma bdd
    if (array_key_exists('id',$_GET)){//on teste sur un des champs jamais sur submit
        
        $idUser= $_GET['id'];
        
        


        
        
//fonction supprimer de la bdd
     
        $sth2 = $dbh->prepare('DELETE FROM `b_user` WHERE u_id =:id');
        $sth2->bindValue(':id', $idUser);
        $sth2->execute();
        
       
        
       header('Location:users.php');
    
            
    }








/* 4. Afficher ou traiter l'enregistrement */
  
}
catch(PDOException $e){
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('../backOffice/template/layout.phtml'); 

?>


