<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$laag = $_GET['laag'];
$omgeving = $_GET['omgeving'];
$result="false";

$result = $lijstenController->isTijdAanwezig($omgeving,$laag);
echo $result;

?>
