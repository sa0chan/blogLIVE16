<?php


function uploadImg(formNameImg){
            if(array_key_exists(formNameImg, $_FILES)) { // Les inputs de type "files" (dans le HTML) renvoient des données dans le tableau "FILES"
              var_dump($_FILES[formNameImg]); // Ce tableau renvoie les données "name", "type", "tmp_name" (dossier temporaire ou sera placée l'image), "error" (0 )
            }
            /* Récupérer l'image et la déplacer ! */
            if ($_FILES[formNameImg]["error"] == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES[formNameImg]["tmp_name"];
                // basename() peut empêcher les attaques de système de fichiers;
                // la validation/assainissement supplémentaire du nom de fichier peut être approprié
                $pictureArticle = uniqid().'-'.basename($_FILES[formNameImg]["name"]);
                move_uploaded_file($tmp_name, UPLOADS_DIR.$pictureArticle);
            } else {
                $errorForm = 'Une erreur s\'est produite lors de l\'upload de l\'image !';
            } 
            
            var_dump (UPLOADS_URL);

}    


?>