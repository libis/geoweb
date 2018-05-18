<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demMapController.php');
$demMapController = new demMapController();


$gemeente = $_POST['selGem'];
$naam = $_POST['selNm'];
$voornaam = $_POST['selVnm'];
$artikelnr = $_POST['selArt'];
$beroepsgroep = $_POST['selBgp'];
$result="";

foreach ($demMapController->getBeroepsgroepEigenaars($gemeente,$naam,$voornaam,$artikelnr,$beroepsgroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;
?>