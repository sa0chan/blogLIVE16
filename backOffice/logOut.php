<?php
//lance un session fonction déjà prédéfinie

session_start();
if(!isset($_SESSION['connected']) || $_SESSION['connected'] !== true )
    header('Location:login.php');

// Détruit toutes les variables de session
$_SESSION['connected'] = false;
unset($_SESSION['connected']);
unset($_SESSION['user']);

// INUTILE DANS CE CONTEXTE !
// Si vous voulez détruire complètement la session, effacez également
// le cookie de session.
// Note : cela détruira la session et pas seulement les données de session !
/*if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}*/

// Finalement, on détruit la session.
//session_destroy();

//echo'<h4 class="text-danger" >Vous êtes deconnecté</h4>';

header('Location:login.php');
//include('../backOffice/template/login.phtml');
?>




