<?php
$vue = 'categories.phtml';


/*session_start();
*/
include('../config/config.php');
include('../lib/bdd.lib.php');
include('../lib/app.lib.php');


try
{


    $idCat=$_GET['id'];
/* 1 : Connexion au serveur de Base de Données */
    
    $dbh = connexionBdd();

    $sth1 = $dbh->prepare('SELECT * FROM b_article INNER JOIN b_user ON b_user.u_id = b_article.a_auteur where b_categorie_c_id =:idCat');
    $sth1->bindValue(':idCat', $idCat);
    $sth1->execute();
    
    $articles = $sth1->fetchAll(PDO::FETCH_ASSOC);
    
    $sth2 = $dbh->prepare('SELECT * FROM b_categorie where c_id=:idCat');
    $sth2->bindValue(':idCat', $idCat);
    $sth2->execute();
    $hereCat = $sth2->fetch(PDO::FETCH_ASSOC);
    
    
    $sth3 = $dbh->prepare('SELECT * FROM b_categorie');
    $sth3->execute();
    $categories = $sth3->fetchAll(PDO::FETCH_ASSOC);
   
}
catch(PDOException $e)
{
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('template/layout.phtml'); 
?>