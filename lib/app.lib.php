<?php

/** function addFlashBag
 * Ajoute une valeur au flashbag
 * @param string $texte
 * @return void
 */
function addFlashBag($texte,$level = 'success')
{
    if(!isset($_SESSION['flashbag']) || !is_array($_SESSION['flashbag']))
        $_SESSION['flashbag'] = array();

    $_SESSION['flashbag'][] = ['message'=>$texte, 'level'=>$level];
}

/** function getFlashBag
 * Ajoute une valeur au flashbag
 * @param void
 * @return array flashbag
 */
function getFlashBag()
{
    if(isset($_SESSION['flashbag']) && is_array($_SESSION['flashbag']))
    {
        $flashbag = $_SESSION['flashbag'];
        unset($_SESSION['flashbag']);
        return $flashbag;
    }
    return false;
}
?>