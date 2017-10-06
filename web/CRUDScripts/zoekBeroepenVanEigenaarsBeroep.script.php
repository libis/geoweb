<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demMapController.php');
$demMapController = new demMapController();


$gemeente = $_GET['gemeente'];
$naam = $_GET['naam'];
$voornaam = $_GET['voornaam'];
$artikelnr = $_GET['artikelnr'];
$result="";

foreach ($demMapController->getBeroepEigenaars($gemeente,$naam,$voornaam,$artikelnr) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>