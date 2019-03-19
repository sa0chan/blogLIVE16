<?php
session_start();
if(!isset($_SESSION['connected']) || $_SESSION['connected'] !== true )
header('Location:login.php');

include('../config/config.php');
include('../lib/bdd.lib.php');


$vue = 'addUsers.phtml';


$newNom = '';

$newPrenom = '';

$newMail = '';

$newPassword = '';

$newRole = '';

$newStatus = '';
    

//verification que le users a bien cliqué et mise des données dans variable


try
{

/* 1 : Connexion au serveur de Base de Données */
    
   $dbh = connexionBdd();

 
/* 2 : Executer une requête */


   
// je vais chercher mon formulaire et l'injecter dans ma bdd
    if (array_key_exists('prenomForm',$_POST)){//on teste sur un des champs jamais sur submit
        
     var_dump($_POST);
        $newNom = $_POST['nomForm'];
       
        $newPrenom = $_POST['prenomForm'];

        $newMail = $_POST['email'];

        $newPassword = $_POST['password'];
        //cryptage du password
        
        $cryptedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        $newRole = $_POST['roleForm'];
        
        $newStatus = $_POST['statusForm'];
            
       
   
//fonction mettre dans bdd
 
    $sth2 = $dbh->prepare('INSERT INTO b_user (u_nom, u_prenom, u_email, u_password ,u_valide, u_role) VALUES (:nom,:prenom,:mail,:password,:status,:role)');
    $sth2->bindValue(':nom', $newNom, PDO::PARAM_STR);
    $sth2->bindValue(':prenom',$newPrenom, PDO::PARAM_STR);
    $sth2->bindValue(':mail',$newMail, PDO::PARAM_STR);
    
    $sth2->bindValue(':password',$cryptedPassword, PDO::PARAM_STR);
    $sth2->bindValue(':status',$newStatus, PDO::PARAM_STR);
    $sth2->bindValue(':role',$newRole, PDO::PARAM_STR);
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
