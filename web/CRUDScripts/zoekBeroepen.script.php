<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
include_once(dirname(__FILE__).DS.'..'.DS.'db'.DS.'lijstenController.php');
$lijstenController = new lijstenController();

$laag = $_POST['hoofdlaag'];
$lijstenController->setOATView($laag[1]);
$filter = $_GET['beroep'];
$artikelnummers = $_POST['selArt'];
$familienaam = $_POST['selNm'];
$gemeente = $_POST['selGem'];
$voornaam = $_POST['selVnm'];
$beroep = $_POST['selBrp'];
$beroepsgroep = $_POST['selBgp'];
$woonplaats = $_POST['selWpl'];
$result="";

foreach ($lijstenController->getBeroepen($filter,$gemeente,$familienaam,$voornaam,$artikelnummer,$beroep,$beroepsgroep,$woonplaats) as $key => $value)
{
    if($result!="")
    {
        $result .= "%%";
    }
    $result .= $key."##".$value;
}
echo $result;

?>
