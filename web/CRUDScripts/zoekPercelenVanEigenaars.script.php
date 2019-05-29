<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demMapController.php');
$demMapController = new demMapController();
$laag = $_POST['hoofdlaag'];
$demMapController->setOATView($laag[1]);

$gemeente = $_POST['selGem'];
$naam = $_POST['selNm'];
$artikelnr = $_POST['selArt'];
$voornaam = $_POST['selVnm'];
$beroep = $_POST['selBrp'];
$beroepsgroep = $_POST['selBgp'];
$woonplaats = $_POST['selWpl'];

$result="";

foreach ($demMapController->getEigenaars($gemeente,$naam,$voornaam,$artikelnr,$beroep,$beroepsgroep,$woonplaats) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>