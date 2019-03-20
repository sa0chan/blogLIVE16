<?php
/*session_start();

*/
include('../config/config.php');
include('../lib/bdd.lib.php');
include('../lib/app.lib.php');

$vue = 'articles.phtml';


/*try
{
  */  
    

/* 1 : Connexion au serveur de Base de Données */
    
    $dbh = connexionBdd();
   
    $sth1 = $dbh->prepare('SELECT *  FROM b_comment WHERE c_article =:idArticle');
    $sth1->bindValue(':idArticle', $idArticle);
    $sth1->execute();
    $commentaires = $sth1->fetchAll(PDO::FETCH_ASSOC);
    var_dump('gnagna');
  /*  $commentaire=$commentaires['c_contenu'];
    $pseudo=$commentaires['c_pseudo'];
    $email=$commentaires['c_email'];
    $date=$commentaires['c_date_publi'];
    $dateConverted = date("d F Y H:i", strtotime($date));
    $idArticle = $_GET['id'];
    */
    // header('Location:articles.php?id='.$idArticle);
    
    
/*}
catch(PDOException $e)
{
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}*/


include('template/layout.phtml'); 
?>