<?php
session_start();

if(!isset($_SESSION['connected']) || $_SESSION['connected'] !== true )
{
    header('Location:login.php');
    exit();
}

include('../config/config.php');
include('../lib/bdd.lib.php');
include('../lib/app.lib.php');


$vue = 'addCategorie.phtml';


$newTitreForm  ='';
$idCat='';


//verification que le users a bien cliqué et mise des données dans variable


try
{

/* 1 : Connexion au serveur de Base de Données */
    
   $dbh = connexionBdd();

 
/* 2 : Executer une requête */


   
// je vais chercher mon formulaire et l'injecter dans ma bdd
if (array_key_exists('nomForm',$_POST)){//on teste sur un des champs jamais sur submit
        

    $newTitreForm = $_POST['nomForm'];
     
   
//fonction mettre dans bdd
 
    $sth2 = $dbh->prepare('INSERT INTO b_categorie (c_title) VALUES (:nom)');
    $sth2->bindValue(':nom', $newTitreForm, PDO::PARAM_STR);

    $sth2->execute();
    
    addFlashBag('La categrorie a bien été ajoutée');
    header('Location:categorie.php');
    exit();
            
}

/* 4. Afficher ou traiter l'enregistrement */
  
}
catch(PDOException $e){
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('../backOffice/template/layout.phtml'); 

?>
