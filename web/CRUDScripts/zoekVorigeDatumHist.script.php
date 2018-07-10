<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
$layer = $_POST['selLg'];
$datum = $_GET['datum'];

$result="";
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demTijdslijnController.php');
$tijdslijnController = new demTijdslijnController();

echo $tijdslijnController->getVorigeDatum($layer,$datum);
?>
