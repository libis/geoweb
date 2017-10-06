<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$voornaam = $_GET['voornaam'];
$filter = $_GET['gemeente'];
$familienaam = $_GET['familienaam'];
$artikelnummer = $_GET['artikelnummer'];
$woonplaats = $_GET['woonplaats'];
$result="";

foreach ($lijstenController->getVoornamenWoonplaatsFilter($filter,$voornaam,$familienaam,$artikelnummer,$woonplaats) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
