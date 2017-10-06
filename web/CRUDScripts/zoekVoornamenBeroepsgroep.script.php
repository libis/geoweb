<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$voornaam = $_GET['voornaam'];
$filter = $_GET['gemeente'];
$familienaam = $_GET['familienaam'];
$artikelnummer = $_GET['artikelnummer'];
$beroepsgroep = $_GET['beroepsgroep'];
$result="";

foreach ($lijstenController->getVoornamenBeroepsgroepFilter($filter,$voornaam,$familienaam,$artikelnummer,$beroepsgroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
