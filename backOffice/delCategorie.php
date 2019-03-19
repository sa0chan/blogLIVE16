<?php 

session_start();
if(!isset($_SESSION['connected']) || $_SESSION['connected'] !== true ){
header('Location:login.php');
exit();
    
}

include('../config/config.php');
include('../lib/bdd.lib.php');
include('../lib/app.lib.php');


$vue = 'article.phtml';



try
{

/* 1 : Connexion au serveur de Base de Données */
    
   $dbh = connexionBdd();

 
/* 2 : Executer une requête */


   
// je vais chercher mon formulaire et l'injecter dans ma bdd
    if (array_key_exists('id',$_GET)){//on teste sur un des champs jamais sur submit
        
        $idCategorie= $_GET['id'];
        
        

        
//fonction supprimer de la bdd
     
        $sth2 = $dbh->prepare('DELETE FROM `b_categorie` WHERE c_id =:idCategorie');
        $sth2->bindValue(':idCategorie', $idCategorie);
        $sth2->execute();
        
       addFlashBag('La catégorie a bien été supprimée');
        
       header('Location:categorie.php');
    
            
    }




/* 4. Afficher ou traiter l'enregistrement */
  
}
catch(PDOException $e){
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('../backOffice/template/layout.phtml'); 

?>


