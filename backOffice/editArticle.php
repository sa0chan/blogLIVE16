<?php 

session_start();
include('../config/config.php');
include('../lib/bdd.lib.php');


$vue = 'editArticle.phtml';



try
{

/* 1 : Connexion au serveur de Base de Données */
    
   $dbh = connexionBdd();

 
/* 2 : Executer une requête */


   
// je vais chercher mon id d'article
    if (array_key_exists('id',$_GET)){
        
        $idArticle= $_GET['id'];

        
        
//je récupére les catégorie de ma bdd
        $sth1 = $dbh->prepare('SELECT c_title, c_id FROM b_categorie');
        $sth1-> execute();
        $categories = $sth1->fetchAll(PDO::FETCH_BOTH);//BOTH permet d'attribuer un index numeroté a chaque 
        //var_dump($categories);
    
    //fonction select de la bdd
     
        $sth2 = $dbh->prepare('SELECT a_auteur, a_titre, b_categorie_c_id, a_date_publication, a_contenu, a_image FROM b_article WHERE a_id=:idArticle');
        $sth2->bindValue(':idArticle', $idArticle , PDO::PARAM_INT);
        $sth2->execute();
        
    // injecter le select dans le form
        $result = $sth2->fetch(PDO::FETCH_ASSOC);
        
        
        $titre =$result['a_titre'];
        $cat=$result['b_categorie_c_id'];
        $date =$result['a_date_publication'];
        $contenu = $result['a_contenu'];
        $image =$result['a_image'];
        
        $pictureArticle = isset($image)?$image:null; //On met l'image à NULL en attendant de voir si une image est transmise
     
        
        }
/* 4. traiter l'enregistrement */

/*var_dump($_POST);*/

            if (array_key_exists('articleForm',$_POST)){//on teste sur un des champs jamais sur submit
            
                $idArticle = $_POST['id'];
                $newTitreForm = $_POST['titreForm'];
               
                $newCategorie = $_POST['categorie'];
        
                $newArticle = $_POST['articleForm'];
    
                $newDate = $_POST['dateForm'];
                
                $pictureArticle = isset($_POST['oldImage'])?$_POST['oldImage']:null; //On met l'image à NULL en attendant de voir si une image est transmise ! 


//ne pas mettre d'image

        
                //fonction supprimer du dossier upload
                 if (array_key_exists('erase',$_POST)){
                    $sth4 = $dbh->prepare('SELECT a_image FROM `b_article` WHERE a_id =:idArticle');
                    $sth4->bindValue(':idArticle', $idArticle);
                    $sth4->execute();
                    
                    $result = $sth4->fetch(PDO::FETCH_ASSOC);
                    $img = $result['a_image'];
            
                    var_dump($img);
                    if (file_exists(UPLOADS_DIR.$img)){
                        unlink(UPLOADS_DIR.$img);
                    }
            
                    //fonction supprimer de la bdd
                 
                    $sth5 = $dbh->prepare('DELETE a_image=:imgFROM `b_article` WHERE a_id =:idArticle');
                    $sth5->bindValue(':idArticle', $idArticle);
                    $sth5->bindValue(':img', $img);
                    $sth5->execute();
                    
                 }
      
    
 
 // Importation des images


            if(array_key_exists('inserImageForm', $_FILES)) { // Les inputs de type "files" (dans le HTML) renvoient des données dans le tableau "FILES"
              var_dump($_FILES['inserImageForm']); // Ce tableau renvoie les données "name", "type", "tmp_name" (dossier temporaire ou sera placée l'image), "error" (0 )
            }
            /* Récupérer l'image et la déplacer ! */
            if ($_FILES["inserImageForm"]["error"] == UPLOAD_ERR_OK) {
                var_dump('image upload');
                $tmp_name = $_FILES["inserImageForm"]["tmp_name"];
                // basename() peut empêcher les attaques de système de fichiers;
                // la validation/assainissement supplémentaire du nom de fichier peut être approprié
                $pictureArticle = uniqid().'-'.basename($_FILES["inserImageForm"]["name"]);
                move_uploaded_file($tmp_name, UPLOADS_DIR.$pictureArticle);
            } else {
                $errorForm = 'Une erreur s\'est produite lors de l\'upload de l\'image !';
            } 

       
                $sth3 = $dbh->prepare('
                UPDATE b_article SET a_titre = :titre, a_date_publication=:datePubli , a_contenu=:contenu, a_image=:imageArticle, b_categorie_c_id=:categorie 
                WHERE a_id = :idArticle ');
                $sth3->bindValue(':titre',$newTitreForm, PDO::PARAM_STR );
                $sth3->bindValue(':categorie',$newCategorie, PDO::PARAM_INT);
                $sth3->bindValue(':datePubli',$newDate ); // erreur de format
                $sth3->bindValue(':contenu',$newArticle, PDO::PARAM_STR);
                $sth3->bindValue(':idArticle', $idArticle , PDO::PARAM_INT);
                $sth3->bindValue(':imageArticle',$pictureArticle, PDO::PARAM_STR );
                
                $sth3->execute();
                
                header('Location:article.php');
    
            }
            
        
    /** On vérifie si l'image existe sur le disque pour la passer à la vue */
    if(file_exists(UPLOADS_DIR.'articles/'.$pictureArticle) && $pictureArticle != null)
        $pictureDisplay = true;
    }
    
catch(PDOException $e){
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}



include('../backOffice/template/layout.phtml'); 

?>
