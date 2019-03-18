<?php 

session_start();
include('../config/config.php');
include('../lib/bdd.lib.php');


$vue = 'editUsers.phtml';

try
{

/* 1 : Connexion au serveur de Base de Données */
    
   $dbh = connexionBdd();

 
/* 2 : Executer une requête */

// je vais chercher mon id d'article
    if (array_key_exists('id',$_GET)){
        
        $idUser= $_GET['id'];
        
 
    //fonction select de la bdd
     
        $sth2 = $dbh->prepare('SELECT u_nom, u_prenom, u_email, u_password ,u_valide, u_role FROM b_user WHERE u_id=:idUser');
        $sth2->bindValue(':idUser', $idUser , PDO::PARAM_INT);
        $sth2->execute();
        
    // injecter le select dans le form
        $result = $sth2->fetch(PDO::FETCH_ASSOC);
        
        $nom =$result['u_nom'];
        $prenom=$result['u_prenom'];
        $mail =$result['u_email'];
        $password = $result['u_password'];
        $valide =$result['u_valide'];
        $role =$result['u_role'];
        
        }
/* 4. traiter l'enregistrement */



    if (array_key_exists('nomForm',$_POST)){//on teste sur un des champs jamais sur submit
    
        $idUser = $_POST['id'];
        $newNom = $_POST['nomForm'];

        $newPrenom = $_POST['prenomForm'];

        $newMail = $_POST['email'];

        $newPassword = $_POST['password'];
    
        $newRole = $_POST['roleForm'];
        
        $newStatus = $_POST['statusForm'];
        
        $sth3 = $dbh->prepare('
        UPDATE b_user SET u_nom = :nom, u_prenom=:prenom ,u_email=:email, u_valide=:valide ,u_role=:role
        WHERE u_id = :idUser ');
        $sth3->bindValue(':nom',$newNom, PDO::PARAM_STR );
        $sth3->bindValue(':prenom',$newPrenom, PDO::PARAM_STR );
        $sth3->bindValue(':email',$newMail , PDO::PARAM_STR ); // erreur de format
        /*$sth3->bindValue(':password', $newPassword, PDO::PARAM_STR);*/
        $sth3->bindValue(':role', $newRole , PDO::PARAM_STR );
        $sth3->bindValue(':valide',$newStatus, PDO::PARAM_STR );
        $sth3->bindValue(':idUser',$idUser, PDO::PARAM_INT );
        
        $sth3->execute();
        
        header('Location:users.php');

    }
    
  
    }
    
catch(PDOException $e){
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}



include('../backOffice/template/layout.phtml'); 

?>
