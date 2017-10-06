<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$beroep = $_GET['beroep'];
$filter = $_GET['gemeente'];
$familienaam = $_GET['familienaam'];
$voornaam = $_GET['voornaam'];
$artikelnummer = $_GET['artikelnummer'];
$result="";

foreach ($lijstenController->getBeroepen($filter,$familienaam,$voornaam,$artikelnummer,$beroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
