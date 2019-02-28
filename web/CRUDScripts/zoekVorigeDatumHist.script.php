<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
$layer = $_POST['selLg'];
$datum = $_GET['datum'];
$scheme = $_POST['schema'];
$result="";
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demTijdslijnController.php');
$tijdslijnController = new demTijdslijnController();

/*
if ($scheme === 'public'){
    echo $tijdslijnController->getVorigeDatumPercelen($layer,$datum,$scheme);
} else {
*/
    echo $tijdslijnController->getVorigeDatum($layer,$datum,$scheme);
//}
?>
