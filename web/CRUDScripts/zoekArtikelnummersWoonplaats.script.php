<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$filter = $_GET['gemeente'];
$artikelnummer = $_GET['artikelnummer'];
$familienaam = $_GET['familienaam'];
$voornaam = $_GET['voornaam'];
$woonplaats = $_GET['woonplaats'];
$result="";

foreach ($lijstenController->getArtikelnummersWoonplaatsFilter($filter,$artikelnummer,$familienaam,$voornaam,$woonplaats) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>