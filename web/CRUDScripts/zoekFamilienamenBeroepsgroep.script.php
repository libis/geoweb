<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$familienaam = $_GET['familienaam'];
$filter = $_GET['gemeente'];
$artikelnummer = $_GET['artikelnummer'];
$voornaam = $_GET['voornaam'];
$beroepsgroep = $_GET['beroepsgroep'];
$result="";

foreach ($lijstenController->getFamilenamenBeroepsgroepFilter($filter,$familienaam,$voornaam,$artikelnummer,$beroepsgroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
