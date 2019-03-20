<?php
$vue = 'index.phtml';


/*session_start();
*/
include('../config/config.php');
include('../lib/bdd.lib.php');
include('../lib/app.lib.php');


try
{

/* 1 : Connexion au serveur de Base de Données */
    
    $dbh = connexionBdd();
   
    $sth1 = $dbh->prepare('SELECT * FROM b_article INNER JOIN b_user ON b_user.u_id = b_article.a_auteur ');
    $sth1->execute();
    
    $articles = $sth1->fetchAll(PDO::FETCH_ASSOC);
    
    $sth2 = $dbh->prepare('SELECT * FROM b_categorie ');
    $sth2->execute();
    $categories = $sth2->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e)
{
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('template/layout.phtml'); 
?>