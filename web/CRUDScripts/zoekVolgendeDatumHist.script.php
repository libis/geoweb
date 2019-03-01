<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
$layer = $_POST['laag'];
$datum = $_GET['datum'];
$scheme = $_POST['schema'];
$result="";
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demTijdslijnController.php');
$tijdslijnController = new demTijdslijnController();

if ($scheme === 'public'){
    $result =  $tijdslijnController->getVolgendeDatumPercelen($layer,$datum,$scheme);
} else {
    $result =  $tijdslijnController->getVolgendeDatum($layer,$datum,$scheme);
}
echo $result;
?>    
    
    
    
?>