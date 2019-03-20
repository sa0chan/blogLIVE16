<?php
/*session_start();*/

include('../config/config.php');
include('../lib/bdd.lib.php');
include('../lib/app.lib.php');

$vue = 'articles.phtml';
$titre='';
$date='';
$articles = '';
$prenom = '';
$nom = '';
$contenu = '';
$date='';
$idArticle='';
$image=NULL;
try
{
    $idArticle = $_GET['id'];
    //var_dump($idArticle);

/* 1 : Connexion au serveur de Base de Données */
    
    $dbh = connexionBdd();
//ARTICLE   
    $sth1 = $dbh->prepare('SELECT * FROM b_article INNER JOIN b_user ON b_user.u_id = b_article.a_auteur WHERE a_id=:idArticle');
    $sth1->bindValue(':idArticle', $idArticle);
    $sth1->execute();
    
    $articles = $sth1->fetch(PDO::FETCH_ASSOC);
    $titre = $articles['a_titre'];
    $date = $articles['a_date_publication'];
    $dateConverted = date("d F Y H:i", strtotime($date));
    $prenom = $articles['u_prenom'];
    $nom = $articles['u_nom'];
    $contenu = $articles['a_contenu'];
   
   
    if ($articles['a_image'] == NULL){
        $image='nophoto.jpeg';
    }else{
        
    $image = $articles['a_image'];
        
    }
    
//COMMENTAIRES

    $sth2 = $dbh->prepare('SELECT *  FROM b_comment WHERE c_article =:idArticle');
    $sth2->bindValue(':idArticle', $idArticle);
    $sth2->execute();
    $commentaires = $sth2->fetchAll(PDO::FETCH_ASSOC);

}
catch(PDOException $e)
{
    
    $vue= 'erreur.phtml';

    $messageErreur = 'Une erreur s\'est produite : '.$e->getMessage();
}

include('template/layout.phtml'); 
?>