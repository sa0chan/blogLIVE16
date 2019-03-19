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
$articles="";

try
{

/* 1 : Connexion au serveur de Base de Données */
    
    $dbh = connexionBdd();
   
    $sth1 = $dbh->prepare('SELECT * FROM b_article inner join b_user on a_auteur=u_id left join b_categorie on b_categorie_c_id = c_id');
    $sth1->execute();
    
    $flashbag = getFlashBag();
    $articles = $sth1->fetchAll(PDO::FETCH_ASSOC);
    
    

}
catch(PDOException $e)
{
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}


include('template/layout.phtml'); 
?>