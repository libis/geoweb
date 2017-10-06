<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$familienaam = $_GET['familienaam'];
$filter = $_GET['gemeente'];
$artikelnummer = $_GET['artikelnummer'];
$voornaam = $_GET['voornaam'];
$result="";

foreach ($lijstenController->getFamilenamenFilter($filter,$familienaam,$voornaam,$artikelnummer) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
