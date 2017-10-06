<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$filter = $_GET['gemeente'];
$artikelnummer = $_GET['artikelnummer'];
$familienaam = $_GET['familienaam'];
$voornaam = $_GET['voornaam'];
$beroepsgroep = $_GET['beroepsgroep'];
$result="";

foreach ($lijstenController->getArtikelnummersBeroepsgroepFilter($filter,$artikelnummer,$familienaam,$voornaam,$beroepsgroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>