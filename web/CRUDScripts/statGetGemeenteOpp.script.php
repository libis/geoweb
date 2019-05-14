<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demStatisticsController.php');
$statController = new demStatisticsController();
$laag = $_POST['hoofdlaag'];
$statController->setOATView($laag[1]);


$gemeente = $_POST['selGem'];

$result="";

$result= $statController->getGemGrondbezit($gemeente);
echo $result;
?>
