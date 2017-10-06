<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();


$voornaam = $_GET['voornaam'];
$filter = $_GET['gemeente'];
$familienaam = $_GET['familienaam'];
$artikelnummer = $_GET['artikelnummer'];
$beroep = $_GET['beroep'];
$result="";

foreach ($lijstenController->getVoornamenBeroepFilter($filter,$voornaam,$familienaam,$artikelnummer,$beroep) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
