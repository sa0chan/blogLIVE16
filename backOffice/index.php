<?php

session_start();

if(!isset($_SESSION['connected']) || $_SESSION['connected'] !== true )
header('Location:login.php');
//Create
$vue = 'index.phtml';


$sth1 = $dbh->prepare('SELECT * FROM b_categorie');
$sth1->execute();
$categories = $sth1->fetchALL(PDO::FETCH_ASSOC);

include('../config/config.php');
include('../lib/bdd.lib.php');


include('template/layout.phtml');

?>