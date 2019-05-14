<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'demMapController.php');
$demMapController = new demMapController();
$laag = $_POST['hoofdlaag'];
$demMapController->setOATView($laag[1]);
$gemeente = $_POST['selGem'];
$naam = $_POST['selNm'];
$voornaam = $_POST['selVnm'];
$artikelnr = $_POST['selArt'];
$woonplaats = $_POST['selWpl'];
$result="";

foreach ($demMapController->getWoonplaatsEigenaars($gemeente,$naam,$voornaam,$artikelnr,$woonplaats) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>