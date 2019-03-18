<?php

/**
 * CONFIGURATION
 */
const DB_SGBD = 'mysql';
const DB_SGBD_URL = 'localhost';
const DB_DATABASE = '';
const DB_CHARSET = '';
const DB_USER = '';
const DB_PASSWORD = '';

//pour le chemin du transfert d'image
const UPLOADS_URL = '';

//Répertoire chemin complet vers le blog (pour l'upload)
define('UPLOADS_DIR', realpath(dirname(__FILE__)."/../").'/img/upload/');