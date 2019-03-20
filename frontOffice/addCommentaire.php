<?php
/*session_start();
*/
include('../config/config.php');
include('../lib/bdd.lib.php');
include('../lib/app.lib.php');


$newCom  ='';
$newPseudo ='';
$idArticle = '';
$newMail ="";
$idArticle = $_POST['id']; 

//verification que le users a bien cliqué et mise des données dans variable


try
{
    
   

/* 1 : Connexion au serveur de Base de Données */
    
   $dbh = connexionBdd();

  
// je vais chercher mon formulaire et l'injecter dans ma bdd
    if (array_key_exists('id',$_POST)){//on teste sur un des champs jamais sur submit
        
        $idArticle = $_POST['id'];   
        $newCom = $_POST['commentaire'];
       
        $newPseudo = $_POST['pseudo'];

        $newMail = $_POST['mail'];

        $newDate = new DateTime();

       
    //fonction mettre dans bdd
     
        $sth2 = $dbh->prepare('INSERT INTO b_comment (c_article,c_contenu,c_date_publi,c_email,c_pseudo) VALUES (:idArticle,:com,:datePubli,:mail,:pseudo)');
        $sth2->bindValue(':idArticle', $idArticle, PDO::PARAM_INT);
        $sth2->bindValue(':com',$newCom, PDO::PARAM_STR);
        $sth2->bindValue(':pseudo',$newPseudo, PDO::PARAM_STR);
        $sth2->bindValue(':datePubli',$newDate->format('Y-m-d H:i:s'));
        $sth2->bindValue(':mail',$newMail, PDO::PARAM_STR);
        $sth2->execute();
    
        addFlashBag('Votre commentaire a bien été ajouté');
        header('Location:articles.php?id='.$idArticle);
    
            
    }

/* 4. Afficher ou traiter l'enregistrement */
  
}
catch(PDOException $e){
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('../frontOffice/template/layout.phtml'); 

?>
