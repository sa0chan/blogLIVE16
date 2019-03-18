<?php

session_start();

if(!isset($_SESSION['connected']) || $_SESSION['connected'] !== true )
header('Location:login.php');
//Create
$vue = 'index.phtml';

include('../config/config.php');
include('../lib/bdd.lib.php');


include('template/layout.phtml');

?>