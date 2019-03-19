<?php
session_start();
//lance un session fonction déjà prédéfinie



include('../config/config.php');
include('../lib/bdd.lib.php');
include('../lib/app.lib.php');


$vue = 'login.phtml';
$erreur = NULL;


if(isset($_SESSION['connected']) && $_SESSION['connected'] === true)
    header('Location:index.php');

//si l'utilisateur a les droits alors il peut se connecter

/*

$_SESSION ['connected'] = true;
$_SESSION ['user'] = [ 'id'=> '1', 'prenom'=>'Sarah'];
*/
/* 1 : Connexion au serveur de Base de Données */
try
{

    $dbh = connexionBdd();
    $utilisateurs = $dbh->prepare('SELECT *  FROM b_user');

    // post
     if (array_key_exists('mail',$_POST)){
      
         $email= $_POST['mail'];
         $password = $_POST['password'];
        /*var_dump('etape complete');*/
        
        
        
        // GESTION DES ERREURS DE SAISIE
        if($_POST['mail'] == '') {
          $erreur = $erreur . 'Veuilez remplir votre email<br>'; // Message d'erreur
        }
        if($_POST['password'] == '') {
          $erreur = $erreur . 'Veuilez remplir votre mot de passe<br>'; // Message d'erreur
        }
        
        
        //si il n'y a pas d'erreur alors il faut rechercher l'utilisateur par son mail
        if($erreur == NULL) {
            $sth1 = $dbh->prepare('SELECT *  FROM b_user WHERE u_email=:email' ); // trouve l'utilisateur
            $sth1->bindValue(':email', $email);
            $sth1->execute();
            $utilisateur = $sth1->fetch(PDO::FETCH_ASSOC);
           /* var_dump($utilisateur);*/
        }
        
        
        
        // compare les mot de passe  avec password_verify — Vérifie qu'un mot de passe correspond à un hachage
        if (password_verify($_POST['password'], $utilisateur['u_password'])) {
            /*var_dump('connecté');*/
            //on demarre la session : 
            
            
            $_SESSION['connected'] = true;
            $_SESSION['user'] = ['id' => $utilisateur['u_id'], 'nom'=> $utilisateur['u_nom'], 'prenom' => $utilisateur['u_prenom'], 'role' => $utilisateur['u_role']];
            
            
            header("Location: ./index.php");  // redirection
        } else {
            $erreur = 'mot de passe incorrect';
        }
      
     }
}

catch(PDOException $e){
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('../backOffice/template/login.phtml'); 




?>

