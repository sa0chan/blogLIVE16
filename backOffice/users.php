<?php
session_start();
if(!isset($_SESSION['connected']) || $_SESSION['connected'] !== true )
header('Location:login.php');

include('../config/config.php');
include('../lib/bdd.lib.php');
include('../lib/app.lib.php');




$vue = 'users.phtml';


try
{

/* 1 : Connexion au serveur de Base de Données */
    
    $dbh = connexionBdd();
   
    $sth1 = $dbh->prepare('SELECT * FROM b_user');
    $sth1->execute();
    $flashbag = getFlashBag();
    $utilisateurs = $sth1->fetchAll(PDO::FETCH_ASSOC);
    
    
    

}
catch(PDOException $e)
{
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}


include('template/layout.phtml'); 
?>