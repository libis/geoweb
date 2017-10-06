<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$beroepsgroep = $_GET['beroepsgroep'];
$filter = $_GET['gemeente'];
$familienaam = $_GET['familienaam'];
$voornaam = $_GET['voornaam'];
$artikelnummer = $_GET['artikelnummer'];
$result="";

foreach ($lijstenController->getBeroepsgroepen($filter,$familienaam,$voornaam,$artikelnummer,$beroepsgroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
