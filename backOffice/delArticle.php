<?php 

session_start()
include('../config/config.php');
include('../lib/bdd.lib.php');


$vue = 'article.phtml';



try
{

/* 1 : Connexion au serveur de Base de Données */
    
   $dbh = connexionBdd();

 
/* 2 : Executer une requête */


   
// je vais chercher mon formulaire et l'injecter dans ma bdd
    if (array_key_exists('id',$_GET)){//on teste sur un des champs jamais sur submit
        
        $idArticle= $_GET['id'];
        
        
//fonction supprimer du dossier upload
        $sth1 = $dbh->prepare('SELECT a_image FROM `b_article` WHERE a_id =:idArticle');
        $sth1->bindValue(':idArticle', $idArticle);
        $sth1->execute();
        
        $result = $sth1->fetch(PDO::FETCH_ASSOC);
        $img = $result['a_image'];
        
        
        
        var_dump($img);
        if (file_exists(UPLOADS_DIR.$img)){
            unlink(UPLOADS_DIR.$img);
        }


        
        
//fonction supprimer de la bdd
     
        $sth2 = $dbh->prepare('DELETE FROM `b_article` WHERE a_id =:idArticle');
        $sth2->bindValue(':idArticle', $idArticle);
        $sth2->execute();
        
       
        
       header('Location:article.php');
    
            
    }








/* 4. Afficher ou traiter l'enregistrement */
  
}
catch(PDOException $e){
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('../backOffice/template/layout.phtml'); 

?>


