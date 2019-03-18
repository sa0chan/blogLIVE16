<?php
session_start();
include('../config/config.php');
include('../lib/bdd.lib.php');


$vue = 'addArticle.phtml';


$newTitreForm  ='';
$newCategorie ='';
$newArticle = '';
$newImage ='';
$idUser=1;
$newDate = '';
$idCat='';


//verification que le users a bien cliqué et mise des données dans variable


try
{

/* 1 : Connexion au serveur de Base de Données */
    
   $dbh = connexionBdd();

 
/* 2 : Executer une requête */


//je récupére les catégorie de ma bdd
    $sth1 = $dbh->prepare('SELECT c_title, c_id FROM b_categorie');
    $sth1->execute();
    $categories = $sth1->fetchAll(PDO::FETCH_BOTH);//BOTH permet d'attribuer un index numeroté a chaque 
    //var_dump($categories);


   
// je vais chercher mon formulaire et l'injecter dans ma bdd
    if (array_key_exists('articleForm',$_POST)){//on teste sur un des champs jamais sur submit
        
            
        //$idUser = $_POST[''];
        $newTitreForm = $_POST['titreForm'];
       
        $newCategorie = $_POST['categorie'];

        $newArticle = $_POST['articleForm'];

        $newDate = new DateTime($_POST['dateForm']);
    
        $pictureArticle = null;
// récup l'image

// Importation des images


            if(array_key_exists('inserImageForm', $_FILES)) { // Les inputs de type "files" (dans le HTML) renvoient des données dans le tableau "FILES"
              var_dump($_FILES['inserImageForm']); // Ce tableau renvoie les données "name", "type", "tmp_name" (dossier temporaire ou sera placée l'image), "error" (0 )
            }
            /* Récupérer l'image et la déplacer ! */
            if ($_FILES["inserImageForm"]["error"] == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["inserImageForm"]["tmp_name"];
                // basename() peut empêcher les attaques de système de fichiers;
                // la validation/assainissement supplémentaire du nom de fichier peut être approprié
                $pictureArticle = uniqid().'-'.basename($_FILES["inserImageForm"]["name"]);
                move_uploaded_file($tmp_name, UPLOADS_DIR.$pictureArticle);
            } else {
                $errorForm = 'Une erreur s\'est produite lors de l\'upload de l\'image !';
            } 
            
            
       
   
//fonction mettre dans bdd
 
    $sth2 = $dbh->prepare('INSERT INTO b_article (a_auteur,a_titre,b_categorie_c_id,a_date_publication,a_contenu,a_image) VALUES (:user,:titre,:categorie,:datePubli,:contenu,:imageArticle)');
    $sth2->bindValue(':user', $idUser, PDO::PARAM_INT);
    $sth2->bindValue(':titre',$newTitreForm, PDO::PARAM_STR);
    $sth2->bindValue(':categorie',$newCategorie, PDO::PARAM_INT);
    $sth2->bindValue(':datePubli',$newDate->format('Y-m-d H:i:s'));
    $sth2->bindValue(':contenu',$newArticle, PDO::PARAM_STR);
    $sth2->bindValue(':imageArticle',$pictureArticle, PDO::PARAM_STR );
    $sth2->execute();
    
   header('Location:article.php');
    
            
    }

/* 4. Afficher ou traiter l'enregistrement */
  
}
catch(PDOException $e){
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('../backOffice/template/layout.phtml'); 

?>
